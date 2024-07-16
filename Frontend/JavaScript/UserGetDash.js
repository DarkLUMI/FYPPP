document.addEventListener('DOMContentLoaded', function () {
    fetchDashboardData();
});

function fetchDashboardData() {
    var userName = sessionStorage.getItem('USER_NAME');
    var userEmail = sessionStorage.getItem('USER_EMAIL');

    var url = '../../Backend/UserGetDash.php';
    url += '?userName=' + encodeURIComponent(userName);
    url += '&userEmail=' + encodeURIComponent(userEmail);

    const xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            const nextReturn = document.getElementById('next_return');
            const borrowed_book = document.getElementById('borrowed_book');
            const user_status = document.getElementById('user_status');
            const requested_book = document.getElementById('requested_book');

            data.forEach(row => {
                switch (row.TABLE_NAME) {
                    case 'next_return':
                        count = (row.COUNT === null || row.COUNT === 0) ? '-' : row.COUNT;
                        nextReturn.textContent = count;
                        break;
                    case 'borrowed_book':
                        count = (row.COUNT === null || row.COUNT === 0) ? '-' : row.COUNT;
                        borrowed_book.textContent = count;
                        break;
                    case 'user_status':
                        user_status.textContent = (row.COUNT === '0') ? 'Active' : 'Suspended';
                        break;
                    case 'requested_book':
                        count = (row.COUNT === null || row.COUNT === 0) ? '-' : row.COUNT;
                        requested_book.textContent = count;
                        break;
                }
            });

        } else {
            console.error('Error fetching data:', xhr.statusText);
        }
    };

    xhr.onerror = function () {
        console.error('Request error');
    };

    xhr.send();
}
