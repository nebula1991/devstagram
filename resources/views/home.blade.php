@extends('layouts.app')

@section('titulo')
    Página principal
@endsection

@section('contenido')
    {{-- Contenido de esta página --}}

      <x-listar-post :posts="$posts" />

@endsection

