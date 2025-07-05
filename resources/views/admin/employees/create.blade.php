@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Employee</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
        </div>

        <div class="mb-3">
            <label>Joining Date</label>
            <input type="date" name="joining_date" class="form-control" value="{{ old('joining_date') }}" required>
        </div>

        <div class="mb-3">
            <label>Department</label>
            <select name="department_id" class="form-control" required>
                <option value="">Select Department</option>
                @foreach ($departments as $dept)
                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Profile Photo</label>
            <input type="file" name="profile_photo" class="form-control">
        </div>

        <button type="submit" class="button button-save">Save</button>
        <a href="{{ route('employees.index') }}" class="button button-cancel">Cancel</a>
    </form>
</div>
@endsection
