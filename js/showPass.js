
document.getElementById("showPassword").addEventListener("click", function() {
    const passwordInput = document.getElementById("passwordInput");
    passwordInput.type = "text";
    this.style.display = "none";
    document.getElementById("hidePassword").style.display = "block";
});

document.getElementById("hidePassword").addEventListener("click", function() {
    const passwordInput = document.getElementById("passwordInput");
    passwordInput.type = "password";
    this.style.display = "none";
    document.getElementById("showPassword").style.display = "block";
});