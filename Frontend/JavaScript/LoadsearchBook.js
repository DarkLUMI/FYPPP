$(document).ready(function () {
    function fetchBooks(searchTerm = '') {
        $.ajax({
            url: "../../Backend/UserBooks.php",
            type: "GET",
            dataType: "json",
            data: {
                submit1: true,
                search: searchTerm
            },
            success: function (data) {
                console.log(searchTerm);
                console.log("Data received:", data);
                if (Array.isArray(data) && data.length > 0) {
                    let content = '';
                    data.forEach(function (book) {
                        let bookImage = book.BOOK_IMG ? `data:image/jpeg;base64,${book.BOOK_IMG}` : '../../Assets/Image/default_book_img.png';
                        let availability = book.AVAILABLE_COUNT > 0 ? 'Yes' : 'No';
                        console.log(book.AVAILABLE_COUNT);
                        content += `
                            <div class="book-item">
                                <img src="${bookImage}" alt="${book.TITLE}" class="book-img">
                                <h3>${book.TITLE}</h3>
                                <p>Publication: ${book.PUB_NAME}</p>
                                <p>Author: ${book.AUTHOR}</p>
                                <p>Available: ${availability}</p>
                            </div>
                        `;
                    });
                    $('#books-content').html(content);
                } else {
                    $('#books-content').html('<p>No books available</p>');
                }
            },
            error: function (error) {
                console.log("Error fetching books data:", error);
                $('#books-content').html('<p>Error fetching books data. Please try again later.</p>');
            }
        });
    }

    // Fetch books when the page loads
    fetchBooks();

    $('#search-form').on('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission

        var searchTerm = $('#search-input').val();
        fetchBooks(searchTerm); // Fetch books with the search term
    });
});