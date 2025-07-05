@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>

    <div class="stats">
        <div class="stat-box">
            <h3>Total Departments</h3>
            <p>{{ $departmentCount }}</p>
        </div>
        <div class="stat-box">
            <h3>Total Employees</h3>
            <p>{{ $employeeCount }}</p>
        </div>
    </div>

    <h2>Latest 5 Employees</h2>
    <table>
        <thead>
            <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($latestEmployees as $employee)
                <tr>
                    <td>
                        @if ($employee->profile_photo)
                            <img src="{{ asset('storage/' . $employee->profile_photo) }}" width="50" alt="Profile">
                        @else
                            No Photo
                        @endif
                    </td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td>{{ $employee->department->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('employees.edit', $employee) }}" class="button button-edit">Edit</a>
                        <form action="{{ route('employees.destroy', $employee) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="button button-delete" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
document.getElementById('departmentFilter').addEventListener('change', function() {
    let departmentId = this.value;
    let url = '/api/employees';
    if (departmentId) {
        url += '?department_id=' + departmentId;
    }

    fetch(url)
        .then(res => res.json())
        .then(data => {
            // Update the table rows dynamically
            let tbody = document.querySelector('#employeeTable tbody');
            tbody.innerHTML = '';

            data.forEach(emp => {
                tbody.innerHTML += `
                    <tr>
                        <td>${emp.name}</td>
                        <td>${emp.email}</td>
                        <td>${emp.phone}</td>
                        <td>${emp.joining_date}</td>
                        <td>${emp.department ? emp.department.name : '-'}</td>
                        <td>
                            <a href="/admin/employees/${emp.id}/edit" class="button button-edit">Edit</a>
                            <form action="/admin/employees/${emp.id}" method="POST" style="display:inline;">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="button button-delete">Delete</button>
                            </form>
                        </td>
                    </tr>`;
            });
        });
});
</script>


@endsection
