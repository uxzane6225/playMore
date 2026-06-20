const password = document.getElementById('password');
const show = document.getElementById('show');

show.addEventListener('click', e => {
    if (password.type == "password") {
        password.type = "text";
        show.textContent = "Hide";
    }
    else {
        password.type = "password";
        show.textContent = "Show";
    }
});