@extends('layouts.app')

@section('content')
<h1>Connexion</h1>
<form method="POST" action="{{ route('login') }}" class="w-100" style="max-width: 500px">
    @csrf
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input name="email" type="email" class="form-control" value="{{ old('email') }}" required autofocus>
    </div>
    <div class="mb-3">
        <label class="form-label">Mot de passe</label>
        <input name="password" type="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>
@endsection
