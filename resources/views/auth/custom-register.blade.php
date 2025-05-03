@extends('layouts.app')

@section('content')
<h1>Inscription</h1>
<form method="POST" action="{{ route('register') }}" class="w-100" style="max-width: 500px">
    @csrf

    <div class="mb-3">
        <label class="form-label">Nom</label>
        <input name="name" type="text" class="form-control" value="{{ old('name') }}" required autofocus>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input name="email" type="email" class="form-control" value="{{ old('email') }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Mot de passe</label>
        <input name="password" type="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Confirmation</label>
        <input name="password_confirmation" type="password" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">S’inscrire</button>
</form>
@endsection
