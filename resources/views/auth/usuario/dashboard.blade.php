@extends('auth.layout.dash_layout')

@section('title', 'Dashboard')

@section('body')
    <div class="ib-wrapper">
        {{-- Sidebar --}}
        @include('auth.layout.partials.sidebar')

        <main class="ib-main-panel">
            {{-- Navbar --}}
            @include('auth.layout.partials.navbar')

            {{-- Content --}}
            <section class="ib-content">
                {{-- Tarjetas Actuales --}}
                <div class="ib-cards-grid">


                </div>

                {{-- Título de Contenidos Antiguos --}}
                <div class="ib-antiguo-header">
                    <h2 class="ib-antiguo-title">Lista de contenidos antiguos</h2>
                </div>

                {{-- Tarjetas Antiguas --}}
                <div class="ib-cards-grid">

                </div>
            </section>
            @include('auth.layout.partials.footer')
        </main>
    </div>
@endsection