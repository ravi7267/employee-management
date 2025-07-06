@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Employees</h1>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-bottom: 15px;">
        <a href="{{ route('employees.export') }}" class="button button-export">Export to Excel</a>
        <a href="{{ route('employees.create') }}" class="button button-add">Add Employee</a>
    </div>

    <div style="margin-bottom: 20px;">
        <label for="departmentFilter">Filter by Department:</label>
        <select id="departmentFilter">
            <option value="">All Departments</option>
            @foreach ($departments as $dept)
                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
            @endforeach
        </select>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Sr No.</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Joining Date</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="employeeTableBody">
            @forelse ($employees as $employee)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if ($employee->profile_photo)
                            <img src="{{ asset('storage/' . $employee->profile_photo) }}" alt="Photo" width="50">
                        @endif
                    </td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td>{{ $employee->joining_date }}</td>
                    <td>{{ $employee->department->name ?? '-' }}</td>
                    <td>
                        <a class="button button-edit" href="{{ route('employees.edit', $employee) }}">Edit</a>
                        <form action="{{ route('employees.destroy', $employee) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                        <button type="button" class="button button-delete" onclick="showDeleteModal(this)">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No employees found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div id="deleteModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999;">
    <div style="background:#fff; max-width:400px; margin:100px auto; padding:20px; border-radius:5px; position:relative;">
        <h3>Confirm Delete</h3>
        <p>Are you sure you want to delete this employee?</p>
        <div style="text-align:right;">
            <button id="cancelDelete" style="margin-right:10px;" class="button button-cancel">Cancel</button>
            <button id="confirmDelete" class="button button-delete">Delete</button>
        </div>
    </div>
</div>

    {{ $employees->links() }}
</div>

<script>
document.getElementById('departmentFilter').addEventListener('change', function () {
    const deptId = this.value;
    fetch('/api/employees' + (deptId ? '?department_id=' + deptId : ''))
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('employeeTableBody');
            tbody.innerHTML = '';

            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8">No employees found.</td></tr>';
                return;
            }

            data.forEach((employee, index) => {
                let photo = employee.profile_photo
                    ? `<img src="/storage/${employee.profile_photo}" width="50">`
                    : '';

                let department = employee.department ? employee.department.name : '-';

                tbody.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${photo}</td>
                        <td>${employee.name}</td>
                        <td>${employee.email}</td>
                        <td>${employee.phone}</td>
                        <td>${employee.joining_date}</td>
                        <td>${department}</td>
                        <td>
                            <a class="button button-edit" href="/admin/employees/${employee.id}/edit">Edit</a>
                            <form action="/admin/employees/${employee.id}" method="POST" style="display:inline;">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="button button-delete" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                `;
            });
        });
});

let formToDelete = null;

function showDeleteModal(button) {
    formToDelete = button.closest('form');
    document.getElementById('deleteModal').style.display = 'block';
}

//cancel
document.getElementById('cancelDelete').addEventListener('click', function () {
    document.getElementById('deleteModal').style.display = 'none';
    formToDelete = null;
});

// confirm
document.getElementById('confirmDelete').addEventListener('click', function () {
    if (formToDelete) {
        formToDelete.submit();
    }
});
</script>
@endsection
