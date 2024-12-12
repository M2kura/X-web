const title = document.getElementById("title");
const loginFormDiv = document.getElementById("form-login");
const loginForm = document.getElementById("login-form");
const signupFormDiv = document.getElementById("form-signup");
const redirectLinks = document.querySelectorAll(".redirect");
const formInputs = document.querySelectorAll(".form-input");

function redirect() {
    loginFormDiv.classList.toggle("hidden")
    signupFormDiv.classList.toggle("hidden")
    if (title.innerHTML == "Twixter: Log In") {
        title.innerHTML = "Twixter: Sign Up";
    } else {
        title.innerHTML = "Twixter: Log In";
    }
}

redirectLinks.forEach((link) => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        redirect();
    });
});


loginForm.addEventListener('sumbit', (e) => {
    preventDefault(e);

});

formInputs.forEach((input) => {
    input.addEventListener('focus', () => {
        const formWarnings = document.querySelectorAll(".warning");
        formWarnings.forEach((war) => {
            war.remove();
        });
    });
});
