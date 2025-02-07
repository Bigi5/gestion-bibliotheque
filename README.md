# 📚 Gestion de Bibliothèque

Ce projet est une application web développée avec Laravel pour la gestion des prêts de livres.

## 🚀 Installation

### 1️⃣ Cloner le dépôt
```sh
git clone https://github.com/Bigi5/gestion-bibliotheque.git
cd gestion-bibliotheque

2️⃣ #Installer les dépendances
    composer install
    npm install

3️⃣ #Configurer l'application
Copiez le fichier .env.example en .env
    cp .env.example .env

#Générez la clé d'application :
    php artisan key:generate

4️⃣ #Configurer la base de données
Modifiez le fichier .env avec vos informations de base de données, puis exécutez :
    php artisan migrate --seed
5️⃣ Lancer le serveur local
     php artisan serve

📌 #Fonctionnalités
📖 Gestion des livres
👤 Gestion des utilisateurs
📅 Gestion des prêts et retours

🤝 #Contribuer
    Forker le projet 🍴
    Créer une branche 🔀 (git checkout -b feature-nouvelle-fonctionnalite)
    Committer vos modifications 🎯 (git commit -m "Ajout d'une nouvelle fonctionnalité")
    Pousser la branche 📤 (git push origin feature-nouvelle-fonctionnalite)
    Ouvrir une Pull Request 🛠️
