@extends('layouts.app')
@section('content')
<h1 class="text-center mb-4">Valider ma commande</h1>
@if(session('alert'))<div class="alert alert-danger rounded-3">{{ session('alert') }}</div>@endif
<div id="order-review-container"><p class="alert alert-info">Chargement…</p></div>
<form id="order-form" method="POST" action="{{ route('orders.store') }}" class="mt-3">@csrf
  <input type="hidden" name="items" id="order-items-input">
  <button class="btn btn-success w-100 rounded-3">Confirmer la commande</button>
</form>
<script>document.getElementById('order-form').addEventListener('submit',()=>Cart.clear())</script>
@endsection
