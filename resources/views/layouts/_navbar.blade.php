<nav class="navbar navbar-expand-lg navbar-dark rounded-3 navbar-custom px-3">
	<a class="navbar-brand fw-bold text-white" href="{{ route('home') }}">🌿 PlantShop</a>
	<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navBar"><span class="navbar-toggler-icon"></span></button>
	<div class="collapse navbar-collapse" id="navBar">
		<ul class="navbar-nav ms-auto">
			@auth
			<li class="nav-item d-flex align-items-center text-white px-2 text-capitalize">
				{{ Auth::user()->name }}@if(Auth::user()->admin) (Administrateur)@endif
			</li>
			@endauth
			<li class="nav-item"><a class="nav-link" id="cart-link" href="{{ route('carts.index') }}">Mon panier</a></li>
			@auth
			<li class="nav-item"><a class="nav-link" href="{{ route('orders.index') }}">Mes commandes</a></li>
			<li class="nav-item"><a class="nav-link" href="{{ route('users.show', Auth::id()) }}">Profil</a></li>
			@if(Auth::user()->admin)
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Admin</a>
				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="{{ route('admin.plants.index') }}">Plantes</a></li>
					<li><a class="dropdown-item" href="{{ route('admin.users.index') }}">Utilisateurs</a></li>
				</ul>
			</li>
			@endif
			<li class="nav-item">
				<form method="POST" action="{{ route('logout') }}" class="d-inline">
					@csrf
					<button type="submit" class="nav-link btn btn-link px-0 align-baseline" style="text-decoration: none;">
						Déconnexion
					</button>
				</form>
			</li>
			@else
			<li class="nav-item"><a class="nav-link" href="{{ route('register') }}">S’inscrire</a></li>
			<li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Se connecter</a></li>
			@endauth
		</ul>
	</div>
</nav>
