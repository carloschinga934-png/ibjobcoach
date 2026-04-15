<div id="modalContactoEmpresa" class="modal fade" tabindex="-1" aria-labelledby="hubspot-empresa" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            <!-- MODAL HEADER (TITULO + X) -->
            <div class="modal-header contacto ml-2 mr-2" style="position:relative;">
                <h4 id="hubspot-empresa" class="m-0 flex-grow-1">¿DESEAS MEJORAR COMO EMPRESA?</h4>
            </div>
            <!-- TEXTO INFORMATIVO -->
            <div class="px-4 pt-4 pb-2">
                <p class="title-contacto mb-1">
                    Ponte en contacto con nosotros para mayor información sobre la plataforma, sus beneficios y los planes que tenemos para tu empresa.
                </p>
                <p class="title-contacto">
                    Rellena el formulario y nosotros nos pondremos en contacto a la brevedad.
                </p>
            </div>
            <!-- FORMULARIO -->
            <div class="modal-body pt-1">
                <form action="{{ route('empresa.contacto') }}" method="POST" class="ajax2" id="contactoempresa-empresa">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 p-2">
                            <input type="text" class="form-control" name="empresa" id="modal-empresa-empresa" placeholder="Nombre de la empresa" required>
                        </div>
                        <div class="col-lg-12 p-2">
                            <input type="email" class="form-control" name="email" id="modal-email-empresa" placeholder="Ingrese correo electrónico" required>
                        </div>
                        <div class="col-lg-6 p-2">
                            <select name="pais" class="form-control" id="modal-pais-empresa" required>
                                <option value="">Seleccione su País</option>
                                <option value="Argentina">Argentina y Uruguay</option>
                                <option value="Brazil">Brasil</option>
                                <option value="Chile">Chile</option>
                                <option value="Peru">Perú</option>
                                <option value="Colombia">Colombia</option>
                                <option value="Mexico">México</option>
                            </select>
                        </div>
                        <div class="col-lg-6 p-2">
                            <input type="tel" class="form-control" name="telefono" id="modal-telefono-empresa" placeholder="Teléfono" pattern="[9][0-9]{8}" title="El formato debe ser similar a 946696666" required>
                        </div>
                        <div class="col-lg-12 p-2">
                            <input type="text" class="form-control" name="name" id="modal-name-empresa" placeholder="Nombre y Apellidos" required>
                        </div>
                        <div class="col-lg-12 p-2">
                            <input type="text" class="form-control" name="cargo" id="modal-cargo-empresa" placeholder="Cargo que ocupa" required>
                        </div>
                        <div class="col-lg-12" align="center">
                            <button type="submit" class="btn btn-success btn-lg p-2" style="border-radius: 20px;width: 35%;">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
