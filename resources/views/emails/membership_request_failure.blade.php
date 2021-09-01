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
    <p>Vaš zahtjev za članskom karticom je odbijen!</p>
    <p>Razlog: {{ $membership_request_data['message'] }}</p>
    <h4>Srdačan pozdrav!</h4>
</body>
</html>