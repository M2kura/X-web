const title = document.getElementById("title");
const loginFormDiv = document.getElementById("form-login");
const loginForm = document.getElementById("login-form");
const signupFormDiv = document.getElementById("form-signup");
const signupForm = document.getElementById("signup-form");
const redirectLinks = document.querySelectorAll(".redirect");
const formInputs = document.querySelectorAll(".form-input");
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
    } else if (type === "file-ext") {
        war.textContent = "Allowed file extensions are: png, jpeg and jpg";
    } else if (type === "file-size") {
        war.textContent = "File cannot be larger then 5MB";
    }
    if (document.querySelector("."+type) === null) {
        signupForm.insertBefore(war, submitButton);
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

loginForm.addEventListener('sumbit', (e) => {
    e.preventDefault();
    // TODO valisation
    loginForm.submit();
});

signupForm.addEventListener('submit', (e) => {
    e.preventDefault();
    let form = { acceptable: true };
    const login = document.getElementById("signup-login").value;
    const pass = document.getElementById("signup-password").value;
    const pass2 = document.getElementById("signup-password2").value;
    const file = fileInput.files[0];
    const extensions = /(\.jpg|\.jpeg|\.png)$/i;

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
    if (file) {
        if (!extensions.exec(file.name)) {
            generateWar("file-ext", form);
        }
        if (file.size > 5 * 1024 * 1024) {
            generateWar("file-size", form);
        }
    }
    if (form.acceptable) {
        signupForm.submit();
    }
});
