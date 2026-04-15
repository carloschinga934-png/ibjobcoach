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
                @foreach($cardsAdmin as $card)
                    <a href="{{ $card['url'] }}" class="ib-card {{ $card['color'] }} {{ $card['custom_class'] ?? '' }}">
                        <i class="material-icons ib-card-icon">{{ $card['icon'] }}</i>
                        <div class="ib-card-title">{{ $card['title'] }}</div>
                    </a>
                @endforeach
            </div>

          
            </div>
        </section>
        @include('auth.layout.partials.footer')
    </main>
</div>
@endsection
