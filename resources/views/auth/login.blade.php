<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Bibliothèque 2SND</title>
    <style>
        /* Style global */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            background: whitesmoke;
        }

        /* Section gauche */
        .form-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 30px;
            background: white;
        }

        .form-container .logo {
            max-width: 120px;
            margin-bottom: 20px;
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
            position: relative;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: rgb(231, 79, 29);
            outline: none;
        }

        .eye-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 20px;
            color: #666;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .eye-icon:hover {
            color: rgb(231, 79, 29);
            transform: translateY(-50%) scale(1.2);
        }

        .remember-me {
            font-size: 14px;
            margin-bottom: 15px;
        }

        .remember-me input {
            margin-right: 5px;
        }

        .forgot-password {
            text-align: right;
            font-size: 12px;
            margin-bottom: 20px;
        }

        .forgot-password a {
            color: rgb(231, 79, 29);
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background-color:#434a95;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .login-btn:hover {
            background-color: rgb(231, 79, 29);
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .image-container {
                display: none;
            }
        }
    </style>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Section gauche : formulaire -->
    <div class="form-container">
        <!-- Logo -->
        <img src="{{ asset('images/Logo2snd.png') }}" alt="Logo 2SND" class="logo">

        <div class="container">
            <h2>Connexion</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                    <p style="color: red; font-size: 12px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input id="password" type="password" name="password" required>
                    <i class="fas fa-eye eye-icon" id="togglePassword"></i>
                    @error('password')
                    <p style="color: red; font-size: 12px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mot de passe oublié -->
                <div class="forgot-password">
                    @if (Route::has('password.request'))
                    <a href="{{ route('reset-password') }}">Mot de passe oublié ?</a>
                    @endif
                </div>

                <!-- Se souvenir de moi -->
                <div class="remember-me">
                    <label>
                        <input type="checkbox" name="remember">
                        Se souvenir de moi
                    </label>
                </div>

                <!-- Bouton de connexion -->
                <button type="submit" class="login-btn">Se connecter</button>
            </form>
        </div>
    </div>

    <!-- Section droite : image -->
    <div class="image-container"></div>
    
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

        togglePassword.addEventListener('click', () => {
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;

            togglePassword.classList.toggle('fa-eye');
            togglePassword.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>
