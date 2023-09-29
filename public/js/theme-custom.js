(function() {
  "use strict";
    // INITIALIZATION OF BOOTSTRAP VALIDATION
    // =======================================================
    HSBsValidation.init('.js-validate', {
        async onSubmit(data) {
          data.event.preventDefault();
      
          const formData = new FormData(data.form);
          const submitBtn = data.form.querySelector('button[type="submit"]');
          const initialBtnContent = submitBtn.innerHTML;
          submitBtn.disabled = true;
          submitBtn.innerHTML = '<span class="spinner-border" role="status" aria-hidden="true"></span>';
      
          try {
            const { success, error, redirect, message } = await (await fetch(data.form.action, {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify(Object.fromEntries(formData))
            })).json();
      
            if (!success) {
              Object.entries(error).forEach(([key, value]) => {
                const input = document.querySelector(`input[name="${key}"]`);
                input.classList.add('is-invalid');
                input.nextElementSibling.innerHTML = value;
              });
              submitBtn.innerHTML = initialBtnContent;
              submitBtn.disabled = false;
            } else {
              if(redirect){
                window.location.replace(redirect);
              } else {
                showNotification(message);
                submitBtn.innerHTML = submitBtn.getAttribute('data-message');
                submitBtn.disabled = false;
              }
            }
          } catch (error) {
            console.error(error);
          }
        }
    });     

    // INITIALIZATION OF TOGGLE PASSWORD
    // =======================================================
    new HSTogglePassword('.js-toggle-password')

    function showNotification(message) {
      const notification = document.createElement('div');
      const progress = document.createElement('div');
      progress.classList.add('progress');
      notification.classList.add('notification');
      notification.textContent = message;
      document.body.appendChild(notification);
      notification.appendChild(progress);
  
      let startTime = new Date();
      let interval = setInterval(() => {
          let currentTime = new Date();
          let elapsedTime = (currentTime - startTime) / 1000;
          let width = (elapsedTime / 5) * notification.offsetWidth;
          progress.style.width = width + 'px';
          if (width >= notification.offsetWidth - 2) {
              clearInterval(interval);
              notification.style.display = 'none';
          }
      }, 40);
  
      notification.addEventListener('click', () => {
          clearInterval(interval);
          notification.style.display = 'none';
      });
    }

    const resendBtn = document.querySelector('#resend-email-btn');

    resendBtn.addEventListener('click', function() {
        // Disable button and set loading state
        resendBtn.disabled = true;
        resendBtn.innerHTML = resendBtn.dataset.loading;

        // Make GET request to data-url
        const xhr = new XMLHttpRequest();
        xhr.open('GET', resendBtn.dataset.url, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              resendBtn.disabled = false;
              resendBtn.innerHTML = resendBtn.dataset.loaded;
            }
        };
        xhr.send();
    });
})()