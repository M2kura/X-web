const title = document.getElementById("title");
const loginForm = document.getElementById("form-login");
const signupForm = document.getElementById("form-signup");
const loginLink = document.getElementById("link-to-login");
const signupLink = document.getElementById("link-to-signup");

function redirect() {
    loginForm.classList.toggle("hidden")
    signupForm.classList.toggle("hidden")
}

loginLink.addEventListener('click', (e) => {
    e.preventDefault();
    redirect();
});

signupLink.addEventListener('click', (e) => {
    e.preventDefault();
    redirect();
});