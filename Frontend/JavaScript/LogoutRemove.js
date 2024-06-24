function logout() {
    sessionStorage.removeItem('token');
    sessionStorage.removeItem('USER_EMAIL');
    sessionStorage.removeItem('USER_NAME');
    sessionStorage.removeItem('USER_TYPE');

    window.location.href = '../HTML_code/index.html';
}