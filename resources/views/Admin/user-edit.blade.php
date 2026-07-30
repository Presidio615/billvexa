@extends('layouts.admin')

@section('title','Edit User')

@section('content')

<div class="card">

<div class="card-header">
<h4>Edit User</h4>
</div>

<div class="card-body">

<form method="POST" action="{{ route('admin.user.update',$user->id) }}">

@csrf
@method('PUT')

<div class="mb-3">

<label>Name</label>

<input
type="text"
name="name"
class="form-control"
value="{{ old('name',$user->name) }}">

</div>

<div class="mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
value="{{ old('email',$user->email) }}">

</div>

<div class="mb-3">

<label>Phone</label>

<input
type="text"
name="phone"
class="form-control"
value="{{ old('phone',$user->phone) }}">

</div>

<button class="btn btn-primary">

Update User

</button>

<a href="{{ route('admin.user') }}" class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

@endsection