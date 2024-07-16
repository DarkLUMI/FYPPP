$(document).ready(function () {
    var currentPage = 0;
    var rowsPerPage = 5;
    var totalRows = 0;
    var totalPages = 0;
    var searchTerm = '';

    function fetchContactUsData(pageNumber) {
        $.ajax({
            url: "../../Backend/fetchContactUsInfo.php",
            type: "GET",
            dataType: "json",
            data: {
                submit1: true,
                search: searchTerm
            },
            success: function (data) {
                if (Array.isArray(data) && data.length > 0) {
                    totalRows = data.length;
                    totalPages = Math.ceil(totalRows / rowsPerPage);

                    $('#conUSRecords').empty();

                    var startIndex = pageNumber * rowsPerPage;
                    var endIndex = Math.min(startIndex + rowsPerPage, totalRows);

                    for (var i = startIndex; i < endIndex; i++) {
                        var record = data[i];
                        var row = '<tr>' +
                            '<td>' + record.CON_NAME + '</td>' +
                            '<td>' + record.CON_EMAIL + '</td>' +
                            '<td>' + record.CON_PHONE + '</td>' +
                            '<td>' + record.CON_MSG + '</td>' +
                            '</tr>';
                        $('#conUSRecords').append(row);
                    }
                    updatePageNumber();
                } else {
                    $('#conUSRecords').html('<tr><td colspan="4">No contact information available</td></tr>');
                }
            },
            error: function (error) {
                console.log("Error fetching contact information:", error);
                $('#conUSRecords').html('<tr><td colspan="4">Error fetching contact information. Please try again later.</td></tr>');
            }
        });
    }

    function updatePageNumber() {
        $('#page-number').text(currentPage + 1);
    }

    fetchContactUsData(currentPage);

    $('#prevPage').click(function (e) {
        e.preventDefault();
        if (currentPage > 0) {
            currentPage--;
            fetchContactUsData(currentPage);
        }
    });

    $('#nextPage').click(function (e) {
        e.preventDefault();
        if (currentPage < totalPages - 1) {
            currentPage++;
            fetchContactUsData(currentPage);
        }
    });

    $('#search-form').on('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission

        searchTerm = $('#search-input').val();
        currentPage = 0;
        fetchContactUsData(currentPage); // Fetch contact information with the search term
    });
});
