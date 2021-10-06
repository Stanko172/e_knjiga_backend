<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poziv za registraciju</title>
</head>
<body>
    <p>{{ $data['message'] }}</p>

    <p>Registrirati se možete </p> <a href="{{ 'http://localhost:8080/registracija/' . $data['token']}}">ovdje</a>
</body>
</html>