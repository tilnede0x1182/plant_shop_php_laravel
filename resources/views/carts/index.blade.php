@extends('layouts.app')

@section('content')
  <h1 class="mb-4">🛒 Mon Panier</h1>
	@if(session('alert'))
  <div class="alert alert-danger">{{ session('alert') }}</div>
	@endif
	@if(session('stock_adjust'))
    <div class="alert alert-warning mt-2" role="alert"
         data-stock-adjust='@json(session('stock_adjust'))'>
        Stock ajusté automatiquement sur un ou plusieurs articles.
    </div>
	@endif
  <div id="cart-container">
    <p class="alert alert-info">Chargement du panier...</p>
  </div>
@endsection
