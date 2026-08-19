<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with('user');

        if ($request->has('search') && $request->search != '') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            })->orWhere('employee_number', 'like', '%' . $request->search . '%');
        }

        if ($request->has('department') && $request->department != '') {
            $query->where('department', $request->department);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $employees = $query->paginate(10)->withQueryString();
        $departments = Employee::select('department')->distinct()->pluck('department');

        return view('admin.employees.index', compact('employees', 'departments'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'employee_number' => ['required', 'string', 'unique:employees'],
            'phone' => ['nullable', 'string', 'max:20'],
            'position' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'join_date' => ['required', 'date'],
            'annual_leave_quota' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:ACTIVE,INACTIVE'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'EMPLOYEE',
        ]);

        $user->employee()->create([
            'employee_number' => $request->employee_number,
            'phone' => $request->phone,
            'position' => $request->position,
            'department' => $request->department,
            'join_date' => $request->join_date,
            'annual_leave_quota' => $request->annual_leave_quota,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function edit(Employee $employee)
    {
        $employee->load('user');
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$employee->user->id],
            'employee_number' => ['required', 'string', 'unique:employees,employee_number,'.$employee->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'position' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'join_date' => ['required', 'date'],
            'annual_leave_quota' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:ACTIVE,INACTIVE'],
        ]);

        $employee->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => ['confirmed', Rules\Password::defaults()]]);
            $employee->user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $employee->update([
            'employee_number' => $request->employee_number,
            'phone' => $request->phone,
            'position' => $request->position,
            'department' => $request->department,
            'join_date' => $request->join_date,
            'annual_leave_quota' => $request->annual_leave_quota,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        $employee->update(['status' => 'INACTIVE']);
        return redirect()->route('admin.employees.index')->with('success', 'Pegawai dinonaktifkan.');
    }
}
