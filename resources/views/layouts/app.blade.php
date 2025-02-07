<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Application')</title>
    <!-- Importer Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        /* Global Styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f9; /* Fond du body */
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: #f4f4f9; /* Même fond que le header */
            color: black; /* Texte noir pour contraste */
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px 0;
            box-shadow: 2px 0 4px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
        }

        .sidebar img.logo {
            display: block;
            max-width: 150px;
            height: auto;
            margin: 0 auto 20px auto;
        }

        .sidebar ul {
            list-style: none; /* Supprime les puces */
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            margin: 10px 0; /* Espacement entre les éléments */
        }

        .sidebar ul li a {
            display: block;
            text-decoration: none;
            color: black;
            padding: 10px 20px; /* Étend la zone cliquable */
            border-radius: 8px; /* Coins arrondis */
            transition: background-color 0.3s ease, color 0.3s ease; /* Transition fluide */
        }

        .sidebar ul li a:hover {
            background-color: #145fad; /* Couleur de hover */
            color: white;
        }

        .sidebar ul li a.active {
            background-color:  #e74f1d; /* Couleur de l'élément actif */
            color: white;
        }

        /* Header Styles */
        header {
            background-color: #f4f4f9; /* Fond identique au body */
            color: black;
            padding: 37px;
            display: flex;
            justify-content: space-between; /* Espacement entre les éléments */
            align-items: center;
            position: fixed;
            top: 0;
            left: 250px; /* Décalage du header à droite de la sidebar */
            width: calc(100% - 250px); /* Le header occupe tout l'espace restant */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
            position: absolute;
            right: 20px; /* Aligner à droite */
        }

        .profile img {
            border-radius: 50%;
            width: 60px; /* Taille de l'avatar ajustée */
            height: 60px; /* Taille de l'avatar ajustée */
            object-fit: cover; /* Ajustement de l'image pour remplir le cercle */
            cursor: pointer;
            border: 2px solid #e64614; /* Bordure autour de l'avatar */
        }

        /* Menu déroulant du profil */
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            min-width: 160px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            display: none; /* Initialement caché */
        }

        .dropdown-item:hover {
            background-color: #e74f1d;
            color: white;
        }

        .dropdown-item {
            padding: 10px;
            text-align: left;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 250px; /* Le contenu commence après la sidebar */
            padding: 20px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            header {
                left: 200px;
                width: calc(100% - 200px);
            }

            .main-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                box-shadow: none;
                padding: 10px;
            }

            header {
                left: 0;
                width: 100%;
            }

            .main-content {
                margin-left: 0;
            }

            .sidebar img.logo {
                max-width: 120px;
            }

            .profile {
                gap: 5px;
            }

            .profile img {
                width: 30px;
                height: 30px;
            }
        }
    </style>

    @yield('styles') <!-- Cette ligne permet d'injecter du CSS spécifique depuis vos vues -->
</head>

<body>
    <!-- Header -->
    <header>
        <!-- Profil Admin avec menu déroulant -->
        @if(Auth::check())
        <div class="profile">
            <div style="position: relative; display: inline-block;">
                <!-- Avatar avec ajustement -->
                <img src="{{ asset('images/avatar.avif') }}" alt="Avatar" id="avatar" class="dropdown-toggle">
                <!-- Affichage du nom de l'utilisateur connecté -->
                <span>{{ auth()->user()->name }}</span>
            </div>

            <!-- Menu déroulant -->
            <ul class="dropdown-menu" id="dropdownMenu">
                <li><a class="dropdown-item" href="{{ route('profile.show') }}">
                    <span class="menu-icon">&#128100;</span> Profil
                </a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="dropdown-item">
                        @csrf
                        <button type="submit" class="btn btn-link" style="color: inherit; text-decoration: none;">
                            <span class="menu-icon">&#128679;</span> Déconnexion
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        @else
        <p>Veuillez vous connecter pour voir votre profil.</p>
        @endif
    </header>

    <!-- Sidebar -->
    <div class="sidebar">
        <img src="{{ asset('images/Logo2snd.png') }}" class="logo" alt="Logo"> <!-- Logo déplacé dans la sidebar -->
        <ul>
            <li><a href="{{ route('dashboard') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}"><span class="menu-icon">&#128200;</span><span class="menu-text">Tableau de bord</span></a></li>
            <li><a href="{{ route('statistics.general') }}" class="{{ Request::is('statistics*') ? 'active' : '' }}"><span class="menu-icon">&#128221;</span><span class="menu-text">Rapports</span></a></li>
            <li><a href="{{ route('books.index') }}" class="{{ Request::is('books*') ? 'active' : '' }}"><span class="menu-icon">&#128213;</span><span class="menu-text">Livres</span></a></li>
            <li><a href="{{ route('borrows.index') }}" class="{{ Request::is('borrows*') ? 'active' : '' }}"><span class="menu-icon">&#128214;</span><span class="menu-text">Emprunts</span></a></li>
            <li><a href="{{ route('borrower_profiles.index') }}" class="{{ Request::is('borrower_profiles*') ? 'active' : '' }}"><span class="menu-icon">&#128100;</span><span class="menu-text">Profils Emprunteur</span></a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // JavaScript pour activer l'affichage du menu déroulant sur clic
        const avatar = document.getElementById('avatar');
        const dropdownMenu = document.getElementById('dropdownMenu');

        avatar.addEventListener('click', (event) => {
            event.stopPropagation();  // Empêche le clic de se propager à d'autres éléments
            dropdownMenu.classList.toggle('show');  // Affiche ou masque le menu déroulant
        });

        // Masquer le menu lorsqu'on clique ailleurs sur la page
        document.addEventListener('click', (event) => {
            if (!avatar.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.remove('show');
            }
        });
    </script>
</body>

</html>
