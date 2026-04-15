@extends("shared.layout")

@push('styles')
    {{-- Se puso acá porque debe aparecer primero --}}
    <script src="https://www.paypal.com/sdk/js?client-id=TU_CLIENT_ID"></script>
    <link rel="stylesheet" href="{{ asset('css/ebook/ver_detalle_ebook.css') }}">
@endpush

@section("content")

    <section class="section_ver_detalle_ebook">
        <div class="presentacion_principal_detalle_ebook">
            <div class="d-flex gap-4">
                <div class="detalle_p_primera_parte">
                    <img src="{{ asset('img/ebook/ebook1_presentacion.jpg') }}" alt="ebook.jpg">
                    <button><i class="fa-solid fa-share" style="color: #ffffff;"></i> Compartir libro</button>
                </div>
                <div class="detalle_p_segunda_parte">
                    <h2>EBOOK-1</h2>
                    <P>Antonio Ruiz</P>
                    <P>Editorial: Planeta <br />
                        Temática: Empresa</P>
                    <p>Sipnósis del EBOOK-1</p>
                    <P>
                    <h5>Lorem ipsum dolor sit, amet consectetur </h5>adipisicing elit. Provident tenetur, quae illo, placeat
                    esse
                    sint
                    iusto quo voluptatem modi dolorum voluptas earum voluptate enim expedita commodi recusandae ipsa
                    accusamus quos?</P>
                </div>
                <div class="detalle_p_tercera_parte">
                    <h5>Escoge tu método de pago</h5>
                    <button>Paypal</button>
                    <button>Mastercard</button>
                    <button>Tarjeta de débito/crédito</button>
                </div>
            </div>
            <div>
                <audio src="">SONIDOOOOOOOOOOOOOOOOO</audio>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const buttons = document.querySelectorAll('.detalle_p_tercera_parte > button');
                buttons.forEach(button => {
                    button.addEventListener('click', function () {
                        buttons.forEach(btn => btn.classList.remove('activo'));
                        this.classList.add('activo');
                    });
                });
            });
        </script>
    @endpush

@endsection