# CYBER-INCIDENT 🛡️
**Plateforme de gestion et de signalement d’incidents cyber**

Ce projet est une application pédagogique réalisée dans le cadre du BTS SIO SLAM. Il vise à démontrer les compétences en développement web sécurisé.

## 📂 1. Architecture du Projet
L'architecture suit une organisation logique et modulaire ("Separation of Concerns") sans utiliser de framework lourd, parfait pour comprendre les bases.

```
cyber-incident/
├── assets/              # Ressources statiques
│   ├── css/             # Feuilles de style "Dark Mode"
├── config/              # Configuration
│   └── db.php           # Connexion BDD (PDO) centralisée
├── includes/            # Fragments de code réutilisables
│   ├── functions.php    # Fonctions de sécurité (XSS, CSRF)
│   ├── header.php       # En-tête HTML
│   └── footer.php       # Pied de page HTML
├── admin/               # Espace administration
│   ├── dashboard.php    # Liste des incidents
│   └── view_incident.php # Gestion d'un incident
├── uploads/             # Stockage sécurisé (.htaccess)
├── index.php            # Page d'accueil
├── login.php            # Connexion
├── register.php         # Inscription
├── report.php           # Formulaire de signalement
└── logout.php           # Déconnexion
```

## 🔐 2. Sécurité Implémentée (Points Forts)
Ce projet respecte les recommandations de l'OWASP pour les étudiants :

*   **Injections SQL** : Bloquées via `PDO::prepare()`.
*   **XSS (Cross-Site Scripting)** : Toutes les données affichées sont nettoyées.
*   **CSRF** : Protection des formulaires par jeton (Token).
*   **Session Fixation** : Régénération des ID de session à la connexion.
*   **Mots de Passe** : Hachage fort (`BCRYPT`).

## 🚀 Installation
Voir le fichier `INSTALLATION.md` pour déployer sur XAMPP/WAMP.

---
*Projet réalisé pour dossier professionnel BTS SIO - Option SLAM.*
*Auteur : Mathy SIO*

