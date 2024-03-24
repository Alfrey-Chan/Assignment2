const spendInput = document.getElementById('spend');
const depositInput = document.getElementById('deposit');

spendInput.addEventListener('input', function () {
    if (this.value.length > 0) {
        depositInput.readOnly = true;
        depositInput.value = 0;
    } else {
        depositInput.readOnly = false;
        depositInput.value = '';
    }
});

depositInput.addEventListener('input', function () {
    if (this.value.length > 0) {
        spendInput.readOnly = true;
        spendInput.value = 0;
    } else {
        spendInput.readOnly = false;
        spendInput.value = '';
    }
});
