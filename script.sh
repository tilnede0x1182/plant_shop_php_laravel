#!/bin/bash
set -e

mkdir -p resources/views/admin/plants
mkdir -p resources/views/admin/users
mkdir -p resources/views/orders
mkdir -p resources/views/users

# Admin › Plantes : create & edit
cat > resources/views/admin/plants/create.blade.php <<'EOF'
@extends('layouts.app')
@section('content')
<h1>Nouvelle plante</h1>
@include('admin.plants._form', ['plant' => null])
@endsection
EOF

cat > resources/views/admin/plants/edit.blade.php <<'EOF'
@extends('layouts.app')
@section('content')
<h1>Modifier la plante</h1>
@include('admin.plants._form', ['plant' => $plant])
@endsection
EOF

# Admin › Users
cat > resources/views/admin/users/index.blade.php <<'EOF'
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
EOF

cat > resources/views/admin/users/show.blade.php <<'EOF'
@extends('layouts.app')
@section('content')
<h1>{{ $user->name }}</h1>
<p><strong>Email :</strong> {{ $user->email }}</p>
<p><strong>Admin :</strong> {{ $user->admin ? 'Oui' : 'Non' }}</p>
<a class="btn btn-warning rounded-3" href="{{ route('admin.users.edit',$user) }}">Modifier</a>
@endsection
EOF

cat > resources/views/admin/users/edit.blade.php <<'EOF'
@extends('layouts.app')
@section('content')
<h1>Modifier l’utilisateur</h1>
<form method="POST" action="{{ route('admin.users.update',$user) }}">@csrf @method('PUT')
  <div class="mb-3"><label class="form-label">Nom</label><input class="form-control rounded-3" name="name" value="{{ old('name',$user->name) }}"></div>
  <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control rounded-3" name="email" value="{{ old('email',$user->email) }}"></div>
  <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="admin" id="isAdmin" {{ $user->admin?'checked':'' }}>
    <label class="form-check-label" for="isAdmin">Administrateur</label></div>
  <button class="btn btn-warning rounded-3">Enregistrer</button>
</form>
@endsection
EOF

# Orders › create
cat > resources/views/orders/create.blade.php <<'EOF'
{{-- alias de new.blade.php pour RESTful resource --}}
@extends('orders.new')
EOF

# Users › edit
cat > resources/views/users/edit.blade.php <<'EOF'
@extends('layouts.app')
@section('content')
<h1>Modifier mon profil</h1>
<form method="POST" action="{{ route('users.update',$user) }}">@csrf @method('PUT')
  <div class="mb-3"><label class="form-label">Nom</label><input class="form-control rounded-3" name="name" value="{{ old('name',$user->name) }}"></div>
  <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control rounded-3" name="email" value="{{ old('email',$user->email) }}"></div>
  <button class="btn btn-warning rounded-3">Enregistrer</button>
</form>
@endsection
EOF

echo "✅ Vues Laravel créées avec succès."
