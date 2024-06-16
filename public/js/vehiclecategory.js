document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('vehicleCategoryForm');
    const submitBtn = document.getElementById('submitBtn');

    function checkFormValidity() {
        submitBtn.disabled = !form.checkValidity();
    }

    checkFormValidity();

    Array.from(form.elements).forEach(element => {
        if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA' || element.tagName === 'SELECT') {
            element.addEventListener('input', checkFormValidity);
        }
    });

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                $(form).closest('.modal').modal('hide');
                createNotification('success', 'Success', data.message);
                // location.reload(); // Optionally reload the table or page
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: form.method,
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    $(form).closest('.modal').modal('hide');
                    createNotification('success', 'Success', data.message);
                    // Optionally reload the table or page
                    // location.reload(); 
                } else if (data.error) {
                    createNotification('error', 'Error', data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                createNotification('error', 'Error', 'An error occurred. Please try again.');
            });
        });
    });
});

$(document).ready(function() {
    $('#selBsCategory').select2({
        placeholder: "Select multiple towns...",
        allowClear: true,
        width: '100%'
    });
});

$(document).ready(function() {
    console.log('Initializing Select2');
    $('#selBsCategory').select2({
        placeholder: "Select multiple towns...",
        allowClear: true,
        width: '100%'
    }).on('select2:open', function () {
        console.log('Select2 opened');
    }).on('select2:select', function (e) {
        console.log('Selected: ', e.params.data);
    });
});

function createNotification(type, title, text) {
    toastr[type](text, title, {
        timeOut: 5000,
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right'
    });
}

