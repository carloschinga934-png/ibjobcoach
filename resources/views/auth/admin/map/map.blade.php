@extends('auth.layout.dash_layout')

@section('title', 'Mapa')

@section('body')
<div class="ib-wrapper">
    @include('auth.layout.partials.sidebar')
    <main class="ib-main-panel">
        @include('auth.layout.partials.navbar')
        <section class="ib-content">
            <div id="ib-map" style="height: 500px; width: 100%; border-radius:16px; box-shadow:0 4px 18px rgba(44,62,80,0.13);"></div>
        </section>
        @include('auth.layout.partials.footer')
    </main>
</div>
@endsection

@push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps_key') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var map = new google.maps.Map(document.getElementById('ib-map'), {
            center: { lat: -12.0464, lng: -77.0428 }, // Lima por defecto
            zoom: 13
        });
    });
    </script>
@endpush

