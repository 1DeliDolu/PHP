//  write menu into DOM
const callbackLoadMenu = (response) => {
    $('#main-nav').html(response.data);
    changeTheme(systemTheme);
};

//  load a new modal - append at the body
const callbackLoadModal = (response) => {
    $('body').append(response.data);
};
// write into main
const callbackLoadMain = (response) => {
    $('#content > div').html(response.data);
};
// write alert into alerts
const callbackLoadAlert = (response) => {
    $('#alerts').append(response.data);
};
