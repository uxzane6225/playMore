const navbar = document.getElementById('navbar');
const expand = document.getElementById('expand');

expand.addEventListener("click", e => {
    if (navbar.classList.contains('hidden')) {
        navbar.classList.remove('hidden');
    }
    else {
        navbar.classList.add('hidden');
    }
});