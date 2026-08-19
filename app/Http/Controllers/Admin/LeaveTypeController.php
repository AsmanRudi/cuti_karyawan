<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = LeaveType::query();
        
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $leaveTypes = $query->paginate(10)->withQueryString();
        return view('admin.leavetypes.index', compact('leaveTypes'));
    }

    public function create()
    {
        return view('admin.leavetypes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'default_days' => ['required', 'integer', 'min:1'],
            'is_active' => ['boolean'],
        ]);

        LeaveType::create([
            'name' => $request->name,
            'description' => $request->description,
            'default_days' => $request->default_days,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.leavetypes.index')->with('success', 'Jenis cuti berhasil ditambahkan.');
    }

    public function edit(LeaveType $leaveType)
    {
        return view('admin.leavetypes.edit', compact('leaveType'));
    }

    public function update(Request $request, LeaveType $leaveType)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'default_days' => ['required', 'integer', 'min:1'],
        ]);

        $leaveType->update([
            'name' => $request->name,
            'description' => $request->description,
            'default_days' => $request->default_days,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('admin.leavetypes.index')->with('success', 'Jenis cuti berhasil diperbarui.');
    }

    public function destroy(LeaveType $leaveType)
    {
        $leaveType->update(['is_active' => false]);
        return redirect()->route('admin.leavetypes.index')->with('success', 'Jenis cuti dinonaktifkan.');
    }
}
