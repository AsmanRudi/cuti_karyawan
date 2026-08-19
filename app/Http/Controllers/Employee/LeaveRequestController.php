<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $employee = auth()->user()->employee;
        $leaveRequests = $employee ? $employee->leaveRequests()->latest()->paginate(10) : collect();
        return view('employee.leave_requests.index', compact('leaveRequests'));
    }

    public function create()
    {
        $leaveTypes = LeaveType::where('is_active', true)->get();
        return view('employee.leave_requests.create', compact('leaveTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'leave_type_id' => ['required', 'exists:leave_types,id'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['required', 'string'],
        ]);

        $employee = auth()->user()->employee;
        
        if (!$employee || $employee->status !== 'ACTIVE') {
            throw ValidationException::withMessages([
                'general' => 'Akun pegawai Anda tidak aktif atau tidak ditemukan.',
            ]);
        }

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $totalDays = $startDate->diffInDays($endDate) + 1; // Termasuk hari mulai dan akhir

        $leaveType = LeaveType::findOrFail($request->leave_type_id);

        // Check for overlapping dates
        $overlap = LeaveRequest::where('employee_id', $employee->id)
            ->whereIn('status', ['PENDING', 'APPROVED'])
            ->where(function($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate])
                      ->orWhere(function($q) use ($startDate, $endDate) {
                          $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                      });
            })->exists();

        if ($overlap) {
            throw ValidationException::withMessages([
                'start_date' => 'Terdapat pengajuan cuti yang bertabrakan pada tanggal tersebut.',
            ]);
        }

        // Only check quota for Annual Leave (assuming name contains 'Tahunan' or similar, but let's assume any leave uses quota if we don't have specific flags. Better yet, let's just assume the standard 'Cuti Tahunan' consumes quota. In the DB, there is no flag for 'deduct_quota'. I'll assume if it's not a special leave, it might. Let's make a simple logic: If name is 'Cuti Tahunan', check quota.)
        // Actually, the PRD just says "Validasi balance cuti". The employee has `annual_leave_quota`.
        // Let's assume all leaves deduct from `annual_leave_quota` unless we specifically want to handle sick leave differently. The design showed separate quotas, but DB only has `annual_leave_quota`.
        // Let's check quota for all leaves for simplicity, or just if the type name is "Cuti Tahunan" / "Annual".
        
        $isAnnualLeave = stripos($leaveType->name, 'tahunan') !== false || stripos($leaveType->name, 'annual') !== false;

        if ($isAnnualLeave) {
            $usedLeave = $employee->leaveRequests()
                ->whereHas('leaveType', function($q) {
                    $q->where('name', 'like', '%tahunan%')->orWhere('name', 'like', '%annual%');
                })
                ->where('status', 'APPROVED')
                ->sum('total_days');
                
            $remaining = $employee->annual_leave_quota - $usedLeave;

            if ($totalDays > $remaining) {
                throw ValidationException::withMessages([
                    'end_date' => "Sisa kuota cuti tahunan Anda tidak mencukupi. Sisa: {$remaining} hari.",
                ]);
            }
        }

        // Gunakan DB Transaction
        DB::transaction(function () use ($employee, $request, $totalDays) {
            LeaveRequest::create([
                'employee_id' => $employee->id,
                'leave_type_id' => $request->leave_type_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_days' => $totalDays,
                'reason' => $request->reason,
                'status' => 'PENDING',
            ]);
        });

        return redirect()->route('employee.dashboard')->with('success', 'Pengajuan cuti berhasil dikirim dan menunggu persetujuan.');
    }

    public function destroy(LeaveRequest $leaveRequest)
    {
        $employee = auth()->user()->employee;
        
        if ($leaveRequest->employee_id !== $employee->id) {
            abort(403, 'Unauthorized action.');
        }

        if ($leaveRequest->status !== 'PENDING') {
            return back()->with('error', 'Hanya pengajuan cuti berstatus PENDING yang dapat dibatalkan.');
        }

        $leaveRequest->update(['status' => 'CANCELLED']);

        return back()->with('success', 'Pengajuan cuti berhasil dibatalkan.');
    }
}
