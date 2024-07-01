$(document).ready(function () {
    var currentPage = 0;
    var rowsPerPage = 5;
    var totalRows = 0;
    var totalPages = 0;
    var searchTerm = '';

    function fetchDataForPage(pageNumber) {
        $.ajax({
            url: "../../Backend/AdminGetBooksRec.php",
            type: "GET",
            dataType: "json",
            data: {
                page: pageNumber,
                search: searchTerm
            },
            success: function (data) {
                totalRows = data.length;
                totalPages = Math.ceil(totalRows / rowsPerPage);

                $('#bookRecords').empty();

                if (totalRows === 0) {
                    $('#bookRecords').append('<tr><td colspan="10">No records found</td></tr>');
                    currentPage = 0;
                    updatePageNumber();
                    return;
                }

                var startIndex = pageNumber * rowsPerPage;
                var endIndex = Math.min(startIndex + rowsPerPage, totalRows);

                for (var i = startIndex; i < endIndex; i++) {
                    var record = data[i];
                    var bookAVAI = record.AVAILABLE === 0 ? 'NO' : 'YES';
                    var bookImage = record.BOOK_IMG ? `data:image/jpeg;base64,${record.BOOK_IMG}` : '../../Assets/Image/default_book_img.jpg';
                    var row = '<tr>' +
                        '<td>' + record.BOOK_SERIAL + '</td>' +
                        '<td><img src="' + bookImage + '" alt="Book Image" style="max-width: 100px; max-height: 100px;"></td>' +
                        '<td>' + record.TITLE + '</td>' +
                        '<td>' + record.AUTHOR + '</td>' +
                        '<td>' + record.PUB_NAME + '</td>' +
                        '<td>' + record.BOOK_BDATE + '</td>' +
                        '<td>' + record.BOOK_PRICE + '</td>' +
                        '<td>' + bookAVAI + '</td>' +
                        '<td><button class="btn btn-primary AVAI-book" data-book-id="' + record.BOOK_SERIAL + '">Switch</button></td>' +
                        '<td><button class="btn btn-primary delete-book" data-book-id="' + record.BOOK_ID + '">Delete</button></td>' +
                        '</tr>';
                    $('#bookRecords').append(row);
                }

                $('.AVAI-book').off('click').on('click', function () {
                    var $row = $(this).closest('tr');
                    var bookSerial = $row.find('td').eq(0).text();
                
                    $.ajax({
                        url: "../../Backend/switchAvailability.php",
                        type: "POST",
                        data: {
                            book_serial: bookSerial,
                        },
                        success: function (response) {
                            console.log(response);
                            fetchDataForPage(currentPage);
                            alert('Availability switched successfully!');
                        },
                        error: function (xhr, status, error) {
                            console.error('Error switching availability:', error);
                            alert('Error switching availability. Please try again later.');
                        }
                    });
                });
                
                $('.delete-book').off('click').on('click', function () {
                    var $row = $(this).closest('tr');
                    var bookSerial = $row.find('td').eq(0).text();
                
                    $.ajax({
                        url: "../../Backend/deleteBook.php",
                        type: "POST",
                        data: {
                            book_serial: bookSerial,
                        },
                        success: function (response) {
                            console.log(response);
                            fetchDataForPage(currentPage);
                            alert('Book deleted successfully!');
                        },
                        error: function (xhr, status, error) {
                            console.error('Error deleting book:', error);
                            alert('Error deleting book. Please try again later.');
                        }
                    });
                });

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

    $('#search-form').submit(function (e) {
        e.preventDefault();
        searchTerm = $('#search-input').val().trim();
        currentPage = 0;
        fetchDataForPage(currentPage);
    });
});
