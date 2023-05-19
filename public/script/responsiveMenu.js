/* Windows on scroll */
var header = document.querySelector('header');
window.addEventListener('scroll', function () {
    header.classList.toggle('sticky', window.scrollY > 0);
});

/* Toggle Menu */
function toggleMenu() {
    var menuToggle = document.querySelector('.toggle');
    var menu = document.querySelector('.menu');
    menu.classList.toggle('active');
    header.classList.toggle('active');
}

/* Button */
const btnHeader = document.querySelector('.btnHeader');
const allLink = document.querySelectorAll('.allLinks');

btnHeader.addEventListener('click', () => {
    btnHeader.classList.toggle('active');
});

/* Remove class active */
allLink.forEach(link => {
    link.addEventListener("click", () => {
        btnHeader.classList.remove('active');
    });
});

/* dark mode */

let toggleBtn = document.getElementById('dark-mode');
let body = document.body;
let statusDarkMode = localStorage.getItem('dark-mode');
let ball = document.querySelector('.dark-mode-box .ball');

const enableDarkMode = () => {
    body.classList.add('dark');
    localStorage.setItem('dark-mode', 'enabled');
    ball.style.transform = "translateX(24px)";
}

const disableDarkMode = () => {
    body.classList.remove('dark');
    localStorage.setItem('dark-mode', 'disabled');
    ball.style.transform = "translateX(0)";
}

if (statusDarkMode === 'enabled') {
    enableDarkMode();
} else {
    disableDarkMode();
}

toggleBtn.addEventListener('change', () => {
    statusDarkMode = localStorage.getItem('dark-mode');
    document.body.classList.toggle('dark');
    if (statusDarkMode === 'disabled') {
        enableDarkMode();
    } else {
        disableDarkMode();
    }
});