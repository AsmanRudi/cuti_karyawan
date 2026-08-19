<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', now()->format('m'));
        $year = $request->input('year', now()->format('Y'));

        // Rekap Cuti per Departemen bulan ini
        $departmentStats = Employee::select('department')
            ->selectRaw('COUNT(employees.id) as total_employees')
            ->selectRaw('SUM(CASE WHEN leave_requests.status = "APPROVED" THEN leave_requests.total_days ELSE 0 END) as total_leave_days')
            ->leftJoin('leave_requests', function($join) use ($month, $year) {
                $join->on('employees.id', '=', 'leave_requests.employee_id')
                     ->whereMonth('leave_requests.start_date', $month)
                     ->whereYear('leave_requests.start_date', $year);
            })
            ->groupBy('department')
            ->get();

        // Tren Jenis Cuti
        $leaveTypeStats = LeaveRequest::select('leave_type_id', DB::raw('COUNT(id) as count'))
            ->with('leaveType')
            ->whereMonth('start_date', $month)
            ->whereYear('start_date', $year)
            ->where('status', 'APPROVED')
            ->groupBy('leave_type_id')
            ->get();

        return view('admin.reports.index', compact('departmentStats', 'leaveTypeStats', 'month', 'year'));
    }
}
