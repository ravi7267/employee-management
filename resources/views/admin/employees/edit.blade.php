@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Employee</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $employee->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $employee->email) }}" required>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $employee->phone) }}" required>
        </div>

        <div class="mb-3">
            <label>Joining Date</label>
            <input type="date" name="joining_date" class="form-control" value="{{ old('joining_date', $employee->joining_date) }}" required>
        </div>

        <div class="mb-3">
            <label>Department</label>
            <select name="department_id" class="form-control" required>
                @foreach ($departments as $dept)
                    <option value="{{ $dept->id }}" {{ $employee->department_id == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Profile Photo</label>
            @if ($employee->profile_photo)
                <div>
                    <img src="{{ asset('storage/' . $employee->profile_photo) }}" alt="Photo" width="100">
                </div>
            @endif
            <input type="file" name="profile_photo" class="form-control">
        </div>

        <button type="submit" class="button button-save">Update</button>
        <a href="{{ route('employees.index') }}" class="button button-cancel">Cancel</a>
    </form>
</div>
@endsection
