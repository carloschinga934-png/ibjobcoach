<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Términos y Condiciones</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #fff;
      color: #1a1a1a;
    }

    header {
      background-color: #cc0000;
      color: #fff;
      padding: 2rem 1rem;
      text-align: center;
    }

    header h1 {
      font-size: 2.5rem;
      font-weight: 700;
      margin: 0;
    }

    main.content {
      max-width: 900px;
      margin: 3rem auto;
      background: #f9f9f9;
      padding: 2.5rem 3rem;
      border-radius: 1rem;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.07);
    }

    main h3 {
      margin-top: 2rem;
      font-weight: 600;
      color: #cc0000;
    }

    main p {
      line-height: 1.7;
      margin-bottom: 1.2rem;
    }

    footer {
      text-align: center;
      padding: 1.5rem 0;
      background-color: #101010;
      color: #bbb;
      font-size: 0.9rem;
    }

    a {
      color: #cc0000;
      text-decoration: underline;
    }

    a:hover {
      color: #a30000;
      text-decoration: none;
    }

    @media (max-width: 576px) {
      main.content {
        padding: 1.5rem 1.2rem;
      }
    }
  </style>
</head>
<body>

  <header>
    <h1>Términos y Condiciones</h1>
  </header>

  <main class="content" role="main">
    <p>Bienvenido a nuestro sitio web. Al acceder y utilizar nuestros servicios, aceptas quedar legalmente vinculado a los siguientes Términos y Condiciones.</p>

    <h3>1. Definiciones</h3>
    <p><strong>“Usuario”</strong> se refiere a cualquier persona que acceda, navegue o utilice este sitio web.</p>
    <p><strong>“Empresa”</strong> se refiere a IBOutplacement, responsable del sitio y sus contenidos.</p>

    <h3>2. Uso del Sitio</h3>
    <p>El contenido de este sitio tiene fines informativos y puede ser modificado o actualizado en cualquier momento sin previo aviso. Está prohibido utilizar el sitio con fines ilícitos o que perjudiquen derechos de terceros.</p>

    <h3>3. Condiciones de Registro</h3>
    <p>Al registrarte, te comprometes a proporcionar información veraz y mantenerla actualizada. El uso no autorizado de cuentas puede conllevar responsabilidades civiles o penales.</p>

    <h3>4. Propiedad Intelectual</h3>
    <p>Todo el contenido (incluyendo, pero no limitado a: textos, gráficos, logos, íconos y software) es propiedad exclusiva de la empresa y está protegido por las leyes de derechos de autor y propiedad industrial.</p>

    <h3>5. Privacidad</h3>
    <p>Tu información personal será tratada conforme a nuestra <a href="{{ url('/privacidad') }}">Política de Privacidad</a>. Al utilizar este sitio, consientes dicho tratamiento.</p>

    <h3>6. Responsabilidad Limitada</h3>
    <p>La empresa no se responsabiliza por daños directos o indirectos derivados del uso o imposibilidad de uso del sitio web, incluyendo errores, interrupciones, virus o pérdida de datos.</p>

    <h3>7. Modificaciones</h3>
    <p>Nos reservamos el derecho de modificar estos términos en cualquier momento. Los cambios entrarán en vigencia desde su publicación. Es responsabilidad del usuario revisar periódicamente esta sección.</p>

    <h3>8. Legislación Aplicable</h3>
    <p>Estos Términos se rigen por las leyes vigentes en Perú. Cualquier controversia será resuelta por los tribunales competentes de Lima, salvo disposición legal en contrario.</p>

    <h3>9. Contacto</h3>
    <p>Si tienes preguntas o deseas ejercer tus derechos, puedes escribirnos a: <a href="mailto:cm.outplacement.coaching@corpibgroup.com">cm.outplacement.coaching@corpibgroup.com</a>.</p>
  </main>

  <footer>
    &copy; {{ date('Y') }} IBOutplacement. Todos los derechos reservados.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
