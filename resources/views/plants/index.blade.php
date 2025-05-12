@extends('layouts.app')
@section('content')
    <h1 class="text-center mb-4">🌿 Liste des plantes</h1>
    @auth @if (Auth::user()->admin)
        <a class="btn btn-warning mb-3 rounded-3" href="{{ route('admin.plants.create') }}">Nouvelle plante</a>
    @endif @endauth
    <div class="row">
        @foreach ($plants as $plant)
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><a class="text-decoration-none text-dark"
                                href="{{ route('plants.show', $plant) }}">{{ $plant->name }}</a></h5>
                        <p class="card-text">
                            <strong>Prix :</strong> {{ $plant->price }} €
                            @auth
                                @if (Auth::user()->admin)
                                    <br><strong>Stock :</strong> {{ $plant->stock }}
                                @endif
                            @endauth
                        </p>
                        <button class="btn btn-success w-100 rounded-3"
                            onclick="window.Cart.add({{ $plant->id }}, '{{ addslashes($plant->name) }}', {{ $plant->price }}, {{ $plant->stock }})">
                            Ajouter au panier</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
