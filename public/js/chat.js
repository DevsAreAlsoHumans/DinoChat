document.addEventListener('DOMContentLoaded', function () {
    // Sélection des éléments du DOM
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const conversationsList = document.getElementById('conversations-list');

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

    // Fonction pour charger les messages globaux
    function loadGlobalMessages() {
        fetch('/chat/messages')
            .then(response => response.json())
            .then(data => {
                chatBox.innerHTML = '';
                data.forEach(message => {
                    const messageElement = document.createElement('div');
                    messageElement.classList.add('message');
                    const pseudo = message.pseudo || "Utilisateur";
                    messageElement.innerHTML = `<strong>${pseudo} :</strong> ${message.content}`;
                    chatBox.appendChild(messageElement);
                });
                chatBox.scrollTop = chatBox.scrollHeight;
            })
            .catch(error => console.error('Erreur lors du chargement des messages globaux :', error));
    }

    // Fonction pour charger les messages privés
    function loadPrivateMessages() {
        if (!currentReceiverId) return;

        fetch(`/chat/private/${currentReceiverId}/messages`)
            .then(response => response.json())
            .then(data => {
                privateChatBox.innerHTML = '';
                data.forEach(message => {
                    const messageElement = document.createElement('div');
                    messageElement.classList.add('message');
                    const pseudo = message.sender_pseudo || "Utilisateur";
                    messageElement.innerHTML = `<strong>${pseudo} :</strong> ${message.content}`;
                    privateChatBox.appendChild(messageElement);
                });
                privateChatBox.scrollTop = privateChatBox.scrollHeight;
            })
            .catch(error => console.error('Erreur lors du chargement des messages privés :', error));
    }

    // Fonction pour envoyer un message
    function sendMessage(event, isPrivate = false) {
        event.preventDefault();
        const message = isPrivate ? privateMessageInput.value : messageInput.value;
        const endpoint = isPrivate
            ? `/chat/private/${currentReceiverId}/send`
            : '/chat/send';

        fetch(endpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (isPrivate) {
                        privateMessageInput.value = '';
                        loadPrivateMessages();
                    } else {
                        messageInput.value = '';
                        loadGlobalMessages();
                    }
                } else {
                    console.error('Erreur lors de l\'envoi du message :', data.error);
                }
            })
            .catch(error => console.error('Erreur lors de l\'envoi du message :', error));
    }

    // Fonction pour rechercher des utilisateurs
    searchUser.addEventListener('input', function () {
        const query = this.value;
        if (query.length > 0) {
            fetch(`/chat/private/search?query=${query}`)
                .then(response => response.json())
                .then(users => {
                    userResults.innerHTML = '';
                    userResults.classList.remove('d-none');
                    users.forEach(user => {
                        const li = document.createElement('li');
                        li.textContent = user.pseudo;
                        li.className = 'list-group-item';
                        li.style.cursor = 'pointer';
                        li.addEventListener('click', () => startPrivateChat(user.id, user.pseudo));
                        userResults.appendChild(li);
                    });
                })
                .catch(error => console.error('Erreur lors de la recherche d\'utilisateurs :', error));
        } else {
            userResults.classList.add('d-none');
        }
    });

    function loadConversations() {
        fetch('/chat/conversations')
            .then(response => response.json())
            .then(conversations => {
                conversationsList.innerHTML = '';
                conversations.forEach(conversation => {
                    addConversationToSidebar(conversation.user_id, conversation.pseudo);
                });
            })
            .catch(error => console.error('Erreur lors du chargement des conversations :', error));
    }

    function addConversationToSidebar(receiverId, pseudo) {
        const existingItem = Array.from(conversationsList.children).find(
            item => item.dataset.userId === String(receiverId)
        );

        if (!existingItem) {
            const li = document.createElement('li');
            li.textContent = pseudo;
            li.className = 'list-group-item';
            li.style.cursor = 'pointer';
            li.dataset.userId = receiverId;
            li.addEventListener('click', () => startPrivateChat(receiverId, pseudo));
            conversationsList.appendChild(li);
        }
    }

    function startPrivateChat(receiverId, pseudo) {
        currentReceiverId = receiverId;
        privateChatTitle.textContent = `Conversation privée avec ${pseudo}`;
        document.getElementById('private-chat').style.display = 'block';
        loadPrivateMessages();
        addConversationToSidebar(receiverId, pseudo);
    }

    closePrivateChatButton.addEventListener('click', function () {
        currentReceiverId = null;
        document.getElementById('private-chat').style.display = 'none';
    });

    // Gestion des émojis
    emojiPickerButton.addEventListener('click', function () {
        emojiContainer.style.display = emojiContainer.style.display === 'none' ? 'block' : 'none';
    });

    emojiContainer.addEventListener('click', function (event) {
        if (event.target.tagName === 'SPAN') {
            messageInput.value += event.target.textContent;
            messageInput.focus();
        }
    });

    privateEmojiPickerButton.addEventListener('click', function () {
        privateEmojiContainer.style.display = privateEmojiContainer.style.display === 'none' ? 'block' : 'none';
    });

    privateEmojiContainer.addEventListener('click', function (event) {
        if (event.target.tagName === 'SPAN') {
            privateMessageInput.value += event.target.textContent;
            privateMessageInput.focus();
        }
    });

    sidebarToggle.addEventListener('click', function () {
        sidebar.classList.toggle('open');
    });

    chatForm.addEventListener('submit', event => sendMessage(event, false));
    privateChatForm.addEventListener('submit', event => sendMessage(event, true));

    setInterval(() => {
        loadGlobalMessages();
        loadPrivateMessages();
    }, 2000);

    loadGlobalMessages();
    loadConversations();
});
