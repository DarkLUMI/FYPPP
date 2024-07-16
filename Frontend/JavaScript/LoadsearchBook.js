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
                if (Array.isArray(data) && data.length > 0) {
                    let content = '';
                    data.forEach(function (book) {
                        let bookImage = book.BOOK_IMG ? `data:image/jpeg;base64,${book.BOOK_IMG}` : '../../Assets/Image/default_book_img.png';
                        content += `
                            <div class="book-item">
                                <img src="${bookImage}" alt="${book.TITLE}" class="book-img">
                                <h3>${book.TITLE}</h3>
                                <p>Author: ${book.AUTHOR}</p>
                                <p>Available: ${book.AVAILABLE}</p>
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