# Projet Cyber-Incident
**Plateforme de gestion et de signalement d’incidents de sécurité**

Ce projet a été réalisé dans le cadre du BTS SIO (Services Informatiques aux Organisations), option SLAM.
L'objectif est de proposer une solution technique permettant de recenser et traiter des incidents de cybersécurité, tout en appliquant les bonnes pratiques de développement web sécurisé.

## Architecture Technique
Le projet est développé en PHP natif (sans framework) afin de maîtriser l'ensemble des flux de données et des mécanismes de sécurité. L'architecture respecte le principe de séparation des responsabilités (MVC simplifié).

**Structure des dossiers :**
- `assets/` : Feuilles de style CSS et images.
- `config/` : Configuration de la base de données (PDO).
- `includes/` : Bibliothèques de fonctions et templates HTML (Header/Footer).
- `admin/` : Interface de gestion réservée aux administrateurs.
- `uploads/` : Zone de stockage des preuves (sécurisée via .htaccess).
- `fichiers racine` : Contrôleurs principaux (login, register, report...).

## Mesures de Sécurité
Conformément aux exigences du référentiel SIO, une attention particulière a été portée à la sécurité applicative :

1.  **Injections SQL** : Toutes les requêtes vers la base de données utilisent des requêtes préparées via l'objet PDO.
2.  **Protection XSS** : Les entrées utilisateurs sont systématiquement échappées avant affichage.
3.  **Cross-Site Request Forgery (CSRF)** : Un système de jetons (tokens) protège l'ensemble des formulaires.
4.  **Authentification** : Utilisation de l'algorithme BCRYPT pour le hachage des mots de passe.
5.  **Sécurité des fichiers** : Vérification des types MIME lors de l'upload et restrictions d'accès serveur (.htaccess).
6.  **Traçabilité (Logs)** : Journalisation centrale de toutes les actions sensibles (connexions, signalements, modifications) avec horodatage et IP.
7.  **Protection Brute-Force** : Banissement temporaire des adresses IP après 5 tentatives de connexion erronées (Rate Limiting).

## Déploiement
Le projet nécessite un serveur Apache/MySQL (environnement WAMP/XAMPP recommandé).
Les instructions détaillées sont disponibles dans le fichier `INSTALLATION.md`.

---
*Projet réalisé pour dossier professionnel BTS SIO.*
*Auteur : Mathys SIO*

