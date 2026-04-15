@extends('shared.layout')

@section('title', 'Inicio - IBJobCoach')

@section('content')
    @include('Home.Masthead.masthead')
    @include('Home.Nosotros.nosotros')
    @include('Home.IbJobCoach.ibjobcoach')
    @include('Home.Beneficios.beneficios')
    @include('Home.FormPrueba.form_prueba')
    @include('Home.Empresa.form_empresa')

@endsection
