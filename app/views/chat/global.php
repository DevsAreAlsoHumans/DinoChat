<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Global - DinoChat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/public/css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Barre latérale -->
    <div id="sidebar" class="sidebar">
        <button id="sidebar-toggle" class="btn btn-secondary">☰</button>
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
                            <button type="button" id="emoji-picker-button" class="btn btn-secondary">😀</button>
                            <input type="text" id="message-input" class="form-control" placeholder="Écrivez un message..." required>
                            <button type="submit" class="btn btn-primary">Envoyer</button>
                        </div>
                        <div id="emoji-container" class="mt-2 d-none">
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
                    <div id="private-chat-box" class="chat-box"></div>
                    <form id="private-chat-form">
                        <div class="input-group">
                            <button type="button" id="private-emoji-picker-button" class="btn btn-secondary">😀</button>
                            <input type="text" id="private-message-input" class="form-control" placeholder="Écrivez un message..." required>
                            <button type="submit" class="btn btn-primary">Envoyer</button>
                        </div>
                        <div id="private-emoji-container" class="mt-2 d-none">
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

    <script src="/public/js/chat.js"></script>
</body>
</html>
