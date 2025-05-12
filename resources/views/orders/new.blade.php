@extends('layouts.app')

@section('content')
    @if (!session()->has('success') && !session()->has('error'))
        <h1 class="text-center mb-4">Valider ma commande</h1>
        <div id="order-review-container">
            <p class="alert alert-info">Chargement…</p>
        </div>
        <form id="order-form" method="POST" action="{{ route('orders.store') }}" class="mt-3">
            @csrf
            <input type="hidden" name="items" id="order-items-input">
            <button class="btn btn-success w-100 rounded-3">Confirmer la commande</button>
        </form>
    @else
        @if (session('success'))
            <div id="order-success" data-clear-cart></div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    window.location.href = "{{ route('orders.index') }}";
                });
            </script>
        @elseif (session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    window.location.href = "{{ route('carts.index') }}";
                });
            </script>
        @endif
    @endif
@endsection
