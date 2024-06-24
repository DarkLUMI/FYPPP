document.addEventListener("DOMContentLoaded", function () {
    const token = sessionStorage.getItem('token');
    const currentPath = window.location.pathname;
    const isDashboard = currentPath.includes('UserDashboard.html');
    const isProfile = currentPath.includes('UserProfile.html');
    const isBorrowBooks = currentPath.includes('UserBorrowedBooks.html');
    const isBooks = currentPath.includes('UserBooks.html');
    const isReqBook = currentPath.includes('UserRequestBook.html');
    const shouldRedirectToDashboard = window.location.search.includes('redirect=true');

    if (token && !shouldRedirectToDashboard) {
        if (isDashboard) {
            window.location.href = '../HTML_code/UserDashboard.html?redirect=true';
        } else if (isProfile) {
            window.location.href = '../HTML_code/UserProfile.html?redirect=true';
        } else if (isBorrowBooks) {
            window.location.href = '../HTML_code/UserBorrowedBooks.html?redirect=true';
        } else if (isBooks) {
            window.location.href = '../HTML_code/UserBooks.html?redirect=true';
        } else if (isReqBook) {
            window.location.href = '../HTML_code/UserRequestBook.html?redirect=true';
        }
    } else if (!token) {
        window.location.href = '../HTML_code/Login.html';
    }
});
