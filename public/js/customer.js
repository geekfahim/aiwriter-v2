"use strict";

(function() {
    const body = document.querySelector('body');
    const subscriptionMetaTag = document.querySelector('meta[name="subscription"]');
    if (subscriptionMetaTag !== null){
        const subscriptionValue = subscriptionMetaTag.getAttribute('content');

        if (subscriptionValue == false) {
            const subscriptionModal1 = document.getElementById('paymentModal');

            if(subscriptionModal1){
                var subscriptionModal2 = new bootstrap.Modal(document.getElementById('paymentModal'), {
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
    // sort.js
$(document).ready(function() {
    $("#sortSelect").on("change", function() {
      var selectedValue = $(this).val();
      var gridItemsContainer = $("#gridItemsContainer");
      var gridItems = gridItemsContainer.children(".grid-item");
  
      if (selectedValue === "1") {
        // A-Z Sort
        gridItems.sort(function(a, b) {
          var aText = $(a).find("h6").text().toUpperCase();
          var bText = $(b).find("h6").text().toUpperCase();
          return aText.localeCompare(bText);
        });
      } else if (selectedValue === "2") {
        // Z-A Sort
        gridItems.sort(function(a, b) {
          var aText = $(a).find("h6").text().toUpperCase();
          var bText = $(b).find("h6").text().toUpperCase();
          return bText.localeCompare(aText);
        });
      }
  
      gridItems.detach().appendTo(gridItemsContainer);
    });
  });
  
    if(typeof templateSearch !== 'undefined'){
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

    document.querySelectorAll('.js-create-project').forEach(element => {
        element.addEventListener('submit', async function(event) {
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
                    window.location.href = result.redirectUrl;
                } else {
                    const errors = result.errors;
                    Object.keys(errors).forEach(field => {
                        const input = form.elements[field];
                        input.classList.add('is-invalid');

                        const errorMessage = errors[field][0];
                        const errorElement = document.createElement('div');
                        errorElement.classList.add('invalid-feedback', 'font-xs');
                        errorElement.innerText = errorMessage;
                        input.after(errorElement);
                    });
                }
            });
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
            
            setTimeout(() => {
                document.querySelector('.loading-message').innerHTML = '';
                document.querySelector('.spinner').style.display = 'none';
                window.location.href = url;
            }, 500);
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
        toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | export',
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
                            errorElement.classList.add('invalid-feedback', 'font-xs');
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

    const chatPrompt = document.querySelector('.js-chat-btn');

    if(chatPrompt){
        chatPrompt.addEventListener('submit', function (event) {
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
                    
                } else {
                    
                }
            });
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

    const deleteButtons = document.querySelectorAll('.delete-project');

    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            const url = button.getAttribute('data-url');
            
            fetch(url, {
            method: 'GET'
            })
            .then(response => {
            if (response.ok) {
                location.reload();
            }
            })
            .catch(error => {
                console.error(error);
            });
        });
    });

    const submitAudioForm = document.querySelector('.js-audio-form');

    if(submitAudioForm){
        submitAudioForm.addEventListener('submit', function (event) {
            event.preventDefault();

            var generateButton = document.querySelector('.js-generate-audio-text');

            generateButton.disabled = true;
            generateButton.innerHTML = "Generating Text...";

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
                    window.location.reload();
                } else {
                    const errors = result.errors;
                    Object.keys(errors).forEach(field => {
                        const input = form.elements[field];
                        input.classList.add('is-invalid');

                        const errorMessage = errors[field][0];
                        const errorElement = document.createElement('div');
                        errorElement.classList.add('invalid-feedback', 'font-xs');
                        errorElement.classList.add('font-xs');
                        errorElement.innerText = errorMessage;
                        input.after(errorElement);
                    });
                }
                setTimeout(function() {
                    generateButton.disabled = false;
                    generateButton.innerHTML = "Generate Text";
                }, 1500);
            });
        });

        document.querySelector('.js-audio-form').addEventListener('click', function (event) {
            const invalidFeedbackElements = document.querySelectorAll('.invalid-feedback');
            invalidFeedbackElements.forEach(element => element.remove());

            const invalidInputElements = document.querySelectorAll('.is-invalid');
            invalidInputElements.forEach(element => element.classList.remove('is-invalid'));
        });
    }

    const submitImageForm = document.querySelector('.js-image-form');

    if(submitImageForm){
        submitImageForm.addEventListener('submit', function (event) {
            event.preventDefault();

            var generateButton = document.querySelector('.js-generate-image');
            var contentLoaderIcon = document.querySelector(".loading-content");
            var imageContainer = document.querySelector(".js-image-container");
            var generatedImage = document.querySelector(".js-generated-image");

            generateButton.disabled = true;
            generateButton.innerHTML = "Generating Image...";
            contentLoaderIcon.classList.remove("d-none");
            imageContainer.classList.add("d-none");

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
                    setTimeout(function() {
                        showNotification(result.message);
                        document.querySelector(".js-image-view").innerHTML = result.view;
                    }, 1500);
                } else {
                    const errors = result.errors;
                    Object.keys(errors).forEach(field => {
                        const input = form.elements[field];
                        input.classList.add('is-invalid');

                        const errorMessage = errors[field][0];
                        const errorElement = document.createElement('div');
                        errorElement.classList.add('invalid-feedback', 'font-xs');
                        errorElement.classList.add('font-xs');
                        errorElement.innerText = errorMessage;
                        input.after(errorElement);
                    });
                }
                setTimeout(function() {
                    generateButton.disabled = false;
                    generateButton.innerHTML = "Generate Image";
                    contentLoaderIcon.classList.add("d-none");
                }, 1500);
            });
        });

        document.querySelector('.js-image-form').addEventListener('click', function (event) {
            const invalidFeedbackElements = document.querySelectorAll('.invalid-feedback');
            invalidFeedbackElements.forEach(element => element.remove());

            const invalidInputElements = document.querySelectorAll('.is-invalid');
            invalidInputElements.forEach(element => element.classList.remove('is-invalid'));
        });
    }

    const categoryButtons = document.querySelectorAll('.js-template-category');

    categoryButtons.forEach(button => {
        button.addEventListener('click', () => {
            const url = button.getAttribute('data-url');
            const searchUrl = button.getAttribute('data-search');
            
            fetch(url)
            .then(response => response.text())
            .then(html => {
                document.querySelector(".grid-items").innerHTML = html;
                document.querySelector('.template-search').dataset.url = searchUrl;
                const categoryButtonClasses = document.querySelectorAll('.js-template-category');
                categoryButtonClasses.forEach(categoryButtonClass => {
                    categoryButtonClass.classList.remove('btn-dark', 'btn-pointer');
                });

                button.classList.add('btn-dark', 'btn-pointer');
            })
            .catch(error => console.error(error));
        });
    });

    document.addEventListener("click", function(event) {
        if (event.target.classList.contains('js-pay-plan') || event.target.classList.contains('js-remove-coupon')) {
            const viewModal = document.querySelector('.viewModal');

            let myModalEl = document.getElementById('paymentModal');

            if(myModalEl){
                let modal = bootstrap.Modal.getInstance(myModalEl)
                modal.hide();
            }

            var payButton = event.target;
            const url = payButton.getAttribute('data-url');
            
            fetch(url)
            .then(response => response.text())
            .then(data => {
                // append the resultant view to the ViewModal div
                viewModal.innerHTML = data;
                const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'), {});
                paymentModal.show();
            })
            .catch(error => console.error(error));
        }
        
        if (event.target.classList.contains('js-add-coupon')) {
            var couponButton = document.querySelector(".js-add-coupon");
            const viewModal = document.querySelector('.viewModal');
            
            let myModalEl = document.getElementById('paymentModal')
            let modal = bootstrap.Modal.getInstance(myModalEl)
            modal.hide();

            viewModal.innerHTML = "";
            const url = couponButton.getAttribute('data-url');
            
            fetch(url)
            .then(response => response.text())
            .then(data => {
                // append the resultant view to the ViewModal div
                viewModal.innerHTML = data;
                const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'), {});
                paymentModal.show();
            })
            .catch(error => console.error(error));
        }

        if (event.target.classList.contains('js-submit-coupon-form')) {
            document.querySelectorAll(".invalid-feedback").forEach(el => el.remove());
            const form = document.querySelector(".js-coupon-form");
            const url = form.action;
            const method = form.method;
            const data = new FormData(form);

            fetch(url, {
                method: method,
                body: data
            })
            .then(response => response.json())
            .then(result => {
                if (!result.success) {
                    const errors = result.errors;
                    Object.keys(errors).forEach(field => {
                        const input = form.elements[field];
                        input.classList.add('is-invalid');

                        const errorMessage = errors[field][0];
                        const errorElement = document.createElement('div');
                        errorElement.classList.add('fs-6');
                        errorElement.classList.add('invalid-feedback', 'font-xs');
                        errorElement.innerText = errorMessage;
                        input.after(errorElement);
                    });
                } else {
                    const viewModal = document.querySelector('.viewModal');
                    let myModalEl = document.getElementById('paymentModal');

                    if(myModalEl){
                        let modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
                    }
                    viewModal.innerHTML = result.view;
                    const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'), {});
                    paymentModal.show();
                }
            });
        }

        if (event.target.classList.contains('js-checkout-form-submit-btn')) {
            const button = document.querySelector(".js-checkout-form-submit-btn");
            button.classList.remove('btn-pointer');
            button.classList.add('btn-icon');
            button.classList.add('disabled');
            button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        }   
        
        if (event.target.classList.contains('js-show-image')) {
            const button = event.target;
            const url = button.getAttribute('data-url');

            fetch(url)
            .then(response => response.json())
            .then(data => {
                document.querySelector(".js-image-view").innerHTML = data.view;
            })
            .catch(error => console.error(error));
        } 

        if (event.target.classList.contains('js-delete-image')) {
            const button = event.target;
            const url = button.getAttribute('data-url');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(url, {
                method: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
            })
            .then(response => response.json())
            .then(data => {
                document.querySelector(".js-image-view").innerHTML = data.view;
            })
            .catch(error => console.error(error));
        } 

        if (event.target.classList.contains('js-dismiss-create-template')) {
            closeModal('js-create-template-modal');
            var modal = new bootstrap.Modal(document.getElementById(('templateModal'), {
                keyboard: false
            }))
            modal.toggle();
        }
    });

    document.addEventListener("submit", function(event) {
        if(event.target.matches('.js-create-content-form')) {
            event.preventDefault();
    
            const form = event.target;
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
                    window.location.href = result.redirectUrl;
                } else {
                    const errors = result.errors;
                    Object.keys(errors).forEach(field => {
                        const input = form.elements[field];
                        input.classList.add('is-invalid');
    
                        const errorMessage = errors[field][0];
                        const errorElement = document.createElement('div');
                        errorElement.classList.add('invalid-feedback', 'font-xs');
                        errorElement.innerText = errorMessage;
                        input.after(errorElement);
                    });
                }
            });
        }
    });

    document.addEventListener('keyup', function(event) {
        if (event.target.matches('.search-box')) {
            var el = event.target;
            var query = el.value;
            var url = el.dataset.url;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById('table-render').innerHTML = this.responseText;
                }
            };
            xhttp.open('POST', url, true);
            xhttp.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhttp.send('query=' + query);
        }
    });

    const gridItem = document.querySelector('.grid-items'); // replace with appropriate selector

    if(gridItem){
        gridItem.addEventListener('click', function(event) {
            if (event.target.matches('.js-select-template, .js-select-template *')) {
                const templateElement = event.target.closest('.js-select-template');
                const url = templateElement.getAttribute('data-url');
                fetch(url, {
                    method: 'GET',
                })
                .then(response => response.text())
                .then(result => {
                    closeModal('templateModal');
                    openModal('js-create-template-modal', result);
                });
            }
        });
    }

    function closeModal(modalId) {
        let modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
        if (modal) {
            modal.hide();
        }
    }
    
    function openModal(modalId, content) {
        let modalContainer = document.querySelector('.js-modal-container');
        if (modalContainer) {
            modalContainer.innerHTML = content;

            if (document.getElementById(modalId)) {
                var modal = new bootstrap.Modal(document.getElementById((modalId), {
                    keyboard: false
                }))
                modal.toggle();
            }
        }
    }
})();



