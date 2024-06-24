document.addEventListener('DOMContentLoaded', function () {
    // const currentPath = window.location.pathname;
    // const isDashboardProfile = currentPath.includes('profile.html');

    var username = sessionStorage.getItem('USER_NAME');
    var email = sessionStorage.getItem('USER_EMAIL');
    var type = sessionStorage.getItem('USER_TYPE');

    var username1 = document.getElementById('username');
    var USER_NAME = document.getElementById('USER_NAME');
    var USER_EMAIL = document.getElementById('USER_EMAIL');
    var USER_TYPE = document.getElementById('USER_TYPE');

    // if (username && email && isDashboardProfile) {
    //     username1.textContent = username;
    //     profile_edit_username.value = username;
    //     profile_edit_email.value = email;
    // } else {
    //     username1.textContent = username;
    // }
    if (username && email) {
        username1.textContent = username;
        USER_NAME.value = username;
        USER_EMAIL.value = email;
        USER_TYPE.value = type;
    }
});