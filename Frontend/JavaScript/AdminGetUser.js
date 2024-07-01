$(document).ready(function () {
    var currentPage = 0;
    var rowsPerPage = 8;
    var totalRows = 0;
    var totalPages = 0;
    var searchTerm = '';

    function fetchDataForPage(pageNumber) {
        $.ajax({
            url: "../../Backend/AdminGetUser.php",
            type: "GET",
            dataType: "json",
            data: {
                page: pageNumber,
                search: searchTerm
            },
            success: function (data) {
                totalRows = data.length;
                totalPages = Math.ceil(totalRows / rowsPerPage);

                $('#userRecords').empty();

                if (totalRows === 0) {
                    $('#userRecords').append('<tr><td colspan="8">No records found</td></tr>');
                    currentPage = 0;
                    updatePageNumber();
                    return;
                }

                var startIndex = pageNumber * rowsPerPage;
                var endIndex = Math.min(startIndex + rowsPerPage, totalRows);

                for (var i = startIndex; i < endIndex; i++) {
                    var record = data[i];
                    var userStatus = record.USER_STATUS === 0 ? 'Active' : 'Suspended';
                    var row = '<tr>' +
                        '<td>' + record.USER_RNAME + '</td>' +
                        '<td>' + record.USER_NAME + '</td>' +
                        '<td>' + record.USER_EMAIL + '</td>' +
                        '<td>' + record.USER_PHONE + '</td>' +
                        '<td>' + record.USER_PHONE + '</td>' +
                        '<td>' + record.USER_PHONE + '</td>' +
                        '<td>' + record.USER_PHONE + '</td>' +
                        '<td>' + userStatus + '</td>' +
                        '</tr>';
                    $('#userRecords').append(row);
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

    $('#search-form').submit(function (e) {
        e.preventDefault();
        searchTerm = $('#search-input').val().trim();
        currentPage = 0;
        fetchDataForPage(currentPage);
    });
});