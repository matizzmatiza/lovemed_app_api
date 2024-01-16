<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reetowanie hasła - SYSTEM LOVEMED</title>
    <style>
    a {
        color: #000000;
        text-decoration: none;
    }

    .stronger {
        font-weight: bold;
    }
    </style>
</head>

<body>
    <p class="stronger">Witaj, {{ $name }} {{ $surname }}</p>
    <p>Właśnie zresetowaliśmy twoje hasło.</p>
    <br />
    <p class="stronger">Hasło: {{ $tempPassword }}</p>
</body>

</html>