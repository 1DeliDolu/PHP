// DO NOT CHANGE the follow lines!
const PRIMARY   = 0b00001;
const SUCCESS   = 0b00010;
const INFO      = 0b00100;
const WARNING   = 0b01000;
const DANGER    = 0b10000;
const E_ALL     = 0b11111;

// settings for report errors; e. g. E_ALL & ~PRIMARY (like php.ini)
const ERROR_REPORTING = E_ALL;

let currentTheme = 'dark';
// read system theme
let systemTheme = (window.matchMedia("(prefers-color-scheme: dark)").matches ? 'dark' : 'light') ?? 'dark';
// in jQuery steht $ für document.querySelectorAll(...)
$(document).ready((event) => {
    // read current theme from page
    currentTheme = $('[data-bs-theme]').attr('data-bs-theme') ?? 'dark';
    // detect change system theme
    $(window.matchMedia('(prefers-color-scheme: dark)')).on('change', (event)=> {     
        systemTheme = event.target.matches ? 'dark' : 'light';
        changeTheme(systemTheme);
    });
    new Ajax({
        component: 'menu.show',
        values: {
            template:'default',
        }
    }, null, callbackLoadMenu);
    new Ajax({
        component: 'content.show',
        values: {
            template:'home',
        }
    }, null, callbackLoadMain);
});

function changeTheme(newTheme) {
    if(newTheme != currentTheme) {
        $('[data-bs-theme]').attr('data-bs-theme', newTheme);
        $('#change-theme').removeClass('btn-light btn-dark').addClass(newTheme == 'dark' ? 'btn-light' : 'btn-dark');
        $('#change-theme i.bi').removeClass('bi-brightness-high-fill bi-moon-stars-fill').addClass(newTheme == 'dark' ? 'bi-brightness-high-fill' : 'bi-moon-stars-fill');
        currentTheme = newTheme;
    }
}

