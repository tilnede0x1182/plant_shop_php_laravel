@extends('layouts.app')
@section('content')
<h1>Mon profil</h1>
<p><strong>Nom :</strong> {{ $user->name }}</p>
<p><strong>Email :</strong> {{ $user->email }}</p>
<a class="btn btn-warning rounded-3" href="{{ route('users.edit',$user) }}">Modifier</a>
@endsection
