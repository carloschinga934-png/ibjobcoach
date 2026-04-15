<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Contacto de Empresa</title>
</head>
<body style="background-color:#f7f7f9; margin:0; padding:0; font-family: Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:30px 0;">
                <table width="500" cellpadding="0" cellspacing="0" style="background:#fff; border-radius:10px; box-shadow:0 3px 12px rgba(0,0,0,.07); padding:30px;">
                    <tr>
                        <td align="center" style="padding-bottom:20px;">
                            <img src="https://ibjobcoach.corpibgroup.com/assets/dna/img/ibjobcoach.jpg" alt="IBJobCoach" width="110" style="margin-bottom: 15px; border-radius: 10px;">
                            <h2 style="margin:0; color:#2c3e50;">Nuevo mensaje de contacto empresarial</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellpadding="5">
                                <tr>
                                    <td style="font-weight:bold; color:#444;">Empresa:</td>
                                    <td>{{ $data['empresa'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold; color:#444;">Email:</td>
                                    <td>{{ $data['email'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold; color:#444;">País:</td>
                                    <td>{{ $data['pais'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold; color:#444;">Teléfono:</td>
                                    <td>{{ $data['telefono'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold; color:#444;">Nombre y Apellidos:</td>
                                    <td>{{ $data['name'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold; color:#444;">Cargo:</td>
                                    <td>{{ $data['cargo'] }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top:20px; color:#888; font-size:13px;" align="center">
                            <em>Este mensaje fue generado automáticamente por IBJobCoach.</em>
                        </td>
                    </tr>
                </table>
                <div style="color:#b0b0b0; font-size:12px; margin-top:18px;">
                    &copy; {{ date('Y') }} IBJobCoach. Todos los derechos reservados.
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
