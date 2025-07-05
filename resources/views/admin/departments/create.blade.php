@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Department</h1>
    <form action="{{ route('admin.departments.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <button class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
