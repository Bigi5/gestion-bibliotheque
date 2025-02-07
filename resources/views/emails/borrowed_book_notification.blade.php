<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification de Prêt</title>
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
            margin: 20px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #4c51bf;
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .content {
            padding: 15px;
            line-height: 1.6;
        }
        .content p {
            margin-bottom: 15px;
        }
        .content strong {
            color: #333;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
        .logo {
            width: 120px;
            display: block;
            margin: 0 auto 20px;
        }
        .date-time {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
        }
        .date-time p {
            margin: 0;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Logo de 2SND depuis public/images -->
        <img src="{{ asset('images/logo2snd.png') }}" alt="Logo de 2SND" class="logo">

        <h1>Prêt de Livre - {{ $book->title }}</h1>

        <div class="content">
            <p>Bonjour <strong>{{ $borrowerProfile->first_name }} {{ $borrowerProfile->last_name }}</strong>,</p>

            <p>Nous vous informons que vous avez emprunté le livre <strong>{{ $book->title }}</strong> à notre bibliothèque.</p>

            <div class="date-time">
                <p><strong>Date limite de retour :</strong> {{ \Carbon\Carbon::parse($dueDate)->format('d/m/Y') }}</p>
            </div>

            <p>Merci de respecter la date limite pour le retour du livre afin d'éviter des pénalités.</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Bibliothèque de 2SND - Tous droits réservés</p>
        </div>
    </div>

</body>
</html>
