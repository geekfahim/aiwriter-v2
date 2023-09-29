const body = document.querySelector('body');
const subscriptionMetaTag = document.querySelector('meta[name="subscription"]');
if (subscriptionMetaTag !== null){
    const subscriptionValue = subscriptionMetaTag.getAttribute('content');

    if (subscriptionValue == false) {
        const subscriptionModal1 = document.getElementById('subscriptionModal');

        if(subscriptionModal1){
            var subscriptionModal2 = new bootstrap.Modal(document.getElementById('subscriptionModal'), {
                keyboard: false
            });
            
            subscriptionModal2.toggle();
        }
    }
}

body.addEventListener('click', function(event) {
    if (event.target.classList.contains('copy-action')) {
        let btn = event.target;
        let contentDescription = btn.closest('.content-container').querySelector('.content-description');
        let tempInput = document.createElement('input');
        document.body.appendChild(tempInput);
        tempInput.value = contentDescription.innerHTML;
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        showNotification('Content copied to clipboard');
    }

    if (event.target.classList.contains("content-btn-action")) {
        let btn = event.target;
        let url = btn.getAttribute('data-url');
        let action = btn.getAttribute('data-action');
        fetch(url)
        .then(response => response.json())
        .then(data => {
            if (action === 'delete' && data.success) {
                let container = btn.closest('.content-container');
                container.style.transition = "opacity 400ms";
                container.style.opacity = 0;
                setTimeout(function() {
                    container.remove();
                }, 400);
                showNotification('Content deleted succesfully!');
            } else if (action === 'save' && data.success) {
                let saveCount = document.querySelector('.saved-count');
                saveCount.innerHTML = parseInt(saveCount.innerHTML) + 1;
                showNotification('Content saved!');
            }
        });
    }
});

const templateSearch = document.querySelector('.template-search');

document.addEventListener("click", function(event) {
    var container = document.querySelector(".user-menu");
    if (!container.contains(event.target)) {
        var elements = document.querySelectorAll('.user-menu');
        for (var i = 0; i < elements.length; i++) {
            elements[i].classList.add('d-none');
        }
    }
});

document.addEventListener('click', function(event) {
    let footer = event.target.closest('.user-menu-footer');
    if (!footer) return;
    event.stopPropagation();
    
    let elements = document.querySelectorAll('.user-menu');
    for (let i = 0; i < elements.length; i++) {
        elements[i].classList.toggle('d-none');
    }
});

document.querySelector("#sidebar").addEventListener("click", function(event) {
    let span = event.target.closest(".mark-favorite");
    if (!span) return;
    
    let dataUrl = span.getAttribute("data-url");
    let xhr = new XMLHttpRequest();
    xhr.open("GET", dataUrl, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            document.querySelector("#sidebar").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
});

if(templateSearch){
    document.querySelector('.template-search').addEventListener('keyup', async function(event) {
        let searchTerm = event.target.value;

        let dataUrl = event.target.dataset.url;
        let xhr = new XMLHttpRequest();
        xhr.open("GET", `${dataUrl}?q=${searchTerm}`, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                //alert('test')
                document.querySelector(".grid-items").innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    });
}

document.querySelectorAll('.create-template').forEach(element => {
    element.addEventListener('click', async function(event) {
        event.preventDefault();
        document.querySelector('.loading-message').innerHTML = 'Creating Project';
        document.querySelector('.spinner').style.display = 'block';
        const url = this.getAttribute('href');
        const response = await fetch(url);
        const data = await response.json();
        if (data.success === false) {
            document.querySelector('.spinner').style.display = 'none';
            return;
        }

        window.addEventListener('unload', () => {
            document.querySelector('.spinner').style.display = 'none';
        });

        setTimeout(() => {
            window.location.href = data.redirectUrl;
        }, 3000);
    });
});

document.querySelectorAll('.view-template').forEach(element => {
    element.addEventListener('click', async function(event) {
        event.preventDefault();
        document.querySelector('.loading-message').innerHTML = 'Loading Project';
        document.querySelector('.spinner').style.display = 'block';
        let url;
        if (this.hasAttribute('href')) {
            url = this.getAttribute('href');
        } else if (this.hasAttribute('data-url')) {
            url = this.getAttribute('data-url');
        }
        
        window.addEventListener('unload', () => {
            document.querySelector('.spinner').style.display = 'none';
        });
        
        setTimeout(() => {
            window.location.href = url;
        }, 3000);
    });
});

const projectInputs = document.querySelectorAll('.project-input');
const generateButton = document.querySelector('.generate-content');

if(projectInputs && generateButton){
    projectInputs.forEach(element => {
        element.addEventListener('input', checkInputValues);
        const form = element.closest("form");
        let showNotificationOnChange = true;

        if (element.tagName === 'SELECT') {
            element.addEventListener("change", submitForm);
        } else {
            element.addEventListener("blur", submitForm);
            element.addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                    submitForm();
                } else {
                    showNotificationOnChange = false;
                    submitForm();
                }
            });
        }

        async function submitForm() {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
              method: "POST",
              body: formData
            });
          
            if (response.ok) {
                message = 'Field changed successfully!';
                if (showNotificationOnChange) {
                    showNotification(message);
                }
            } else {
                message = 'Tone change failed!';
                if (showNotificationOnChange) {
                    showNotification(message);
                }
            }
        }
    });

    function checkInputValues() {
        let inputsHaveValues = true;
        projectInputs.forEach(input => {
            if (input.tagName === 'SELECT' && input.value === '') {
                inputsHaveValues = false;
            } else if (input.tagName === 'INPUT' && !input.value) {
                inputsHaveValues = false;
            }
        });
        generateButton.disabled = !inputsHaveValues;
    }

    checkInputValues();

    generateButton.addEventListener('click', function (event) {
        const url = this.getAttribute('data-url');
        event.target.innerHTML = "Generating Content...";
        document.querySelector(".loading-content").classList.remove("d-none");

        let xhr = new XMLHttpRequest();
        xhr.open("GET", url, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                const container = document.getElementById('generated-content');
                event.target.innerHTML = "Create Content";
                document.querySelector(".loading-content").classList.add("d-none");
                document.querySelector('.generated-content').innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    });

    const form = document.querySelectorAll('form');
    form.forEach(element => {
        element.addEventListener('submit', event => {
            event.preventDefault();
        });
    })
}

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

const editorContent = document.getElementById("editorContent");

if(editorContent){
    editorContent.addEventListener("input", function() {
        let content = this.value;
        console.log(content);
        tinymce.activeEditor.setContent(content);
    });
}


tinymce.init({
    selector: '#editorContent',
    menubar:false,
    inline_boundaries: false,
    toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | outdent indent',
    setup: function (editor) {
        let textarea = document.getElementById('editorContent');
        let url = textarea.getAttribute('data-url');
        let csrfToken = document.querySelector('[name="_token"]').value;
        editor.on('keyup', function () {
            let content = editor.getContent();
            let xhr = new XMLHttpRequest();
            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
            xhr.send(JSON.stringify({ content: content, _token: csrfToken }));
        });
    }
});

const submitForm = document.querySelector('.js-submit-form');

if(submitForm){
    submitForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const form = this;
        const url = form.action;
        const method = form.method;
        const data = new FormData(form);

        fetch(url, {
            method: method,
            body: data
        })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    showNotification(result.message);
                } else {
                    const errors = result.errors;
                    Object.keys(errors).forEach(field => {
                        const input = form.elements[field];
                        input.classList.add('is-invalid');

                        const errorMessage = errors[field][0];
                        const errorElement = document.createElement('div');
                        errorElement.classList.add('invalid-feedback');
                        errorElement.innerText = errorMessage;
                        input.after(errorElement);
                    });
                }
            });
    });

    document.querySelector('.js-submit-form').addEventListener('click', function (event) {
        const invalidFeedbackElements = document.querySelectorAll('.invalid-feedback');
        invalidFeedbackElements.forEach(element => element.remove());

        const invalidInputElements = document.querySelectorAll('.is-invalid');
        invalidInputElements.forEach(element => element.classList.remove('is-invalid'));
    });
}

const togglePlan = document.querySelectorAll('.plan-toggle');

if(togglePlan){
    togglePlan.forEach(element => {
        element.addEventListener('click', function(event) {
            const dataType = this.getAttribute('data-type');
            document.querySelectorAll('.plan-period').forEach(el => {
                el.classList.toggle('d-none');
            });
        })
    });
}



