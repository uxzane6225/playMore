const password = document.getElementById('password');
const show = document.getElementById('show');

show.addEventListener('change', e => {
    if (password.type == "password") {
        password.type = "text";
    }
    else {
        password.type = "password";
    }
});