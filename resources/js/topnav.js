const topnav = document.getElementById('topnav');

document.addEventListener('click', function(e) {
    const target = e.target;

    if (target.id === 'logout-button') {
        e.preventDefault();
        document.getElementById('frm-logout').submit();
    }



    const menus = document.getElementsByClassName('dropdown-menu');

    if (target.classList.contains('dropdown-button')) {
        for (let i = 0; i < menus.length; i++) {
            let classList = menus[i].classList;
            if (classList.contains('invisible')) {
                classList.remove('invisible');
            } else {
                classList.add('invisible');
            }
        }
    }

    else if (!target.classList.contains('dropdown-item')) {
        for (let i = 0; i < menus.length; i++) {
            let classList = menus[i].classList;
            if (!classList.contains('invisible')) {
                classList.add('invisible');
            }
        }
    }

})
