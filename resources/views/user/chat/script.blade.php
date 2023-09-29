
<script>
    const chatMessages = document.querySelector('.chat-messages');
    const chatInput = document.querySelector('.chat-input');
    const sendButton = document.querySelector('.send-button');

    // Send message when Send button is clicked
    sendButton.addEventListener('click', (e) => {
        e.preventDefault();
        sendMessage();
    });

    // Send message when Enter key is pressed
    chatInput.addEventListener('keydown', (event) => {
      if (event.keyCode === 13) {
        event.preventDefault();
        sendMessage();
      }
    });

    function sendMessage() {
      const message = chatInput.value;
      if (!message) {
        return;
      }

      // Add user message to chat messages area
      const userMessage = document.createElement('div');
      userMessage.classList.add('user-message');

      const innerWidth = document.createElement('div');
      innerWidth.classList.add('inner-width', 'bg-white', 'p-2');
      userMessage.appendChild(innerWidth);

      const chatUserInitials = document.createElement('div');
      chatUserInitials.classList.add('chat-user-initials', 'bg-secondary', 'text-white', 'd-flex', 'align-items-center', 'justify-content-center');
      innerWidth.appendChild(chatUserInitials);

      const span = document.createElement('span');
      span.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12 12q-1.65 0-2.825-1.175T8 8q0-1.65 1.175-2.825T12 4q1.65 0 2.825 1.175T16 8q0 1.65-1.175 2.825T12 12Zm-8 8v-2.8q0-.85.438-1.563T5.6 14.55q1.55-.775 3.15-1.163T12 13q1.65 0 3.25.388t3.15 1.162q.725.375 1.163 1.088T20 17.2V20H4Z"/></svg>';
      chatUserInitials.appendChild(span);

      const messageText = document.createElement('div');
      messageText.innerText = message;
      innerWidth.appendChild(messageText);
      chatMessages.appendChild(userMessage);

      //Bot Message loading
      const botMessage = document.createElement('div');
      botMessage.classList.add('bot-message');

      const innerWidth1 = document.createElement('div');
      innerWidth1.classList.add('inner-width', 'bg-grey-light', 'p-2', 'rounded');
      botMessage.appendChild(innerWidth1);

      const chatUserInitials1 = document.createElement('div');
      chatUserInitials1.classList.add('chat-user-initials', 'd-flex', 'bg-white', 'align-items-center', 'justify-content-center');
      innerWidth1.appendChild(chatUserInitials1);

      const span1 = document.createElement('span');
      span1.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M13 8.58c.78 0 1.44.61 1.44 1.42s-.66 1.44-1.44 1.44s-1.42-.66-1.42-1.44s.61-1.42 1.42-1.42M13 3c3.88 0 7 3.14 7 7c0 2.8-1.63 5.19-4 6.31V21H9v-3H8c-1.11 0-2-.89-2-2v-3H4.5c-.42 0-.66-.5-.42-.81L6 9.66A7.003 7.003 0 0 1 13 3m3 7c0-.16 0-.25-.06-.39l.89-.66c.05-.04.09-.18.05-.28l-.8-1.36c-.05-.09-.19-.14-.28-.09l-.99.42c-.18-.19-.42-.33-.65-.42L14 6.19c-.03-.14-.08-.19-.22-.19h-1.59c-.1 0-.19.05-.19.19l-.14 1.03c-.23.09-.47.23-.66.42l-1.03-.42c-.09-.05-.17 0-.23.09l-.8 1.36c-.05.14-.05.24.05.28l.84.66c0 .14-.03.28-.03.39c0 .13.03.27.03.41l-.84.65c-.1.05-.1.14-.05.24l.8 1.4c.06.1.14.1.23.1l.99-.43c.23.19.42.29.7.38l.14 1.08c0 .09.09.17.19.17h1.59c.14 0 .19-.08.22-.17l.16-1.08c.23-.09.47-.19.65-.37l.99.42c.09 0 .23 0 .28-.1l.8-1.4c.04-.1 0-.19-.05-.24l-.83-.65V10Z"/></svg>';
      chatUserInitials1.appendChild(span1);

      const aiMessage = document.createElement('div');
      aiMessage.classList.add('ai-message', 'd-flex', 'justify-content-center', 'align-items-center');

      const messageText1 = document.createElement('div');
      messageText1.classList.add('loader');
      aiMessage.appendChild(messageText1);

      const loader1 = document.createElement('div');
      loader1.classList.add('circle');
      messageText1.appendChild(loader1);

      const loader2 = document.createElement('div');
      loader2.classList.add('circle');
      messageText1.appendChild(loader2);

      const loader3 = document.createElement('div');
      loader3.classList.add('circle');
      messageText1.appendChild(loader3);

      innerWidth1.appendChild(aiMessage);
      chatMessages.appendChild(botMessage);

      //Scroll to bottom
      chatMessages.scrollTop = chatMessages.scrollHeight;

      let csrfToken = document.querySelector('[name="_token"]').value;

      // Send message to server and receive response
      fetch('chat', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ message: message })
      })
      .then(response => response.json())
      .then(data => {
        // Add bot message to chat messages area
        const aiMessages = document.querySelectorAll('.ai-message');
        const mostRecentAiMessage = aiMessages[aiMessages.length - 1];
        console.log(data.message);
        mostRecentAiMessage.innerText = data.message;

        //Scroll to bottom
        chatMessages.scrollTop = chatMessages.scrollHeight;
      })
      .catch(error => {
        console.error(error);
      });

      // Clear input field
      chatInput.value = '';
    }

    function postToUrlAndRefresh() {
        const selectElement = document.getElementById("selectPersonality");
        const selectedValue = selectElement.value;
        let csrfToken = document.querySelector('[name="_token"]').value;
        
        const postUrl = "{{ route('chat.personality') }}";
        // POST the selected value to the URL
        fetch(postUrl, {
            method: "POST",
            body: JSON.stringify({ personality: selectedValue }),
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken
            },
        })
        .then((response) => {
            if (response.ok) {
                location.reload();
            } else {
                console.log("Failed to post to URL");
            }
        })
        .catch((error) => console.error(error));
    }
</script>