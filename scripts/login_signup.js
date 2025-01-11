const title = document.getElementById("title");
const loginFormDiv = document.getElementById("form-login");
const loginForm = document.getElementById("login-form");
const loginPass = document.getElementById("login-password");
const signupFormDiv = document.getElementById("form-signup");
const signupForm = document.getElementById("signup-form");
const signPass = document.getElementById("signup-password");
const signPass2 = document.getElementById("signup-password2");
const redirectLinks = document.querySelectorAll(".redirect");
const formInputs = document.querySelectorAll(".form-input");
const fileClearButton = document.getElementById("clear-file");
const fileInput = document.getElementById("profile-picture");
const submitButton = document.getElementById("submit-signup");
const submitLogin = document.getElementById("submit-login");

function generateWar(type, form, formType) {
    form.acceptable = false;
    const war = document.createElement('p');
    war.classList.add("warning");
    war.classList.add(type);
    if (type === "empty") {
        war.textContent = "All required fields should not be empty";
    } else if (type === "no-match") {
        war.textContent = "Passwords don't match";
    } else if (type === "space") {
        war.textContent = "Whitespaces are not allowed";
    } else if (type === "long-login") {
        war.textContent = "Login cannot contain more than 24 characters";
    } else if (type === "lenght-pass") {
        war.textContent = "Passwords should be from 8 to 24 characters long";
    } else if (type === "file-ext") {
        war.textContent = "Allowed file extensions are: png, jpeg and jpg";
    } else if (type === "file-size") {
        war.textContent = "File cannot be larger then 5MB";
    } else if (type === "fail") {
        war.textContent = "Failed to creat user";
    } else if (type === "problem") {
        war.textContent = "Invalid data. Try again";
    }
    if (document.querySelector("."+type) === null) {
        if (formType === "signup") signupForm.insertBefore(war, submitButton);
        else loginForm.insertBefore(war, submitLogin);
    }
}

function redirect() {
    loginFormDiv.classList.toggle("hidden")
    signupFormDiv.classList.toggle("hidden")
    if (title.innerHTML == "Twixter: Log In") {
        title.innerHTML = "Twixter: Sign Up";
    } else {
        title.innerHTML = "Twixter: Log In";
    }
}

function clearForms() {
    clearWars();
    clearInputs();
}

function clearWars() {
    const formWarnings = document.querySelectorAll(".warning");
    formWarnings.forEach((war) => {
        war.remove();
    });
}

function clearInputs() {
    formInputs.forEach((input) => {
        input.value = "";
    });
}

redirectLinks.forEach((link) => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        clearForms();
        redirect();
    });
});

formInputs.forEach((input) => {
    input.addEventListener('focus', () => {
        clearWars();
    });
});

fileInput.addEventListener('change', () => {
    fileClearButton.classList.toggle("hidden");
})

fileClearButton.addEventListener('click', (e) => {
    e.preventDefault();
    fileInput.value = "";
    fileClearButton.classList.add("hidden");
    const sizeWar = document.querySelector(".file-size");
    const extWar = document.querySelector(".file-ext");
    if (sizeWar) {
        sizeWar.remove();
    }
    if (extWar) {
        extWar.remove();
    }
});

loginForm.addEventListener('submit', (e) => {
    e.preventDefault();
    let form = { acceptable: true };
    fetch('php_scripts/login_script.php', {
        method: 'POST',
        body: new FormData(loginForm)
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            loginPass.value = '';
            generateWar(data.message, form, "login");
        } else window.location.href = "./home";
    })
    .catch(err => {
        console.error("Error:", err);
    });
});

signupForm.addEventListener('submit', (e) => {
    e.preventDefault();
    let form = { acceptable: true };
    const login = document.getElementById("signup-login").value;
    const pass = signPass.value;
    const pass2 = signPass2.value;
    const file = fileInput.files[0];
    const extensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (login === "" || pass === "" || pass2 === "") {
        generateWar("empty", form, "signup");
    }
    if (pass !== pass2) {
        generateWar("no-match", form, "signup");
    }
    if (login.includes(' ') || pass.includes(' ') || pass2.includes(' ')) {
        generateWar("space", form, "signup");
    }
    if (login.length > 24) {
        generateWar("long-login", form, "signup");
    }
    if (pass.length > 24 || pass.length < 8) {
        generateWar("lenght-pass", form, "signup");
    }
    if (file) {
        if (!extensions.exec(file.name)) {
            generateWar("file-ext", form, "signup");
        }
        if (file.size > 5 * 1024 * 1024) {
            generateWar("file-size", form, "signup");
        }
    }
    if (form.acceptable) {
        fetch('php_scripts/signup_script.php', {
            method: 'POST',
            body: new FormData(signupForm)
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                signPass.value = '';
                signPass2.value = '';
                fileInput.value = "";
                generateWar(data.message, form, "signup");
            } else window.location.href = "./home";
        })
        .catch(err => {
            console.error("Error:", err);
        });
    }
});
