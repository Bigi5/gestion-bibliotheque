<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe - Bibliothèque 2SND</title>
    <style>
        /* Style global */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: whitesmoke;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            color: #2b2d42;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        input[type="email"]:focus {
            border-color: rgb(231, 79, 29);
            outline: none;
        }

        .info-text {
            margin-bottom: 20px;
            font-size: 14px;
            color: #555;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background-color: rgb(231, 79, 29);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .login-btn:hover {
            background-color: #d45d1f;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Réinitialisation du mot de passe</h2>
        <p class="info-text">Veuillez entrer votre adresse email, et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>

        <!-- Session Status -->
        @if (session('status'))
        <p style="color: green; font-size: 14px;">{{ session('status') }}</p>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                <p style="color: red; font-size: 12px;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bouton -->
            <button type="submit" class="login-btn">Envoyer le lien de réinitialisation</button>
        </form>
    </div>
</body>

</html>
