@extends('shared.layout')


@section("content")
    <div class="portada_mas_titulo_ebook_info">
        <div class="ebook-banner">
        </div>
        <div class="d-lg-none titulo_informativo_ebook">
            <h1>E-Book</h1>
            <h2>Es la <b style="color: #f9be13 !important; font-family: serif;"> GUÍA RÁPIDA Y ECONÓMICA </b> para <br> encontrar el
                trabajo ideal.</h2>
        </div>
    </div>
    <div class="section bg-white">
        <div class="container">

            <div class="row">
                <div class="col-md-12 mt-3" style="width: 80%;
                                margin: 0 auto;">

                    <p class="text-normal">Encontrar un nuevo trabajo tiene los mismos retos que llevar un producto
                        nuevo al mercado. La única diferencia es que el producto que vendes eres tú mismo. Primero
                        tienes que saber qué estás vendiendo y a quién, para luego presentarlo correctamente.</p>
                    <p class="text-normal">El proceso de búsqueda de empleo es una labor intensa pero si manejas la
                        información este proceso puede ser rápido y muy económico. Para eso reunimos en esta guia
                        información desarrollada por
                        expertos con años en el mercado laboral y que te pueden ayudar a que sea una búsqueda muy
                        exitosa.</p>
                </div>
            </div>


            <div class="section" id="sedes">
                <div class="container">
                    <div class="row box-ebooks-ppal info_foto_mas_boton_ebook">
                        <div class="mano_iconos_ebook">
                            <div class="box-ebooks-iconos">
                                <ul class="box-ebooks justify-content-center">
                                    <li class="elemento">
                                        <img src="{{ asset('img/ebook/5.png') }}" class="icono-ebook"><span>Etapas del
                                            proceso
                                            de
                                            búsqueda</span>
                                    </li>
                                    <li class="elemento">
                                        <img src="{{ asset('img/ebook/6.png') }}" class="icono-ebook"><span>Cómo estructurar
                                            tu
                                            búsqueda</span>
                                    </li>
                                    <li class="elemento">
                                        <img src="{{ asset('img/ebook/7.png') }}" class="icono-ebook"><span>Herramientas
                                            digitales para
                                            encontrar trabajo</span>
                                    </li>
                                    <li class="elemento">
                                        <img src="{{ asset('img/ebook/8.png') }}" class="icono-ebook"><span>Conoce el
                                            mercado
                                            laboral</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-7 col-sm-12 p-0 imagen-dedo">
                                <img src="{{ asset('img/ebook/dedo.png') }}" class="left-blockk">
                            </div>
                        </div>
                        <div class="col-md-12 button-descargar m-5">
                            <a href="{{ asset("ver_ebook") }}" class="btn" id="abrir">QUIERO MI EBOOK</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


@endsection