@extends('layouts.admin')

@section('title', 'Add User')

@section('content')

<div class="container">

    <div class="card shadow-sm">

        <div class="card-header">
            <h4>Add New User</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.user.store') }}" method="POST">

                @csrf

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button class="btn btn-primary">
                    Create User
                </button>

            </form>

        </div>

    </div>

</div>

@endsection