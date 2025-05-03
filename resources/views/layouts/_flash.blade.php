@if(session('notice')) <div class="alert alert-success rounded-3">{{ session('notice') }}</div>@endif
@if(session('alert'))  <div class="alert alert-danger  rounded-3">{{ session('alert')  }}</div>@endif
<script>console.log('FLASH', @json(session()->all()));</script>
