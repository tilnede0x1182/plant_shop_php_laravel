@extends('layouts.app')
@section('content')
<h1>{{ $user->name }}</h1>
<p><strong>Email :</strong> {{ $user->email }}</p>
<p><strong>Admin :</strong> {{ $user->admin ? 'Oui' : 'Non' }}</p>
<a class="btn btn-warning rounded-3" href="{{ route('admin.users.edit',$user) }}">Modifier</a>
@endsection
