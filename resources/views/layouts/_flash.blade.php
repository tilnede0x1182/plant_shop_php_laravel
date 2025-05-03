@if(session('notice')) <div class="alert alert-success rounded-3">{{ session('notice') }}</div>@endif
@if(session('alert'))  <div class="alert alert-danger  rounded-3">{{ session('alert')  }}</div>@endif
@if(session('success')) <div class="alert alert-success rounded-3">Commande confirmée.</div>@endif
@if(session('error')) <div class="alert alert-danger rounded-3">{{ session('error') }}</div>@endif
