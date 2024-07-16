$(document).ready(function () {
    var currentPage = 0;
    var rowsPerPage = 8;
    var totalRows = 0;
    var totalPages = 0;

    function fetchDataForPage(pageNumber) {

        var userName = sessionStorage.getItem('USER_NAME');

        var requestData = {
            userName: userName
        };

        $.ajax({
            url: "../../Backend/UserGetBorrowHistory.php",
            type: "GET",
            dataType: "json",
            data: requestData,
            success: function (data) {
                totalRows = data.length;
                totalPages = Math.ceil(totalRows / rowsPerPage);

                $('#bookRecords').empty();

                if (totalRows === 0) {
                    $('#bookRecords').append('<tr><td colspan="7">No records found</td></tr>');
                    currentPage = 0;
                    updatePageNumber();
                    return;
                }

                var startIndex = pageNumber * rowsPerPage;
                var endIndex = Math.min(startIndex + rowsPerPage, totalRows);

                for (var i = startIndex; i < endIndex; i++) {
                    var record = data[i];
                    var returnDate = record.RETURN_DATE ? record.RETURN_DATE : '-';
                    var row = '<tr>' +
                        '<td>' + record.TITLE + '</td>' +
                        '<td>' + record.BOOK_SERIAL + '</td>' +
                        '<td>' + record.BORROW_DATE + '</td>' +
                        '<td>' + record.EXP_DATE + '</td>' +
                        '<td>' + returnDate + '</td>' +
                        '</tr>';
                    $('#bookRecords').append(row);
                }

                updatePageNumber();
            },
            error: function (xhr, status, error) {
                if (xhr.status === 401) {
                    console.error('Unauthorized: User not authenticated');
                    alert('User not authenticated. Please log in.');
                } else {
                    console.error('Error fetching data:', xhr.status, error);
                    alert('Error fetching data. Please try again later.');
                }
            }
        });
    }

    function updatePageNumber() {
        $('#page-number').text(currentPage + 1);
        $('#prevPage').prop('disabled', currentPage === 0);
        $('#nextPage').prop('disabled', currentPage >= totalPages - 1);
    }

    fetchDataForPage(currentPage);

    $('#prevPage').click(function (e) {
        e.preventDefault();
        if (currentPage > 0) {
            currentPage--;
            fetchDataForPage(currentPage);
        }
    });

    $('#nextPage').click(function (e) {
        e.preventDefault();
        if (currentPage < totalPages - 1) {
            currentPage++;
            fetchDataForPage(currentPage);
        }
    });
});
