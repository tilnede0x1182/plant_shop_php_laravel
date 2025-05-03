@extends('layouts.app')
@section('content')
<div class="card shadow-lg rounded-3">
	<div class="card-body">
		<h1 class="card-title">{{ $plant->name }}</h1>
		<p><strong>Prix :</strong> {{ $plant->price }} €</p>
		<p><strong>Description :</strong> {{ $plant->description }}</p>
		<p><strong>Stock :</strong> {{ $plant->stock }} unités</p>
		<div class="d-flex gap-2 flex-wrap mb-3">
			<button class="btn btn-success rounded-3" onclick="Cart.add({{ $plant->id }}, '{{ addslashes($plant->name) }}', {{ $plant->price }})">Ajouter au panier</button>
			@auth
			@if(Auth::user()->admin)
			<a class="btn btn-warning rounded-3" href="{{ route('admin.plants.edit',$plant) }}">Modifier</a>
			<form method="POST" action="{{ route('admin.plants.destroy', $plant) }}" onsubmit="return confirm('Supprimer ?')">
				@csrf @method('DELETE')
				<button class="btn btn-danger rounded-3">Supprimer</button>
			</form>
			@endif
			@endauth
		</div>

		<a class="btn btn-secondary rounded-3" href="{{ route('plants.index') }}">Retour</a>
	</div>
</div>
@endsection
