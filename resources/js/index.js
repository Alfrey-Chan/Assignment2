console.log('Loading index.js...');
document
    .querySelectorAll('.transaction-delete-button')
    .forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault(); // prevent form submission

            if (confirm('Are you sure you want to delete this transaction?')) {
                event.target.closest('form').submit();
            }
        });
    });
