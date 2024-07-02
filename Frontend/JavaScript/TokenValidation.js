document.addEventListener("DOMContentLoaded", function () {
    const token = sessionStorage.getItem('token');
    const type = sessionStorage.getItem('USER_TYPE');
    const currentPath = window.location.pathname;
    const isDashboard = currentPath.includes('UserDashboard.html');
    const isProfile = currentPath.includes('UserProfile.html');
    const isBorrowBooks = currentPath.includes('UserBorrowedBooks.html');
    const isBooks = currentPath.includes('UserBooks.html');
    const isReqBook = currentPath.includes('UserRequestBook.html');
    const isVReqBook = currentPath.includes('UserViewRequestBook.html');
    const isADashboard = currentPath.includes('AdminDashboard.html');
    const isAProfile = currentPath.includes('AdminProfile.html');
    const isAVUser = currentPath.includes('AdminViewUser.html');
    const isABorrowBooks = currentPath.includes('AdminBorrowHis.html');
    const isABooks = currentPath.includes('AdminViewBook.html');
    const isAIssueBook = currentPath.includes('AdminIssueBook.html');
    const isAVReqBook = currentPath.includes('AdminViewReqB.html');
    const shouldRedirectToDashboard = window.location.search.includes('redirect=true');

    if (token && !shouldRedirectToDashboard) {
        console.log();
        if (type == 'User') {
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
            } else if (isVReqBook) {
                window.location.href = '../HTML_code/UserViewRequestBook.html?redirect=true';
            }
        } else {
            if (isDashboard) {
                window.location.href = '../HTML_code/AdminDashboard.html?redirect=true';
            } else if (isADashboard) {
                window.location.href = '../HTML_code/AdminDashboard.html?redirect=true';
            } else if (isAProfile) {
                window.location.href = '../HTML_code/AdminProfile.html?redirect=true';
            } else if (isAVUser) {
                window.location.href = '../HTML_code/AdminViewUser.html?redirect=true';
            } else if (isABorrowBooks) {
                window.location.href = '../HTML_code/AdminBorrowHis.html?redirect=true';
            } else if (isABooks) {
                window.location.href = '../HTML_code/AdminViewBook.html?redirect=true';
            } else if (isAIssueBook) {
                window.location.href = '../HTML_code/AdminIssueBook.html?redirect=true';
            } else if (isAVReqBook) {
                window.location.href = '../HTML_code/AdminViewReqB.html?redirect=true';
            }
        }
    } else if (!token) {
        window.location.href = '../HTML_code/Login.html';
    }

    function updateUserStatus() {
        const username = sessionStorage.getItem('USER_NAME');
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../Backend/UserLoginCheckSts.php');
        xhr.setRequestHeader('Content-Type', 'application/json');
    
        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                console.log(response.message);
            } else {
                console.log('Failed to update user status.');
            }
        };
    
        xhr.onerror = function () {
            console.error('Request failed.');
        };
    
        xhr.send(JSON.stringify({ username: username }));
    }
    

    if (token && type == 'User') {
        if (isDashboard || isProfile || isBorrowBooks || isBooks || isReqBook || isVReqBook) {
            updateUserStatus();
        }
    } else if (!token) {
        window.location.href = '../HTML_code/Login.html';
    }

});
