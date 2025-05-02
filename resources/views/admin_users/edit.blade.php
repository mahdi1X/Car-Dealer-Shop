@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit Admin</h1>

    <form action="{{ route('admin_users.update', $admin_user->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin_users.form', ['admin_user' => $admin_user])
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin_users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
