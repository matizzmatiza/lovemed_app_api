<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dane logowania do systemu - ORGANIZATOR</title>
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
    <p>Właśnie zostałeś dodany jako organizator w systemie Lovemed.</p>
    <br />
    <p>Twoje dane logowania do systemu:</p>
    <p class="stronger">Login: {{ $to }}</p>
    <p class="stronger">Hasło: {{ $tempPassword }}</p>
    <br />
    <p class="stronger">Przy pierwszym logowaniu organizator będzie musiał zmienić hasło.</p>
</body>

</html>