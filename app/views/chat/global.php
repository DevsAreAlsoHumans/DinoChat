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
    <div class="container-chats">
        <div id="chat-global" class="card p-4 active">
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


        <div id="private-chat" class="card p-4" style="display: none;">
            <h3 id="private-chat-title" class="text-center mb-4">Conversation privée</h3>
            <button id="close-private-chat" class="btn btn-secondary mb-3">Fermer</button>
            
            <div id="private-chat-box" class="chat-box mb-3"></div>
            <form id="private-chat-form">

                <div class="input-group">
                    <button type="button" id="private-emoji-picker-button" class="btn btn-secondary">😀</button>
                    <input type="text" id="private-message-input" class="form-control" placeholder="Écrivez un message..." required>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>

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

    <script src="/public/js/chat.js"></script>
</body>
</html>
