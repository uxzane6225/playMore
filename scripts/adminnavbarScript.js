const navbar = document.getElementById('navbar');
const showSide = document.getElementById('showBar');

showSide.addEventListener('click', e => {
    if (navbar.classList.contains('hidden')) {
        navbar.classList.remove('hidden');
    }
    else {
        navbar.classList.add('hidden');
    }
});