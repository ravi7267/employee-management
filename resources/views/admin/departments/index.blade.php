@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Departments</h1>
      @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('departments.create') }}" class="button button-add">Add Department</a>
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
                            <button type="button" class="button button-delete" onclick="showDeleteModal(this)">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $departments->links() }}

    <!-- Delete  Modal -->
    <div id="deleteModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999;">
        <div style="background:#fff; max-width:400px; margin:100px auto; padding:20px; border-radius:5px; position:relative;">
            <h3>Confirm Delete</h3>
            <p>Are you sure you want to delete this Department?</p>
            <div style="text-align:right;">
                <button id="cancelDelete" style="margin-right:10px;" class="button button-cancel">Cancel</button>
                <button id="confirmDelete" class="button button-delete">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
let formToDelete = null;

function showDeleteModal(button) {
    formToDelete = button.closest('form');
    document.getElementById('deleteModal').style.display = 'block';
}

document.getElementById('cancelDelete').addEventListener('click', function () {
    document.getElementById('deleteModal').style.display = 'none';
    formToDelete = null;
});

document.getElementById('confirmDelete').addEventListener('click', function () {
    if (formToDelete) {
        document.getElementById('deleteModal').style.display = 'none'; // hide modal
        formToDelete.submit();
    }
});
</script>
@endsection
