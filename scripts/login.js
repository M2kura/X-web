const title = document.getElementById("title");
const loginForm = document.getElementById("form-login");
const signupForm = document.getElementById("form-signup");
const loginLink = document.getElementById("link-to-login");
const signupLink = document.getElementById("link-to-signup");
const fileClearButton = document.getElementById("clear-file");
const fileInput = document.getElementById("profile-picture");

function redirect() {
    loginForm.classList.toggle("hidden")
    signupForm.classList.toggle("hidden")
    if (title.innerHTML == "Twixter: Log In") {
        title.innerHTML = "Twixter: Sign Up";
    } else {
        title.innerHTML = "Twixter: Log In";
    }
}

loginLink.addEventListener('click', (e) => {
    e.preventDefault();
    redirect();
});

signupLink.addEventListener('click', (e) => {
    e.preventDefault();
    redirect();
});

fileInput.addEventListener('change', () => {
    fileClearButton.classList.toggle("hidden");
})

fileClearButton.addEventListener('click', (e) => {
    e.preventDefault();
    fileInput.value = "";
    fileClearButton.classList.add("hidden");
});