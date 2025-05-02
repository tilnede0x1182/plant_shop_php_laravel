@extends('layouts.app')
@section('content')
<div class="card shadow-lg rounded-3"><div class="card-body">
  <h1 class="card-title">{{ $plant->name }}</h1>
  <p><strong>Prix :</strong> {{ $plant->price }} €</p>
  <p><strong>Description :</strong> {{ $plant->description }}</p>
  <p><strong>Stock :</strong> {{ $plant->stock }} unités</p>
  <button class="btn btn-success rounded-3 mb-2" onclick="Cart.add({{ $plant->id }}, '{{ addslashes($plant->name) }}', {{ $plant->price }})">Ajouter au panier</button>
  @admin
    <a class="btn btn-warning rounded-3" href="{{ route('admin.plants.edit',$plant) }}">Modifier</a>
  @endadmin
  <a class="btn btn-secondary rounded-3" href="{{ route('plants.index') }}">Retour</a>
</div></div>
@endsection
