@extends('auth.empleado.layout.dash_layout')

@section('title', 'Dashboard')

@section('body')
<div class="ib-wrapper">
    {{-- Sidebar --}}
    @include('auth.empleado.layout.partials.sidebar')

    <main class="ib-main-panel">
        {{-- Navbar --}}
        @include('auth.empleado.layout.partials.navbar')

        {{-- Content --}}
        <section class="ib-content">
            {{-- Tarjetas Actuales --}}
            <div class="ib-cards-grid">
                @foreach($cardsActuales as $card)
                    <a href="{{ $card['url'] }}" class="ib-card {{ $card['color'] }} {{ $card['custom_class'] }}">
                        <i class="material-icons ib-card-icon">{{ $card['icon'] }}</i>
                        <div class="ib-card-title">{{ $card['title'] }}</div>
                    </a>
                @endforeach

            </div>

            {{-- Título de Contenidos Antiguos --}}
            <div class="ib-antiguo-header">
                <h2 class="ib-antiguo-title">Lista de contenidos antiguos</h2>
            </div>

            {{-- Tarjetas Antiguas --}}
            <div class="ib-cards-grid">
                @foreach($cardsAntiguos as $card)
                    <a href="{{ $card['url'] }}" class="ib-card {{ $card['color'] }}">
                        <i class="material-icons ib-card-icon">{{ $card['icon'] }}</i>
                        <div class="ib-card-title">{{ $card['title'] }}</div>
                    </a>
                @endforeach
            </div>
        </section>
        @include('auth.empleado.layout.partials.footer')
    </main>
</div>
@endsection
