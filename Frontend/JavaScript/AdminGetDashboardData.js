document.addEventListener('DOMContentLoaded', function () {
    fetchDashboardData();
});

function fetchDashboardData() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../../Backend/getDashboardData.php', true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);

            const totalUsers = document.querySelector('#totalUsers');
            const pendingBorrowedBooks = document.querySelector('#pendingBorrowedBooks');
            const totalLibraryBooks = document.querySelector('#totalLibraryBooks');
            const totalRequestedBooks = document.querySelector('#totalRequestedBooks');

            data.forEach(row => {
                const count = (row.COUNT === null || row.COUNT === 0) ? '-' : row.COUNT;
                switch (row.TABLE_NAME) {
                    case 'total_users':
                        totalUsers.textContent = count;
                        break;
                    case 'pending_borrowed_books':
                        pendingBorrowedBooks.textContent = count;
                        break;
                    case 'total_library_books':
                        totalLibraryBooks.textContent = count;
                        break;
                    case 'total_requested_books':
                        totalRequestedBooks.textContent = count;
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