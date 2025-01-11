const changeForm = document.getElementById('change-form');
const changeBtn = document.getElementById('change-btn');
const closeBtn = document.getElementById('close-btn');
const clearImgBtn = document.getElementById('clear-file');
const picture = document.getElementById('profile-picture');
const inputs = document.querySelectorAll('.form-input');
const message = document.getElementById('message');
const username = document.getElementById('username');
const avatar = document.getElementById('avatar');

changeBtn.addEventListener('click', () => {
    changeForm.classList.toggle('hidden');
});

closeBtn.addEventListener('click', (e) => {
    e.preventDefault();
    changeForm.classList.toggle('hidden');
    message.classList.add('hidden');
});

clearImgBtn.addEventListener('click', (e) => {
    e.preventDefault();
    picture.value = "";
    clearImgBtn.classList.toggle('hidden');
});

picture.addEventListener('change', () => {
    clearImgBtn.classList.toggle('hidden');
})

username.addEventListener('enter', (e) => {
    e.preventDefault();
});

changeForm.addEventListener('submit', (e) => {
    e.preventDefault();
    fetch('php_scripts/update_profile.php', {
        method: 'POST',
        body: new FormData(changeForm),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success != false) {
            inputs.forEach(input => {
                input.value = "";
            });
            message.classList.remove('hidden');
            message.style.color = 'green';
            message.innerHTML = 'Profile updated successfully!';
            avatar.src = data.avatar + '?' + new Date().getTime();
            username.innerHTML = data.username;
        } else {
            message.classList.remove('hidden');
            message.style.color = 'red';
            message.innerHTML = data.message;
        }
    })
    .catch(err => {
        console.error("Error:", err);
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const usernameParam = params.get("username");

    fetch(`php_scripts/load_user.php?username=${usernameParam}`)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            avatar.src = data.avatar;
            username.innerHTML = data.username;
            if (!data.isMe) {
                changeBtn.remove();
                changeForm.remove();
            }
        } else {
            window.location.href = './404';
        }
    })
    .catch(err => {
        console.error("Error:", err);
    });
});
