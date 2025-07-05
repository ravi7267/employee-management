@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Departments</h1>
    <a href="{{ route('departments.create') }}" class="button button-add">Add Department</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $department)
                <tr>
                    <td>{{ $department->name }}</td>
                    <td>{{ $department->status }}</td>
                    <td>
                        <a class="button button-edit" href="{{ route('departments.edit', $department) }}">Edit</a>
                        <form action="{{ route('departments.destroy', $department) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="button button-delete" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $departments->links() }}
</div>
@endsection
