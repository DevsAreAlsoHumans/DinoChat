<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Global - DinoChat</title>

    <?php
    if (!isset($_SESSION['user']['pseudo'])) {
        $_SESSION['user']['pseudo'] = 'Utilisateur'; // Valeur par défaut
    }
    ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/public/css/style.css" rel="stylesheet">
    <style>
        /* Ajout de style pour les réactions */
        .reactions {
            margin-top: 5px;
            display: flex;
            gap: 5px;
            align-items: center;
        }
        .reaction {
            cursor: pointer;
            font-size: 1.2rem;
        }
        .add-reaction {
            cursor: pointer;
            font-size: 1.2rem;
            color: #aaa;
        }
        .emoji-picker {
            position: absolute;
            z-index: 9999;
            background: white;
            border: 1px solid #ccc;
            padding: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .emoji-picker span {
            font-size: 1.5rem;
            margin: 5px;
            cursor: pointer;
        }
        .emoji-picker span:hover {
            background-color: #f0f0f0;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div id="cookie-banner" style="position: fixed; bottom: 0; width: 100%; background: #333; color: white; padding: 10px; text-align: center; z-index: 1000;">
        <span>Ce site utilise des cookies pour améliorer votre expérience. Acceptez-vous les cookies ?</span>
        <button id="accept-cookies" style="margin: 0 10px; padding: 5px 10px; background: green; color: white; border: none; cursor: pointer;">
            Accepter
        </button>
        <button id="reject-cookies" style="margin: 0 10px; padding: 5px 10px; background: red; color: white; border: none; cursor: pointer;">
            Refuser
        </button>
    </div>


    <!-- Écrou denté pour accéder aux paramètres -->
    <div id="settings-button" class="settings-icon">
        <img src="/public/images/settings-icon.png" alt="Paramètres" />
    </div>

    <!-- Fenêtre modale des paramètres -->
    <div id="settings-modal" class="settings-modal">
        <div class="settings-modal-content">
            <span id="close-settings" class="close-settings">&times;</span>
            <h2>Bienvenue dans vos paramètres, <span id="user-pseudo"></span> !</h2>
            <div class="settings-option">
                <img id="notification-sound-icon" src="/public/images/sound-icon.png" alt="Son activé" />
                <span id="toggle-sound">Retirer le son des notifications</span>
            </div>
        </div>
    </div>

    <!-- Barre latérale -->
    <div id="sidebar" class="sidebar">
        <button id="sidebar-toggle" class="btn btn-secondary">☰ <span id="menu-notification-badge" class="badge bg-danger position-absolute start-0 top-0 translate-middle">
            0
        </span> </button>
        <h5>Conversations</h5>
        <ul id="conversations-list" class="list-group"></ul>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Chat Global -->
            <div class="col-md-6">
                <div class="card p-4">
                    <h3 id="chat-title" class="text-center mb-4">Chat Global</h3>
                    <input type="text" id="search-user" class="form-control mb-3" placeholder="Rechercher un utilisateur...">
                    <ul id="user-results" class="list-group mb-3 d-none"></ul>
                    <div id="chat-box" class="chat-box mb-3"></div>

                    <form id="chat-form">
                        <div class="input-group">
                            <!-- Bouton pour les émojis -->
                            <button type="button" id="emoji-picker-button" class="btn btn-secondary">😀</button>
                            <input type="text" id="message-input" class="form-control" placeholder="Écrivez un message..." required>
                            <button type="submit" class="btn btn-primary">Envoyer</button>
                        </div>
                        <!-- Conteneur des émojis -->
                        <div id="emoji-container" class="mt-2">
                            <span style="cursor: pointer; font-size: 1.5rem;">😀</span>
                            <span style="cursor: pointer; font-size: 1.5rem;">😂</span>
                            <span style="cursor: pointer; font-size: 1.5rem;">😍</span>
                            <span style="cursor: pointer; font-size: 1.5rem;">👍</span>
                            <span style="cursor: pointer; font-size: 1.5rem;">❤️</span>
                            <span style="cursor: pointer; font-size: 1.5rem;">🔥</span>
                            <span style="cursor: pointer; font-size: 1.5rem;">🎉</span>
                            <span style="cursor: pointer; font-size: 1.5rem;">😢</span>
                            <span style="cursor: pointer; font-size: 1.5rem;">😡</span>
                            <span style="cursor: pointer; font-size: 1.5rem;">🙏</span>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Chat Privé -->
            <div id="private-chat" class="col-md-6" style="display: none;">
                <div class="card p-4">
                    <h3 id="private-chat-title" class="text-center mb-4">Conversation privée</h3>
                    <button id="close-private-chat" class="btn btn-secondary mb-3">Fermer</button>

                    <!-- Boîte de messages privés -->
                    <div id="private-chat-box" class="chat-box mb-3"></div>
                    
                    <!-- Formulaire de messages privés -->
                    <form id="private-chat-form">
                        <div class="input-group">
                            <!-- Bouton pour les émojis dans le chat privé -->
                            <button type="button" id="private-emoji-picker-button" class="btn btn-secondary">😀</button>
                            <input type="text" id="private-message-input" class="form-control" placeholder="Écrivez un message..." required>
                            <button type="submit" class="btn btn-primary">Envoyer</button>
                        </div>
                        <!-- Conteneur des émojis pour le chat privé -->
                        <div id="private-emoji-container" class="mt-2">
                            <span style="cursor: pointer; font-size: 1.5rem;">😀</span>
                            <span style="cursor: pointer; font-size: 1.5rem;">😂</span>
                            <span style="cursor: pointer; font-size: 1.5rem;">😍</span>
                            <span style="cursor: pointer; font-size: 1.5rem;">👍</span>
                            <span style="cursor: pointer; font-size: 1.5rem;">❤️</span>
                            <span style="cursor: pointer; font-size: 1.5rem;">🔥</span>
                            <span style="cursor: pointer; font-size: 1.5rem;">🎉</span>
                            <span style="cursor: pointer; font-size: 1.5rem;">😢</span>
                            <span style="cursor: pointer; font-size: 1.5rem;">😡</span>
                            <span style="cursor: pointer; font-size: 1.5rem;">🙏</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sélecteur d'émojis global -->
    <div id="emoji-picker" class="emoji-picker" style="display: none;"></div>

    <script>
        const userPseudo = "<?php echo htmlspecialchars($_SESSION['user']['pseudo'] ?? 'Utilisateur'); ?>";
    </script>
    <script src="/public/js/chat.js"></script>
</body>
</html>
