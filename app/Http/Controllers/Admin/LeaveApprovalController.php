<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaveApprovalController extends Controller
{
    public function index(Request $request)
    {
        $query = LeaveRequest::with(['employee.user', 'leaveType'])->latest();
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $leaveRequests = $query->paginate(10)->withQueryString();
        return view('admin.approvals.index', compact('leaveRequests'));
    }

    public function show(LeaveRequest $leaveRequest)
    {
        $leaveRequest->load(['employee.user', 'leaveType']);
        return view('admin.approvals.show', compact('leaveRequest'));
    }

    public function update(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate([
            'status' => ['required', 'in:APPROVED,REJECTED'],
            'admin_notes' => ['nullable', 'string'],
        ]);

        if ($leaveRequest->status !== 'PENDING') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        DB::transaction(function () use ($request, $leaveRequest) {
            $leaveRequest->update([
                'status' => $request->status,
                'admin_notes' => $request->admin_notes,
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            // Jika ada logika tambahan pengurangan kuota, bisa dilakukan di sini.
            // Namun perhitungan kuota cuti tahunan dilakukan secara dinamis berdasarkan status APPROVED saat dicek.
            // Bisa juga update kolom terpisah jika diinginkan, namun pendekatan dinamis lebih aman dari inkonsistensi.
        });

        return redirect()->route('admin.approvals.index')->with('success', 'Pengajuan cuti berhasil ' . ($request->status === 'APPROVED' ? 'disetujui' : 'ditolak') . '.');
    }
}
