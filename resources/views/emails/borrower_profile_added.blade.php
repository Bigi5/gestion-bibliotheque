<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Emprunteur Ajouté</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #4c51bf;
            text-align: center;
        }
        .content {
            padding: 10px;
            line-height: 1.6;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Bienvenue, {{ $borrowerProfile->first_name }} {{ $borrowerProfile->last_name }}!</h1>

        <div class="content">
            <p>Votre profil a été ajouté avec succès à notre bibliothèque.</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Bibliothèque de 2SND - Tous droits réservés</p>
        </div>
    </div>

</body>
</html>
