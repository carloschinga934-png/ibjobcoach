@extends('shared.layout')


@section("content")

    <div class="ebook-a ebook-display">

        <div class="row" id="descargar">
            <div class="col-md-12 justify-content-center" id="contenedor" style="padding-top: 120px;">
                
                
                
                {{-- ebookform-paypal -> cambiado a form_verificar_voucher --}}
                <form method="post" id="form_verificar_voucher" enctype="multipart/form-data" action="{{ route('verificar_voucher_ebook') }}">
                    @csrf
                    <div class="form-group-1">
                        
                        <img src="{{ asset("img/ebook/vista_pago1.svg") }}" alt="img">
                        <div class="inputs_verificar_voucher">
                            <h1 class="titulo-form-ebook">Validemos la compra </h1>
                            <input type="email" name="correo" class="form-control col-6" id="email"
                                placeholder="Correo electrónico">

                            <select name="ebook" id="ebook" class="form-control">
                                <option value="">--Seleccione Ebook--</option>
                                <option value="'La empleabilidad en tiempos de crisis, outplacement la solución">'La
                                    empleabilidad en tiempos de crisis, outplacement la solución</option>
                            </select>
                            <div>
                                <label class="text-shadow-zinc-950 h6">Ingrese Vaucher de pago</label>
                                <input type="file" name="file" class="form-control" id="file" style="height:fit-content;">
                            </div>
                            <div class="form-check form-check-inline col-12">
                                <input id="politicas" class="form-check-input" type="checkbox" name="politicas"
                                    value="true">
                                <label for="politicas" class="form-check-label h6"><a
                                        href="ebbok/Políticas De Privacidad.pdf" class="text-zinc-950">Politicas de
                                        Privacidad</a></label>
                            </div>
                            <div class="d-flex text-center justify-content-center"
                                style="flex-direction: column; align-items:center; gap: 10px;">

                                <button type="submit" class="btn-warning button-descargar"
                                    style="border-radius: 10px; height: 40px; font-size:18px;">VERIFICAR VOUCHER</button>
                                <a id="abrir" class="text-warning text-center">Aún no he comprado un ebook</a>
                            </div>



                        </div>


                    </div>





                </form>
            </div>
        </div>

    </div>

@endsection