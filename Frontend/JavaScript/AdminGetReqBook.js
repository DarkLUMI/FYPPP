$(document).ready(function () {
    var currentPage = 0;
    var rowsPerPage = 8;
    var totalRows = 0;
    var totalPages = 0;
    var searchTerm = '';

    function fetchDataForPage(pageNumber) {
        $.ajax({
            url: "../../Backend/AdminGetReqBook.php",
            type: "GET",
            dataType: "json",
            data: {
                page: pageNumber,
                search: searchTerm
            },
            success: function (data) {
                totalRows = data.length;
                totalPages = Math.ceil(totalRows / rowsPerPage);

                $('#reqbookRecords').empty();

                if (totalRows === 0) {
                    $('#reqbookRecords').append('<tr><td colspan="7">No records found</td></tr>');
                    currentPage = 0;
                    updatePageNumber();
                    return;
                }

                var startIndex = pageNumber * rowsPerPage;
                var endIndex = Math.min(startIndex + rowsPerPage, totalRows);

                for (var i = startIndex; i < endIndex; i++) {
                    var record = data[i];
                    
                    var bookStatus = record.ISSUED === 0 ? '-' : 'Issued';
                    
                    var buttonDisabled = record.ISSUED === 1 ? 'disabled' : '';
                    
                    var row = '<tr>' +
                        '<td>' + record.USER_NAME + '</td>' +
                        '<td>' + record.USER_EMAIL + '</td>' +
                        '<td>' + record.REQBOOK_N + '</td>' +
                        '<td>' + record.REQBOOK_URL + '</td>' +
                        '<td>' + bookStatus + '</td>' +
                        '<td><button class="btn btn-primary issue-book" data-book-req="' + record.RECORD_ID + '" ' + buttonDisabled + '>Issue</button></td>' +
                        '</tr>';
                    
                    $('#reqbookRecords').append(row);
                }

                $('.issue-book').off('click').on('click', function () {
                    var recordId = $(this).data('book-req');
                    
                    $.ajax({
                        url: "../../Backend/issueReqBook.php",
                        type: "POST",
                        data: {
                            record_id: recordId,
                        },
                        success: function (response) {
                            console.log(response);
                            fetchDataForPage(currentPage);
                            alert('Record updated successfully!');
                        },
                        error: function (xhr, status, error) {
                            console.error('Error issue book:', error);
                            alert('Error issuing book. Please try again later.');
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