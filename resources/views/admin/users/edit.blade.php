@extends('layouts.app')
@section('content')
<h1>Modifier l’utilisateur</h1>
<form method="POST" action="{{ route('admin.users.update',$user) }}">@csrf @method('PUT')
  <div class="mb-3"><label class="form-label">Nom</label><input class="form-control rounded-3" name="name" value="{{ old('name',$user->name) }}"></div>
  <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control rounded-3" name="email" value="{{ old('email',$user->email) }}"></div>
  <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="admin" id="isAdmin" {{ $user->admin?'checked':'' }}>
    <label class="form-check-label" for="isAdmin">Administrateur</label></div>
  <button class="btn btn-warning rounded-3">Enregistrer</button>
</form>
@endsection
