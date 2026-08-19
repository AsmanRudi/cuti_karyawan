<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $query = LeaveRequest::with(['employee.user', 'leaveType'])->latest();
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $leaveRequests = $query->paginate(10);
        
        return response()->json([
            'status' => 'success',
            'data' => $leaveRequests
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:APPROVED,REJECTED',
                'admin_notes' => 'nullable|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'error', 'message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        }

        $leaveRequest = LeaveRequest::find($id);
        
        if (!$leaveRequest) {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        }

        if ($leaveRequest->status !== 'PENDING') {
            return response()->json(['status' => 'error', 'message' => 'Pengajuan ini sudah diproses sebelumnya.'], 400);
        }

        DB::transaction(function () use ($request, $leaveRequest) {
            $leaveRequest->update([
                'status' => $request->status,
                'admin_notes' => $request->admin_notes,
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);
        });

        return response()->json(['status' => 'success', 'message' => 'Pengajuan cuti berhasil diproses']);
    }
}
