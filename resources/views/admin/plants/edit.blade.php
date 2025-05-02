@extends('layouts.app')
@section('content')
<h1>Modifier la plante</h1>
@include('admin.plants._form', ['plant' => $plant])
@endsection
