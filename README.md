# DinoChat - Cahier des Charges (MVP)

## Description du Projet
DinoChat est une application de chat en ligne permettant aux utilisateurs de communiquer via un chat global et des messages privés. Elle offre une interface interactive, moderne, et intuitive, avec des fonctionnalités clés comme l'ajout d'émojis et de réactions aux messages. Le projet sera développé en **PHP**.

---

## Fonctionnalités Clés

### 1. Connexion et Inscription
- **Création de compte** : Les utilisateurs peuvent s'inscrire avec un email, un pseudo, et un mot de passe.
- **Connexion** : Les utilisateurs peuvent se connecter avec leur pseudo ou email et mot de passe.
- **(Facultatif)** Réinitialisation de mot de passe : Une option "Mot de passe oublié" peut être mise en place pour réinitialiser un mot de passe oublié.

### 2. Chat Global
- Accès à un chat global visible par tous les utilisateurs connectés.
- Les messages affichent :
  - Pseudo de l'utilisateur.
  - Contenu du message.
  - Heure d'envoi.
- Mise à jour des messages en temps réel (sans rechargement de la page).

### 3. Recherche et Messages Privés
- **Recherche d'utilisateurs** : Une barre de recherche permet de trouver des utilisateurs par pseudo.
- **Messages privés** :
  - Interface dédiée pour échanger avec un utilisateur en privé.
  - Les messages privés sont affichés chronologiquement.
  - Notifications pour les nouveaux messages privés reçus.

### 4. Émojis et Réactions
- **Émojis** : Les utilisateurs peuvent insérer des émojis dans leurs messages grâce à un bouton dédié.
- **Réactions** :
  - Les utilisateurs peuvent réagir aux messages avec des émojis.
  - Les réactions sont visibles sous chaque message avec le nombre d’utilisateurs ayant réagi.

---

## Architecture Technique

### Langages et Technologies
- **Backend** : PHP
- **Base de données** : MySQL (pour les utilisateurs, messages, et réactions).
- **Frontend** : HTML, CSS, JavaScript (AJAX/WebSocket pour la mise à jour en temps réel).
- **Authentification** : Sessions utilisateur via PHP, avec tokens sécurisés ou cookies.
- **WebSocket** : Utilisation de Ratchet ou une bibliothèque similaire pour le chat en temps réel.

### Sécurité
- Les mots de passe sont hashés avant stockage (par exemple, avec bcrypt).
- Protection contre les attaques XSS et CSRF.
- Limitation des tentatives de connexion pour prévenir les attaques par force brute.
- Validation et nettoyage des données utilisateur côté serveur.

---

## Design de l'Interface Utilisateur (UI)

### Pages
- **Connexion/Inscription** : Interface claire et responsive avec champs intuitifs pour pseudo, email, et mot de passe.
- **Chat Global** : Liste de messages avec :
  - Avatar utilisateur.
  - Pseudo.
  - Contenu du message.
  - Heure d’envoi.
- **Messages Privés** : Interface similaire au chat global mais pour deux utilisateurs spécifiques.
- **Émojis et Réactions** :
  - Popup ou menu déroulant pour sélectionner les émojis.
  - Réactions compactes sous les messages.

---

## Livrables
- Application fonctionnelle avec toutes les fonctionnalités décrites.
- Documentation technique pour les développeurs. (facultatif)
- Guide d’utilisation pour les utilisateurs finaux. (facultatif)


---

## Critères de Réussite
- L'application est intuitive, stable et rapide.
- Les messages sont affichés et mis à jour en temps réel.
- Les émojis et réactions fonctionnent correctement.
- Les données utilisateur sont sécurisées.

---
