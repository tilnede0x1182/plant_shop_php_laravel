@extends('layouts.app')
@section('content')
<h1 class="mb-4">Gestion des utilisateurs</h1>
<table class="table table-hover rounded-3 overflow-hidden">
 <thead class="table-warning"><tr><th>Nom</th><th>Email</th><th>Admin</th><th></th></tr></thead><tbody>
 @foreach($users as $u)
  <tr>
    <td><a href="{{ route('admin.users.show',$u) }}">{{ $u->name }}</a></td>
    <td>{{ $u->email }}</td>
    <td>{!! $u->admin ? '✅' : '—' !!}</td>
    <td class="text-end">
      <a class="btn btn-sm btn-outline-dark rounded-3" href="{{ route('admin.users.edit',$u) }}">✏</a>
      <form class="d-inline" method="POST" action="{{ route('admin.users.destroy',$u) }}" onsubmit="return confirm('Supprimer ?')">
        @csrf @method('DELETE')<button class="btn btn-sm btn-danger rounded-3">🗑</button>
      </form>
    </td>
  </tr>
 @endforeach
 </tbody>
</table>
@endsection
