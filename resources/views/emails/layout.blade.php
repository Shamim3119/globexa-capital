<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Globexa Capital Ltd</title>
</head>

<body style="margin:0;padding:0;background:#f4f6f9;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#f4f6f9">
<tr>
<td align="center">

<table width="650" cellpadding="0" cellspacing="0"
style="background:#ffffff;margin:30px 0;border-radius:8px;overflow:hidden;">

    <!-- Header -->
    <tr>
        <td align="center"
            bgcolor="#003366"
            style="padding:30px;">

            <img src="{{ asset('images/logo.png') }}"
                 alt="Globexa Capital Ltd"
                 style="height:70px;">

            <h2 style="margin:15px 0 0;color:#ffffff;">
                Globexa Capital Ltd
            </h2>

        </td>
    </tr>

    <!-- Body -->
    <tr>
        <td style="padding:40px;color:#444;font-size:16px;line-height:28px;">

            @yield('content')

        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td align="center"
            bgcolor="#f8f9fa"
            style="padding:25px;color:#888;font-size:13px;">

            © {{ date('Y') }} Globexa Capital Ltd<br>
            All Rights Reserved.

        </td>
    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>