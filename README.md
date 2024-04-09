# Installation du Blog

Ce guide vous aidera à installer et à configurer notre blog.

## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre système :

- PHP (version 8.2)
- Composer
- Serveur de base de données MySQL
- Un navigateur web (Google Chrome, Mozilla Firefox, etc.)
- Docker Desktop

## Étapes d'installation

1. **Cloner le dépôt GitHub :**

   ```bash
   git clone https://github.com/BlogTeamDyna/blog
   ```

2. **Installer les dépendances avec Composer :**

   ```bash
   cd blog
   composer install
   ```

3. **Configurer le fichier .env :**

   Copiez le fichier `.env.example` et renommez-le en `.env`. Modifiez les valeurs des variables d'environnement pour correspondre à votre configuration de base de données et d'autres paramètres nécessaires.
   

4. **Exécuter les migrations de la base de données :**

   ```bash
   php bin/console doctrine:migrations:migrate
   ```

5. **Démarrez docker desktop et jouer la commande afin de démarrer les conteneurs de développement :**

   ```bash
   docker-compose up
   ```

6. **Accédez à l'application dans votre navigateur :**

   Ouvrez votre navigateur web et accédez à l'URL suivante : `http://localhost:3306`

