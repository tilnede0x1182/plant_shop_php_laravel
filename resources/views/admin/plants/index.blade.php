@extends('layouts.app')
@section('content')
<h1 class="mb-4">Gestion des plantes</h1>
<a class="btn btn-warning rounded-3 mb-3" href="{{ route('admin.plants.create') }}">Nouvelle plante</a>
<table class="table table-warning table-hover rounded-3 overflow-hidden">
  <thead><tr><th>Nom</th><th>Prix</th><th>Stock</th><th class="text-center">Actions</th></tr></thead><tbody>
  @foreach($plants as $p)
    <tr>
      <td><a class="text-decoration-none text-dark" href="{{ route('plants.show',$p) }}">{{ $p->name }}</a></td>
      <td>{{ $p->price }} €</td><td>{{ $p->stock }}</td>
      <td class="text-center">
        <a class="btn btn-sm btn-outline-dark rounded-3" href="{{ route('admin.plants.edit',$p) }}">✏</a>
        <form class="d-inline" method="POST" action="{{ route('admin.plants.destroy',$p) }}" onsubmit="return confirm('Supprimer ?')">@csrf @method('DELETE')
          <button class="btn btn-sm btn-danger rounded-3">🗑</button></form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
@endsection
