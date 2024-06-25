function validatePassword() {
    var password = document.getElementsByName("password")[0].value;
    var confirmPassword = document.getElementsByName("confirm_password")[0].value;

    if (password !== confirmPassword) {
        alert("Passwords do not match. Please re-enter.");
        event.preventDefault();
        return false;
    }
    return true;
}