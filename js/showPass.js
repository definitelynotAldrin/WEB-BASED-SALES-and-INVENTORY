
// document.getElementById("showPassword").addEventListener("click", function() {
//     const passwordInput = document.getElementById("passwordInput");
//     passwordInput.type = "text";
//     this.style.display = "none";
//     document.getElementById("hidePassword").style.display = "block";
// });

// document.getElementById("hidePassword").addEventListener("click", function() {
//     const passwordInput = document.getElementById("passwordInput");
//     passwordInput.type = "password";
//     this.style.display = "none";
//     document.getElementById("showPassword").style.display = "block";
// });


const toggle = document.getElementById('hidePassword');
    const password = document.getElementById('passwordInput');

    toggle.addEventListener('click', function(){
        if(password.type === "password"){
            password.type = 'text';
        }else{
            password.type = 'password';
        }
        this.classList.toggle('fa-eye');
    });