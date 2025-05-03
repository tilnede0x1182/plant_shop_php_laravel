<nav class="navbar navbar-expand-lg navbar-dark bg-warning rounded-3 px-3">
	<a class="navbar-brand fw-bold text-white" href="{{ route('home') }}">🌿 PlantShop</a>
	<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navBar"><span class="navbar-toggler-icon"></span></button>
	<div class="collapse navbar-collapse" id="navBar">
		<ul class="navbar-nav ms-auto">
			<li class="nav-item"><a class="nav-link text-white" id="cart-link" href="{{ route('carts.index') }}">Mon panier</a></li>
			@auth
			<li class="nav-item"><a class="nav-link text-white" href="{{ route('orders.index') }}">Mes commandes</a></li>
			<li class="nav-item"><a class="nav-link text-white" href="{{ route('users.show', Auth::id()) }}">Profil</a></li>
			@if(Auth::user()->admin)
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle text-white" data-bs-toggle="dropdown" href="#">Admin</a>
				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="{{ route('admin.plants.index') }}">Plantes</a></li>
					<li><a class="dropdown-item" href="{{ route('admin.users.index') }}">Utilisateurs</a></li>
				</ul>
			</li>
			@endif
			<li class="nav-item">
				<form method="POST" action="{{ route('logout') }}" class="d-inline">
					@csrf
					<button type="submit" class="nav-link btn btn-link text-white px-0 align-baseline" style="text-decoration: none;">
						Déconnexion
					</button>
				</form>
			</li>

			@else
			<li class="nav-item"><a class="nav-link text-white" href="{{ route('register') }}">S’inscrire</a></li>
			<li class="nav-item"><a class="nav-link text-white" href="{{ route('login') }}">Se connecter</a></li>
			@endauth
		</ul>
	</div>
</nav>
