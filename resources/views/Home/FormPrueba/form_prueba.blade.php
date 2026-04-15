<section class="page-section wow fadeInUp" data-wow-duration="3s" id="prueba">
  <div class="container-fluid">
    <div class="row align-items-center mb-4">
      <div class="col-md-3">
        <p class="nosotros prueba-titulo mb-0">PRUEBA GRATIS</p>
      </div>
    </div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="form-prueba-main row">
            <!-- Formulario -->
            <div class="col-lg-7 col-md-12 mb-4">
              <form action="{{ route('register.form') }}" method="post" class="form-prueba-form" id="formPruebaForm" autocomplete="off">
                @csrf
                <div class="row g-3">
                  <div class="col-md-6">
                    <input type="text" name="name" class="form-prueba-input form-control" id="prueba-name" placeholder="Nombre" required>
                  </div>
                  <div class="col-md-6">
                    <input type="text" name="last_name" class="form-prueba-input form-control" id="prueba-last_name" placeholder="Apellido" required>
                  </div>
                  <div class="col-md-6">
                    <select name="country" class="form-prueba-input form-control" id="prueba-country" required>
                      <option value="">País</option>
                      <option value="Perú">Perú</option>
                      <option value="Argentina">Argentina y Uruguay</option>
                      <option value="Brazil">Brasil</option>
                      <option value="Chile">Chile</option>
                      <option value="Colombia">Colombia</option>
                      <option value="Mexico">México</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <input type="tel" name="phone" class="form-prueba-input form-control" id="prueba-phone" placeholder="Teléfono" required autocomplete="off">
                  </div>
                  <div class="col-md-6">
                    <select name="position" class="form-prueba-input form-control" id="prueba-position" required>
                      <option value="">Seleccione su Posición</option>
                      <option value="Analista">Analista</option>
                      <option value="Especialista">Especialista</option>
                      <option value="Jefe">Jefe</option>
                      <option value="SubGerente">SubGerente</option>
                      <option value="Gerente">Gerente</option>
                      <option value="Director">Director</option>
                      <option value="VP">VP</option>
                      <option value="Gerente General">Gerente General</option>
                      <option value="CEO">CEO</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <input type="email" name="email" class="form-prueba-input form-control" id="prueba-email" placeholder="Correo" required>
                  </div>
                  <div class="col-md-12">
                    <input type="password" name="password" class="form-prueba-input form-control" id="prueba-password" placeholder="Password" minlength="8" required>
                  </div>
                </div>
                <div class="form-prueba-extras my-3">
                  <label class="form-prueba-check">
                    <input type="checkbox" name="working" value="1" id="prueba-working">
                    <span class="form-prueba-checkmark"></span>
                    Actualmente estoy trabajando.
                  </label>
                </div>
                <!-- Inputs ocultos -->
                <input type="hidden" name="phonePais" class="prueba-phonePais" value="pe">
                <input type="hidden" name="namePais" class="prueba-namePais" value="Perú">
                <input type="hidden" name="type" value="registro">
                <button type="submit" class="btn btn-success form-prueba-btn w-100">
                  Accede a IBjobcoach <i class="fal fa-arrow-right"></i>
                </button>
              </form>
            </div>
            <!-- Texto lateral -->
            <div class="col-lg-5 col-md-12 d-flex align-items-center">
              <div class="form-txt w-100 mt-3 mt-lg-0">
                Por 2 días obtén acceso a la plataforma de forma gratuita y descubre la variedad de contenidos que existe en ella.
              </div>
            </div>
          </div><!-- /.form-prueba-main -->
        </div>
      </div>
    </div>
  </div>
</section>
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
