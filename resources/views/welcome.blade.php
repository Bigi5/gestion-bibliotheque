<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    <style>
        /* Fond global */
        body {
            background-image: url('{{ asset('images/bck.jpg') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6); /* Transparence */
            z-index: -1;
        }

        .header-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            color: white;
        }

        .logo {
            width: 120px;
            height: auto;
        }

        .login-btn {
            padding: 10px 20px;
            background-color: transparent;
            color: rgb(231, 79, 29);
            border: 2px solid rgb(231, 79, 29);
            border-radius: 50px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            transition: color 0.3s ease;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background-color: rgb(231, 79, 29);
            z-index: 0;
            transition: width 0.4s ease;
        }

        .login-btn:hover {
            color: #fff;
        }

        .login-btn:hover::before {
            width: 100%;
        }

        .login-btn span {
            position: relative;
            z-index: 1;
        }

        .welcome-text {
            margin-top: 50px;
            font-size: 28px;
            font-weight: bold;
            color: #ffff66;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.8);
            text-align: center;
            padding: 0 15px;
            overflow: hidden;
            white-space: nowrap;
        }

        #welcomeMessage {
            display: inline-block;
            animation: fixed 3s ease-in, scroll-left 10s linear infinite;
        }

        @keyframes fixed {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(0);
            }
        }

        @keyframes scroll-left {
            0% {
                transform: translateX(100%);
            }
            100% {
                transform: translateX(-100%);
            }
        }

        .footer {
            color: #b0c4de;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
            text-align: center;
            padding: 15px;
            position: fixed;
            bottom: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.8);
        }

        @media (max-width: 768px) {
            .header-wrapper {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .logo {
                margin-bottom: 15px;
            }

            .welcome-text {
                font-size: 22px;
            }

            .login-btn {
                font-size: 14px;
                padding: 8px 15px;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header-wrapper">
        <img src="{{ asset('images/Logo2snd.png') }}" alt="Logo 2SND" class="logo">
        <a href="{{ route('login') }}" class="login-btn"><span>Connexion</span></a>
    </div>

    <!-- Message de bienvenue -->
    <div class="welcome-text">
        <h1 id="welcomeMessage">Bienvenue à la Bibliothèque de 2SND</h1>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 2SND Technologies - Tous droits réservés</p>
    </footer>

</body>
</html>
