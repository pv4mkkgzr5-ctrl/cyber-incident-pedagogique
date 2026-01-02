# 🛠️ Guide d'Installation et de Déploiement

Ce guide détaille comment installer l'environnement local et importer la base de données pour le projet **CYBER-INCIDENT**.

## 1. Pré-requis : Serveur Local (XAMPP ou WAMP)
Il faut un serveur Apache et MySQL.

### Pour XAMPP
- Dossier racine : `C:\xampp\htdocs\`
- URL : `http://localhost/cyber-incident/`

### Pour WAMP (Ce que vous utilisez)
- Dossier racine : `C:\wamp64\www\` (ou `C:\wamp\www\`)
- Lancer WampServer (icône verte dans la barre des tâches).

## 2. Placement du Projet
1. Copier le dossier `cyber-incident` complet.
2. Le coller dans le dossier racine de votre serveur :
   - **WAMP** : `C:\wamp64\www\cyber-incident\`
   - **XAMPP** : `C:\xampp\htdocs\cyber-incident\`

## 3. Configuration de la Base de Données

### A. Accéder à phpMyAdmin
1. Ouvrir votre navigateur web.
2. Aller à l'adresse : `http://localhost/phpmyadmin`.
   - *Note WAMP : Si ça ne marche pas, clic gauche sur l’icône WAMP > phpMyAdmin.*

### B. Créer la base
1. Cliquer sur l'onglet **"Bases de données"** (en haut).
2. Dans le champ "Nom de la base de données", écrire : `cyber_incident`.
3. Sélectionner l'encodage : `utf8mb4_general_ci` (ou `unicode_ci`).
4. Cliquer sur **"Créer"**.

### C. Importer le fichier SQL
1. Dans la colonne de gauche, cliquer sur la nouvelle base `cyber_incident`.
2. Cliquer sur l'onglet **"Importer"**.
3. Cliquer sur **"Choisir un fichier"**.
4. Sélectionner le fichier `database.sql` (dans le dossier `cyber-incident`).
5. Cliquer sur le bouton **"Importer"**.

✅ *Un message vert devrait confirmer : "L'importation a réussi".*

## 4. Connexion à la base (Login WAMP)
Attention, sur WAMP, il y a parfois un mot de passe ou l'utilisateur n'est pas "root".
Vérifiez `config/db.php` si vous avez une erreur de connexion.
Par défaut :
- User: `root`
- Password: `` (vide)

## 5. Vérification
Allez sur `http://localhost/cyber-incident/`.
