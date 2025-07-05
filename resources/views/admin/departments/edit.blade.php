@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Department</h1>
    <form action="{{ route('departments.update', $department) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="{{ $department->name }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="active" {{ $department->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $department->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <button class="button button-save">Update</button>
                <a href="{{ route('departments.index') }}" class="button button-cancel">Cancel</a>

    </form>
</div>
@endsection
