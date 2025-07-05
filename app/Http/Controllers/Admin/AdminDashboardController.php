<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Employee;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $departmentCount = Department::count();
        $employeeCount = Employee::count();
        $latestEmployees = Employee::with('department')->latest()->take(5)->get();

        return view('admin.dashboard', compact('departmentCount', 'employeeCount', 'latestEmployees'));
    }
}
