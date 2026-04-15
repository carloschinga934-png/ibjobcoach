<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Código de verificación – IBJobCoach</title>
    
</head>
<body style="font-family: Arial, sans-serif; background: #f6f7fb; padding: 30px;">
    <div style="max-width: 500px; margin: auto; background: #fff; border-radius: 10px; padding: 32px; box-shadow:0 2px 16px #ececec;">
        <div style="text-align:center; margin-bottom:18px;">
            {{-- <img src="{{ asset('img/home/nav/ibjobcoach.jpg') }}" alt="IBJobCoach" width="135" style="border-radius: 12px; border: 1px solid #eee;"> --}}
            <img src="https://ibjobcoach.corpibgroup.com/assets/dna/img/ibjobcoach.jpg" alt="IBJobCoach" width="135" style="border-radius: 12px; border: 1px solid #eee;">
        </div>
        <h2 style="color: #f15025; text-align: center; margin-bottom:12px;">¡Importante!</h2>
        <p style="font-size: 1.07rem; text-align: center;">
            Has solicitado restablecer tu contraseña en <b>IBJobCoach</b>.<br>
            <b>Tu código de verificación es:</b>
        </p>
        <p style="font-size: 2.1rem; font-weight: bold; letter-spacing: 7px; color:#f15025; margin:24px 0 32px 0; text-align:center;">
            {{ $codigo }}
        </p>
        <p style="font-size: 1rem; color: #555; text-align: center;">
            Este código expirará en 15 minutos.<br>
            Si no fuiste tú quien solicitó el cambio, puedes ignorar este mensaje.
        </p>
        <hr style="margin:32px 0 10px 0;">
        <p style="font-size: .92rem; color:#888; text-align:center;">
            © {{ date('Y') }} IBJobCoach | Todos los derechos reservados
        </p>
    </div>
</body>
</html>
