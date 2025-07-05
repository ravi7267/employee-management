<?php

namespace App\Http\Controllers\Admin;
use App\Exports\EmployeesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
public function index(Request $request)
{
    // AJAX Filter request
    if ($request->has('department_id')) {
        $employees = Employee::with('department')
            ->where('department_id', $request->department_id)
            ->orderByDesc('created_at')
            ->get();

        return response()->json($employees);
    }

    // Normal page request
    $employees = Employee::with('department')->orderByDesc('created_at')->paginate(10);
    $departments = Department::all();

    return view('admin.employees.index', compact('employees', 'departments'));
}

    public function create()
    {
        $departments = Department::all();
        return view('admin.employees.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateEmployee($request);

        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo'] = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        Employee::create($validated);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function edit(Employee $employee)
    {
        $departments = Department::all();
        return view('admin.employees.edit', compact('employee', 'departments'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $this->validateEmployee($request, $employee->id);

        if ($request->hasFile('profile_photo')) {
            if ($employee->profile_photo) {
                Storage::disk('public')->delete($employee->profile_photo);
            }
            $validated['profile_photo'] = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        $employee->update($validated);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->profile_photo) {
            Storage::disk('public')->delete($employee->profile_photo);
        }
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    private function validateEmployee(Request $request, $id = null)
    {
        return $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:employees,email,' . $id,
            'phone'         => 'required|string|max:20',
            'joining_date'  => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'profile_photo' => 'nullable|image|max:2048',
        ]);
    }

public function export()
{
    return Excel::download(new EmployeesExport, 'employees.xlsx');
}
}
