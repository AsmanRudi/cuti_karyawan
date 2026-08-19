<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LeaveController extends Controller
{
    public function index()
    {
        $employee = auth()->user()->employee;
        
        if (!$employee) {
            return response()->json(['status' => 'error', 'message' => 'Data pegawai tidak ditemukan'], 404);
        }

        $leaveRequests = $employee->leaveRequests()->with('leaveType')->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $leaveRequests
        ]);
    }

    public function quota()
    {
        $employee = auth()->user()->employee;
        
        if (!$employee) {
            return response()->json(['status' => 'error', 'message' => 'Data pegawai tidak ditemukan'], 404);
        }

        $usedLeave = $employee->leaveRequests()
            ->whereHas('leaveType', function($q) {
                $q->where('name', 'like', '%tahunan%')->orWhere('name', 'like', '%annual%');
            })
            ->where('status', 'APPROVED')
            ->sum('total_days');
            
        $remaining = max(0, $employee->annual_leave_quota - $usedLeave);

        return response()->json([
            'status' => 'success',
            'data' => [
                'total_quota' => $employee->annual_leave_quota,
                'used' => $usedLeave,
                'remaining' => $remaining,
            ]
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'leave_type_id' => 'required|exists:leave_types,id',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after_or_equal:start_date',
                'reason' => 'required|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        }

        $employee = auth()->user()->employee;
        if (!$employee || $employee->status !== 'ACTIVE') {
            return response()->json(['status' => 'error', 'message' => 'Akun pegawai tidak aktif/ditemukan.'], 403);
        }

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $totalDays = $startDate->diffInDays($endDate) + 1;

        $leaveType = LeaveType::findOrFail($request->leave_type_id);

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
            return response()->json(['status' => 'error', 'message' => 'Terdapat pengajuan cuti yang bertabrakan pada tanggal tersebut.'], 422);
        }

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
                return response()->json(['status' => 'error', 'message' => "Sisa kuota cuti tahunan tidak mencukupi (Sisa: {$remaining} hari)."], 422);
            }
        }

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

        return response()->json(['status' => 'success', 'message' => 'Pengajuan cuti berhasil dikirim'], 201);
    }
}
