@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Create Admin</h1>

    <form action="{{ route('admin_users.store') }}" method="POST">
        @csrf
        @include('admin_users.form')
        <button type="submit" class="btn btn-success">Create</button>
        <a href="{{ route('admin_users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
