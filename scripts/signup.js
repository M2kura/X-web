const signupForm = document.getElementById("signup-form");
const fileClearButton = document.getElementById("clear-file");
const fileInput = document.getElementById("profile-picture");
const submitButton = document.getElementById("submit-signup");

function generateWar(type, form) {
    form.acceptable = false;
    const war = document.createElement('p');
    war.classList.add("warning");
    war.classList.add(type);
    if (type === "empty") {
        war.textContent = "All required fields should not be empty";
    } else if (type === "no-match") {
        war.textContent = "Passwords does not match";
    } else if (type === "space") {
        war.textContent = "Whitespaces are not allowed";
    } else if (type === "long-login") {
        war.textContent = "Login cannot contain more than 24 characters";
    } else if (type === "long-pass") {
        war.textContent = "Password cannot contain more than 24 characters";
    } else if (type === "short-pass") {
        war.textContent = "Password must contain at least 8 characters";
    }
    if (document.querySelector("."+type) === null) {
        signupForm.insertBefore(war, submitButton);
    }
}

signupForm.addEventListener('submit', (e) => {
    let form = { acceptable: true };
    e.preventDefault();
    const login = document.getElementById("signup-login").value;
    const pass = document.getElementById("signup-password").value;
    const pass2 = document.getElementById("signup-password2").value;
    if (login === "" || pass === "" || pass2 === "") {
        generateWar("empty", form);
    }
    if (pass !== pass2) {
        generateWar("no-match", form);
    }
    if (login.includes(' ') || pass.includes(' ') || pass2.includes(' ')) {
        generateWar("space", form);
    }
    if (login.length > 24) {
        generateWar("long-login", form);
    }
    if (pass.length > 24) {
        generateWar("long-pass", form);
    }
    if (pass.length < 8) {
        generateWar("short-pass", form);
    }
    if (form.acceptable) {
        // send post request to php
    }
});

fileInput.addEventListener('change', () => {
    fileClearButton.classList.toggle("hidden");
})

fileClearButton.addEventListener('click', (e) => {
    e.preventDefault();
    fileInput.value = "";
    fileClearButton.classList.add("hidden");
});
