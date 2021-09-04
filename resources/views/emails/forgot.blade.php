
<!DOCTYPE html>
<html>

<head>
    <title>Page Title</title>
</head>
<style>
    a:link,
    a:visited {
        background-color: #1B4188;
        color: white;
        padding: 10px 25px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        border-radius: 4px;
    }
    a:hover,
    a:active {
        background-color: #2251aa;
    }
    .footer {
        color: #737373;
        font-size: 15px;
    }
</style>

<body style="text-align: center; font-family: Arial, Helvetica, sans-serif;">
    <div>
        <h2>Promijenite lozinku</h2>
        <p>Ako se zaboravili lozinku ili je želite promjeniti, kliknite na link ispod i započnite kreiranje nove lozinke.</p><br>
        <a href="http://localhost:8080/reset_lozinke/{{$token}}" target="_blank">Promijeni lozinku</a> <br>
    </div>
    <div >
        <p class="footer">Ako niste zatražili promijenu lozinke, možete sigurno zanemariti ovaj email. Samo osoba s pristupom vašoj email adresi može promijeniti
            loziku vašeg računa.
        </p>
    </div>


</body>

</html>