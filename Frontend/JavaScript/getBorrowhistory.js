$(document).ready(function () {
    var currentPage = 0;
    var rowsPerPage = 8;
    var totalRows = 0;
    var totalPages = 0;

    function fetchDataForPage(pageNumber) {
        $.ajax({
            url: "../../Backend/getBorrowHistory.php",
            type: "GET",
            dataType: "json",
            success: function (data) {
                totalRows = data.length;
                totalPages = Math.ceil(totalRows / rowsPerPage);

                $('#bookRecords').empty();

                var startIndex = pageNumber * rowsPerPage;
                var endIndex = Math.min(startIndex + rowsPerPage, totalRows);

                for (var i = startIndex; i < endIndex; i++) {
                    var record = data[i];
                    var returnDate = record.RETURN_DATE ? record.RETURN_DATE : '-';
                    var row = '<tr>' +
                        '<td>' + record.BOOK_SERIAL + '</td>' +
                        '<td>' + record.TITLE + '</td>' +
                        '<td>' + record.BORROW_DATE + '</td>' +
                        '<td>' + record.EXP_DATE + '</td>' +
                        '<td>' + returnDate + '</td>' +
                        '<td>' + record.USER_NAME + '</td>' +
                        '<td><button class="btn btn-primary return-book" data-book-id="' + record.BOOK_SERIAL + '">Return</button></td>' +
                        '</tr>';
                    $('#bookRecords').append(row);
                }

                updatePageNumber();
            },
            error: function (xhr, status, error) {
                console.error('Error fetching data:', error);
                alert('Error fetching data. Please try again later.');
            }
        });
    }

    function updatePageNumber() {
        $('#page-number').text(currentPage + 1);
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