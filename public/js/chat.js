document.addEventListener('DOMContentLoaded', function () {

    // Variables pour les éléments du DOM
    const chatBox = document.getElementById('chat-box');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');

    const searchUser = document.getElementById('search-user');
    const userResults = document.getElementById('user-results');
    const privateChatBox = document.getElementById('private-chat-box');
    const privateChatForm = document.getElementById('private-chat-form');
    const privateMessageInput = document.getElementById('private-message-input');
    const privateChatTitle = document.getElementById('private-chat-title');
    const closePrivateChatButton = document.getElementById('close-private-chat');

    const emojiContainer = document.getElementById('emoji-container');
    const emojiPickerButton = document.getElementById('emoji-picker-button');

    const privateEmojiContainer = document.getElementById('private-emoji-container');
    const privateEmojiPickerButton = document.getElementById('private-emoji-picker-button');

    let currentReceiverId = null;

    // Fonction pour charger les messages
    function loadMessages() {
        // À compléter : Appel à l'API pour récupérer les messages et mise à jour de l'interface
    }

    // Fonction pour envoyer un message
    function sendMessage(event, isPrivate = false) {
        // À compléter : Envoi du message au serveur et réinitialisation du champ d'entrée
    }

    // Recherche d'utilisateurs
    searchUser.addEventListener('input', function () {
        // À compléter : Recherche dynamique des utilisateurs par leur pseudo
    });

    // Démarrer une conversation privée
    function startPrivateChat(receiverId, pseudo) {
        // À compléter : Initialisation de la conversation privée avec un utilisateur
    }

    // Fermeture de la conversation privée
    closePrivateChatButton.addEventListener('click', function () {
    });

    // Gestion des émojis
    emojiPickerButton.addEventListener('click', function () {
        // À compléter : Affichage du sélecteur d'émojis
    });

    emojiContainer.addEventListener('click', function (event) {
        // À compléter : Ajout d'un émoji au champ de message
    });

    privateEmojiPickerButton.addEventListener('click', function () {
        // À compléter : Affichage du sélecteur d'émojis privé
    });

    privateEmojiContainer.addEventListener('click', function (event) {
        // À compléter : Ajout d'un émoji au champ de message privé
    });

    // Gestion des envois de formulaire / chargement périodique

});
