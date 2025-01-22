<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Global - DinoChat</title>
    <!-- bootstrap Autorisée possibilité de le personnalisée -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/public/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container-chats">

        <!-- Section Chat Global -->
        <h3 class="text-center">Chat Global</h3>
        <input type="text" class="form-control" placeholder="Rechercher...">
        <ul class="list-group d-none"></ul>
        <!-- Zone pour afficher les messages du chat global -->
        <!-- Formulaire pour envoyer un message global -->
        <input type="text" class="form-control" placeholder="Message..." required>
        <button class="btn btn-primary">Envoyer</button>
        <!-- Zone pour sélectionner les émojis -->
        <span style="cursor: pointer; font-size: 1.5rem;">😀</span>

        <!-- Section Chat Privé -->
        <h3 class="text-center">Conversation Privée</h3>
        <button class="btn btn-secondary">Fermer</button>
        <!-- Zone pour afficher les messages privés -->
        <!-- Formulaire pour envoyer un message privé -->
        <input type="text" class="form-control" placeholder="Message..." required>
        <button class="btn btn-primary">Envoyer</button>
        <!-- Zone pour sélectionner les émojis privés -->
        <span style="cursor: pointer; font-size: 1.5rem;">😀</span>

    </div>

    <script src="/public/js/chat.js"></script>
</body>
</html>
