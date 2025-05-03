@extends('layouts.app')
@section('content')
    @if (!session('success') && !session('error'))
        <h1 class="text-center mb-4">Valider ma commande</h1>
        <div id="order-review-container">
            <p class="alert alert-info">Chargement…</p>
        </div>
        <form id="order-form" method="POST" action="{{ route('orders.store') }}" class="mt-3">@csrf
            <input type="hidden" name="items" id="order-items-input">
            <button class="btn btn-success w-100 rounded-3">Confirmer la commande</button>
        </form>
    @else
        <script>
            @if (session('success'))
                window.location.href = "{{ route('orders.index') }}";
            @elseif (session('error'))
                window.location.href = "{{ route('carts.index') }}";
            @endif
        </script>
    @endif

    @if (session('success'))
        <script>
            Cart.clear()
        </script>
    @endif
@endsection
