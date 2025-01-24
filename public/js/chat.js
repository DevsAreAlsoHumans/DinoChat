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

    // Gestion de l'écrou
    const settingsButton = document.getElementById('settings-button');
    const settingsModal = document.getElementById('settings-modal');
    const closeSettingsButton = document.getElementById('close-settings');

    const userPseudoElement = document.getElementById('user-pseudo');
    
    if (typeof userPseudo !== 'undefined' && userPseudo) {
        userPseudoElement.textContent = userPseudo;
    } else {
        userPseudoElement.textContent = "Utilisateur";
    }

    // console.log("Pseudo utilisateur dans les paramètres : ", userPseudo);

    settingsButton.addEventListener('click', () => {
        settingsModal.style.display = 'block';
        // console.log('Fenêtre des paramètres ouverte.');
    });

    closeSettingsButton.addEventListener('click', () => {
        settingsModal.style.display = 'none';
        // console.log('Fenêtre des paramètres fermée.');
    });

    const notificationSoundIcon = document.getElementById('notification-sound-icon');
    const toggleSoundText = document.getElementById('toggle-sound');

    // État du son
    let soundEnabled = true;

    notificationSoundIcon.addEventListener('click', () => {
        soundEnabled = !soundEnabled;
        if (soundEnabled) {
            notificationSoundIcon.src = '/public/images/sound-icon.png';
            toggleSoundText.textContent = 'Retirer le son des notifications';
            // console.log('Son activé.');
        } else {
            notificationSoundIcon.src = '/public/images/sound-off-icon.png';
            toggleSoundText.textContent = 'Activer le son des notifications';
            // console.log('Son désactivé.');
        }
    });

    let currentReceiverId = null;

    let isLoadingGlobalMessages = false;

    // Pour garder une trace du dernier message chargé
    let lastMessageId = null;

    let notifiedGlobalMessages = new Set();

    function loadGlobalMessages() {
        if (isLoadingGlobalMessages) return;
        isLoadingGlobalMessages = true;

        fetch('/chat/messages')
            .then(response => response.json())
            .then(data => {
                // console.log("Messages globaux reçus :", data);

                const newMessages = data.filter(message => !lastMessageId || message.id > lastMessageId);

                if (newMessages.length > 0) {
                    newMessages.forEach(message => {
                        if (!message.id) {
                            console.error("Erreur : ID de message manquant pour ce message :", message);
                            return;
                        }

                        const messageElement = document.createElement('div');
                        messageElement.classList.add('message');
                        const pseudo = message.pseudo || "Utilisateur";
                        messageElement.innerHTML = `
                            <strong>${pseudo} :</strong> ${message.content}
                            <div class="reactions" data-message-id="${message.id}">
                                <span class="add-reaction">➕</span>
                            </div>
                        `;
                        chatBox.appendChild(messageElement);
                        loadReactions(message.id, messageElement.querySelector('.reactions'));

                        if (!notifiedGlobalMessages.has(message.id)) {
                            // playNotificationSound();
                            notifiedGlobalMessages.add(message.id);
                        }
                    });

                    lastMessageId = newMessages[newMessages.length - 1].id;
                    chatBox.scrollTop = chatBox.scrollHeight;
                } else {
                    // console.log("Aucun nouveau message.");
                }
            })
            .catch(error => console.error('Erreur lors du chargement des messages globaux :', error))
            .finally(() => {
                isLoadingGlobalMessages = false;
            });
    }



    

    // Fonction pour charger les messages privés
    let notifiedPrivateMessages = new Set();

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

                    if (!notifiedPrivateMessages.has(message.id)) {
                        // playNotificationSound();
                        notifiedPrivateMessages.add(message.id);
                    }
                });
                privateChatBox.scrollTop = privateChatBox.scrollHeight;
            })
            .catch(error => console.error('Erreur lors du chargement des messages privés :', error));
    }


    function loadReactions(messageId, container) {
        if (!messageId) {
            console.error('Erreur : messageId est indéfini.');
            return;
        }
    
        const previousReactions = container.dataset.reactions || "[]"; // Récupérer les réactions précédentes
        const parsedPreviousReactions = JSON.parse(previousReactions);
    
        fetch(`/reactions/${messageId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const newReactions = data.reactions;
                    if (JSON.stringify(parsedPreviousReactions) === JSON.stringify(newReactions)) {
                        // console.log(`Aucune nouvelle réaction pour le message ID : ${messageId}`);
                        return;
                    }
    
                    // console.log(`Nouvelles réactions pour le message ID : ${messageId}`, newReactions);
    
                    container.innerHTML = newReactions.map(reaction => `
                        <span class="reaction" title="Ajouté par ${reaction.user_pseudo} à ${new Date(reaction.created_at).toLocaleString()}">
                            ${reaction.emoji}
                        </span>
                    `).join('');
                    container.innerHTML += '<span class="add-reaction">➕</span>';
    
                    container.dataset.reactions = JSON.stringify(newReactions);
                } else {
                    console.error(`Aucune réaction trouvée pour le message ID : ${messageId}`);
                }
            })
            .catch(error => console.error('Erreur lors du chargement des réactions :', error));
    }
    
    
    
    function showEmojiPickerForMessage(messageId, targetElement) {
        const emojiPicker = document.getElementById('emoji-picker');
    
        if (!emojiPicker) {
            console.error("Le sélecteur d'émojis (emoji-picker) n'existe pas dans le DOM.");
            return;
        }
    
        emojiPicker.style.display = 'block';
    
        const rect = targetElement.getBoundingClientRect();
        emojiPicker.style.position = 'absolute';
        emojiPicker.style.left = `${rect.left}px`;
        emojiPicker.style.top = `${rect.bottom + window.scrollY}px`;
    
        emojiPicker.innerHTML = '😀 😂 😍 👍 ❤️ 🔥 🎉 😢 😡 🙏'.split(' ')
            .map(emoji => `<span class="emoji">${emoji}</span>`)
            .join('');
    
        emojiPicker.addEventListener('click', function handleEmojiClick(event) {
            if (event.target.classList.contains('emoji')) {
                const emoji = event.target.textContent;
    
                addReaction(messageId, emoji);
    
                emojiPicker.style.display = 'none';
                emojiPicker.removeEventListener('click', handleEmojiClick);
            }
        });
        document.addEventListener('click', function handleClickOutside(event) {
            if (!emojiPicker.contains(event.target) && event.target !== targetElement) {
                emojiPicker.style.display = 'none';
                document.removeEventListener('click', handleClickOutside);
            }
        }, { once: true });
    }    

    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('add-reaction')) {
            const messageId = event.target.parentElement.dataset.messageId;
            if (!messageId) {
                console.error('Erreur : messageId manquant pour ajouter une réaction.');
                return;
            }
            showEmojiPickerForMessage(messageId, event.target);
        }
    });
    

    function addReaction(messageId, emoji) {
        fetch('/reactions/add', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message_id: messageId, emoji }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // console.log(`Réaction "${emoji}" ajoutée au message ID : ${messageId}`);
                    const container = document.querySelector(`[data-message-id="${messageId}"]`);
                    loadReactions(messageId, container);
                } else {
                    console.error('Erreur lors de l\'ajout de la réaction :', data.message);
                }
            })
            .catch(error => console.error('Erreur lors de l\'ajout de la réaction :', error));
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

        markAsRead(receiverId);
    }

    let previousUnreadCount = 0;
    let notifiedPrivateConversations = new Set();
    let isLoadingNotifications = false;
    
    function loadNotifications() {
        if (isLoadingNotifications) return;
        isLoadingNotifications = true;

        fetch('/chat/notifications')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erreur HTTP ! statut : ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // console.log("Notifications reçues :", data);

                let totalUnread = 0;
                const existingItems = Array.from(conversationsList.children);

                data.forEach(conversation => {
                    const existingItem = existingItems.find(
                        li => parseInt(li.dataset.userId) === conversation.sender_id
                    );

                    if (existingItem) {
                        updateNotificationBadge(existingItem, conversation.unread_count);

                        if (
                            conversation.unread_count > 0 &&
                            !notifiedPrivateConversations.has(conversation.sender_id)
                        ) {
                            playNotificationSound(); //ici
                            notifiedPrivateConversations.add(conversation.sender_id);
                        }
                    } else {
                        const li = document.createElement('li');
                        li.textContent = conversation.sender_pseudo;
                        li.className = 'list-group-item';
                        li.style.cursor = 'pointer';
                        li.dataset.userId = conversation.sender_id;

                        li.addEventListener('click', () => {
                            startPrivateChat(conversation.sender_id, conversation.sender_pseudo);
                            markAsRead(conversation.sender_id);
                        });

                        updateNotificationBadge(li, conversation.unread_count);
                        conversationsList.appendChild(li);

                        if (!notifiedPrivateConversations.has(conversation.sender_id)) {
                            // playNotificationSound();
                            notifiedPrivateConversations.add(conversation.sender_id);
                        }
                    }

                    totalUnread += conversation.unread_count;
                });

                const menuBadge = document.getElementById('menu-notification-badge');
                if (menuBadge) {
                    if (totalUnread > 0) {
                        menuBadge.textContent = totalUnread;
                        menuBadge.style.display = 'inline-block';
                    } else {
                        menuBadge.style.display = 'none';
                    }
                }

                // console.log('Notifications mises à jour avec succès.');
            })
            .catch(error => {
                console.error('Erreur lors du chargement des notifications :', error);
            })
            .finally(() => {
                isLoadingNotifications = false;
            });
    }
    
    // Fonction pour mettre à jour le badge de notification d'une conversation
    function updateNotificationBadge(element, unreadCount) {
        let badge = element.querySelector('.notification-badge');
        if (!badge) {
            badge = document.createElement('span');
            badge.className = 'notification-badge badge bg-danger ms-2';
            element.appendChild(badge);
        }
        badge.textContent = unreadCount;
    
        if (unreadCount === 0) {
            badge.style.display = 'none';
        } else {
            badge.style.display = 'inline-block';
        }
    }
    
    function removeNotificationBadge(element) {
        const badge = element.querySelector('.notification-badge');
        if (badge) {
            badge.style.display = 'none';
        }
    }
    
    
    
    
    function markAsRead(receiverId) {
        fetch(`/chat/private/${receiverId}/mark-read`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // console.log('Messages marqués comme lus.');
                    const li = conversationsList.querySelector(`[data-user-id="${receiverId}"]`);
                    if (li) {
                        removeNotificationBadge(li);
                    }
                    loadNotifications();
                }
            })
            .catch(error => console.error('Erreur lors de la mise à jour des messages :', error));
    }
    
    

    function playNotificationSound() {
        if (!soundEnabled) return;
        const audio = new Audio('/public/sounds/notification.mp3');
        audio.play().catch(error => console.error('Erreur lors de la lecture du son :', error));
    }
    closePrivateChatButton.addEventListener('click', function () {
        if (currentReceiverId !== null) {
            markAsRead(currentReceiverId);
        }
        recentlyClosedReceiverId = currentReceiverId;
        currentReceiverId = null;
        document.getElementById('private-chat').style.display = 'none';
    
        // console.log(`Conversation avec ${recentlyClosedReceiverId} fermée.`);
    
        setTimeout(() => {
            // console.log(`Réinitialisation de recentlyClosedReceiverId pour ${recentlyClosedReceiverId}`);
            recentlyClosedReceiverId = null;
        }, 5000);
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

    //COOKIE
        const cookieBanner = document.getElementById('cookie-banner'); 
        const acceptCookiesBtn = document.getElementById('accept-cookies');
        const rejectCookiesBtn = document.getElementById('reject-cookies');

        if (localStorage.getItem('cookiesAccepted') !== null) {
            cookieBanner.style.display = 'none';
            soundEnabled = true;
        }
    
        acceptCookiesBtn.addEventListener('click', () => {
            // console.log('Accepter les cookies : clic détecté');
            localStorage.setItem('cookiesAccepted', 'true');
            cookieBanner.style.display = 'none';
            soundEnabled = true;
        });
    
        rejectCookiesBtn.addEventListener('click', () => {
            // console.log('Refuser les cookies : clic détecté');
            localStorage.setItem('cookiesAccepted', 'false');
            cookieBanner.style.display = 'none';
            soundEnabled = true;
        });

    
    
    
    chatForm.addEventListener('submit', event => sendMessage(event, false));
    privateChatForm.addEventListener('submit', event => sendMessage(event, true));

    setInterval(() => {
        loadGlobalMessages();
        loadPrivateMessages();
    }, 5000);   

    loadGlobalMessages();
    loadConversations();

    setInterval(loadNotifications, 5000);
    loadNotifications();
    // console.log('Cookies actuels :', document.cookie);

});
