@extends('layouts.app')
@section('content')
<h1 class="text-center mb-4">📜 Mes commandes</h1>
@if($orders->isEmpty())
  <p class="alert alert-info">Aucune commande.</p>
@else
  @foreach($orders->reverse() as $idx=>$order)
    <div class="card mb-3 shadow-sm rounded-3"><div class="card-body">
      <h5 class="card-title">Commande n°{{ $orders->count() - $idx }}</h5>
      <p class="text-muted mb-1">Passée le {{ $order->created_at->format('d/m/Y H:i') }} — Total : {{ $order->total_price }} €</p>
      <ul class="mb-2">
        @foreach($order->items as $it)
          <li>{{ $it->plant->name }} × {{ $it->quantity }} – {{ $it->plant->price }} €</li>
        @endforeach
      </ul>
      <p><strong>Statut :</strong> {{ $order->status }}</p>
    </div></div>
  @endforeach
@endif
@endsection
