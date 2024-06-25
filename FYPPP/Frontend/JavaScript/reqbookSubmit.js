$(document).ready(function() {
    $('#requestForm').submit(function(event) {
        event.preventDefault();

        $.ajax({
            type: 'POST',
            url: "../../Backend/UserRequestBook.php",
            data: $(this).serialize(),
            success: function(response) {
                console.log(this);
                if (response.success) {
                    alert('Request created successfully');
                    window.location.href = '../HTML_code/UserRequestBook.html';
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Error submitting request');
            }
        });
    });
});
