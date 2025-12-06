
function toggleMenu(button) {
    const allMenus = document.querySelectorAll('.tooltip-menu');
    allMenus.forEach(menu => {
        if (menu !== button.nextElementSibling) {
            menu.style.display = 'none';
        }
    });

    const menu = button.nextElementSibling;
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

document.addEventListener('click', function (event) {
    if (!event.target.closest('.action-menu')) {
        document.querySelectorAll('.tooltip-menu').forEach(menu => {
            menu.style.display = 'none';
        });
    }
});
