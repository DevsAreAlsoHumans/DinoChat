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
  - Les réactions sont visibles sous chaque message avec le nombre d’utilisateurs ayant réagi dans le chat global.

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
---
---

# DinoChat - Note de Cadrage

## **Contexte de la demande**
Le projet **DinoChat** répond au besoin d'une application de messagerie en ligne permettant une communication instantanée entre utilisateurs à travers un chat global et des messages privés.  
L'objectif principal est de proposer une solution web (excluant le mobile) offrant une expérience fluide, interactive et moderne tout en intégrant des fonctionnalités conviviales telles que l'ajout d'émojis et de réactions.

---

## **Environnement**
- **Technologies** :
  - Backend : PHP
  - Base de données : MySQL
  - Frontend : HTML, CSS, JavaScript (AJAX ou WebSocket pour la mise à jour en temps réel)
- **Sécurité** :
  - Hashage des mots de passe
  - Prévention des attaques XSS/CSRF
  - Validation des données utilisateur côté serveur
- **Utilisation cible** :  
  - L’application sera accessible exclusivement sur navigateur web et optimisée pour un usage desktop.

---

## **Opportunité & Faisabilité**
### **Opportunité**  
Répondre à la demande croissante d’outils de communication simples mais interactifs, adaptés à des échanges professionnels ou personnels.  

### **Faisabilité**
- **Techniques** :  
  Les technologies retenues sont courantes et maîtrisées par les équipes.
- **Financières** :  
  Une solution économiquement viable grâce à l'utilisation d'outils open source.
- **Temps** :  
  Le périmètre du projet est adapté à un délai réaliste pour un MVP.

---

## **Le constat de la demande**
- **Pourquoi** :  
  Le besoin est de créer une plateforme unique et intuitive pour une communication fluide et interactive.  
- **Pour quoi** :  
  Offrir un espace digital permettant des échanges instantanés et attractifs grâce à des fonctionnalités modernes comme les émojis et les réactions.

---

## **Les enjeux**
1. **Techniques** :  
   Développer un système de messagerie en temps réel performant et sécurisé.
2. **Expérience utilisateur** :  
   Garantir une interface simple et agréable, favorisant l'adoption.
3. **Sécurité** :  
   Assurer la confidentialité des données utilisateurs et des échanges.

---

## **Gains et pertes**
### **Gains**
- Mise à disposition d’un outil moderne et efficace.
- Fidélisation des utilisateurs grâce à une expérience interactive.

### **Pertes**
- Potentiel manque d’audience mobile dans la première version.

---

## **L’objet de la demande**
- **Demande** :  
  Développer une application web de chat offrant :
  - Un chat global.
  - Des messages privés avec recherche d’utilisateurs.
  - Un système d’émojis et de réactions.
- **Projet** :  
  Création d’un MVP (Minimum Viable Product).
- **Idée** :  
  Une plateforme simple mais attractive, orientée vers la communication en temps réel.

---

## **Les objectifs et le résultat attendu**
### **Objectifs**
1. Création d’un chat global fonctionnel.
2. Mise en place d’une messagerie privée avec notifications.
3. Intégration d’émojis et de réactions.

### **Résultats attendus**
- Application intuitive et performante.
- Mise à jour des messages en temps réel.
- Fonctionnalités sécurisées pour les utilisateurs.

### **Coût, Qualité, Délais (CQT)**
- **Coût** :  
  Utilisation de technologies open source pour réduire les coûts.
- **Qualité** :  
  Interface moderne et fonctionnalités stables.
- **Délais** :  
  Lancement d’un MVP dans un délai de 1 à 2 jours.

---

## **Le périmètre de la mission**
### **Processus inclus**
1. Développement backend et frontend.
2. Mise en place d’une base de données sécurisée.
3. Intégration d’émojis et de réactions.

### **Cahier des charges (CDC)**  
Respect des fonctionnalités clés définies dans le CDC.

### **Parties prenantes**
| **Rôle**           | **Responsabilité**                  |
|---------------------|-------------------------------------|
| **Chef de projet**  | Coordination et suivi du développement  Sacha |
| **Développeurs**    | Développement des fonctionnalités (backend/frontend)  Marius |


---

_Ce document sert de cadre structuré pour la planification et le suivi du projet DinoChat._
