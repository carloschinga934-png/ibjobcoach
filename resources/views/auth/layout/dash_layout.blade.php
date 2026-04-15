<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'WEB CONTROL')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    @vite([
        'resources/css/dashboard/dashboard.css',
        'resources/css/dashboard/foro.css',
        'resources/css/dashboard/tecnicas.css',
        'resources/css/dashboard/contenidos.css',
        'resources/css/dashboard/alumni.css',
        'resources/js/app.js',
        'resources/js/bootstrap.js',
        'resources/js/demo/demo.js'
    ])
    <link rel="icon" type="image/png" href="{{asset('img/auth/dashboard/favicon.png') }}">
</head>
<body style="margin:0;padding:0;">
    @yield('body')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if(typeof demo !== "undefined" && typeof demo.initDashboardPageCharts === "function"){
                demo.initDashboardPageCharts();
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            let btn = document.getElementById('ibProfileBtn');
            let menu = document.getElementById('ibProfileMenu');
            if(btn && menu) {
                btn.onclick = function(e) {
                    e.stopPropagation();
                    menu.classList.toggle('ib-show');
                }
                document.addEventListener('click', function() {
                    menu.classList.remove('ib-show');
                });
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
