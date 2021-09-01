<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obavijest o zahtjevu za članskom karticom</title>
</head>
<body>
    <h4>Poštovani/a {{ $membership_request_data['name'] }},</h4>
    <p>Vaš zahtjev za članskom karticom je prihvaćen!</p>
    <p>Člansku iskaznicu možete preuzeti u poslovnici: {{ $membership_request_data['shop_office_name'] }}</p>
    <p>Za lokaciju poslovnice kliknite <a href="#">ovdje</a></p>
    <p>Uz člansku iskaznicu dobiti ćete jednokratnu lozinku s kojom se možete prijaviti na naš sustav <a href="#">ovdje</a></p>
    <p>Sve ostale informacije možete pronaći na web stranici pod rubrikom <a href="#">članstvo</a>, ili prilikom preuzimanja članske iskaznice.</p>
    <h4>Srdačan pozdrav!</h4>
</body>
</html>