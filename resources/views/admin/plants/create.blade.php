@extends('layouts.app')
@section('content')
<h1>Nouvelle plante</h1>
@include('admin.plants._form', ['plant' => null])
@endsection
