const changeForm = document.getElementById('change-form');
const changeBtn = document.getElementById('change-btn');
const closeBtn = document.getElementById('close-btn');
const clearImgBtn = document.getElementById('clear-file');
const picture = document.getElementById('profile-picture');
const inputs = document.querySelectorAll('.form-input');
const message = document.getElementById('message');
const username = document.getElementById('username');
const avatar = document.getElementById('avatar');
const feed = document.getElementById('feed');
const userBtns = document.getElementById('user-btns');
const role = document.getElementById('role');

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
            fetchPosts("users", data.username);
            let url = new URL(window.location.href);
            let params = new URLSearchParams(url.search);
            params.set('username', data.username);
            url.search = params.toString();
            window.history.pushState({}, '', url);
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
            role.innerHTML = data.role;
            fetchPosts("users", data.username);
            if (!data.isMe) {
                changeBtn.remove();
                changeForm.remove();
                const flwBtn = document.createElement('button');
                const unflwBtn = document.createElement('button');
                flwBtn.classList.add('follow-btn');
                unflwBtn.classList.add('unfollow-btn');
                flwBtn.innerHTML = 'Follow';
                unflwBtn.innerHTML = 'Unfollow';
                flwBtn.addEventListener('click', () => {
                    fetch(`php_scripts/to_follow.php?method=follow&username=${data.username}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            flwBtn.remove();
                            userBtns.appendChild(unflwBtn);
                        } else console.log(data.message);
                    })
                });
                unflwBtn.addEventListener('click', () => {
                    fetch(`php_scripts/to_follow.php?method=unfollow&username=${data.username}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            unflwBtn.remove();
                            userBtns.appendChild(flwBtn);
                        } else console.log(data.message);
                    })
                });
                if (data.following) {
                    userBtns.appendChild(unflwBtn);
                } else if (data.following === false) {
                    userBtns.appendChild(flwBtn);
                }
            }
        } else {
            window.location.href = './404';
        }
    })
    .catch(err => {
        console.error("Error:", err);
    });
});

function formatDate(dateString) {
    const date = new Date(dateString);
    const currentYear = new Date().getFullYear();
    const postYear = date.getFullYear();
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');

    if (postYear === currentYear) {
        return `${day}.${month}`;
    } else {
        return `${day}.${month}.${String(postYear).slice(-2)}`;
    }
}

function fetchPosts(postCase, username) {
    feed.innerHTML = '';
    const queryString = `case=${postCase}&username=${username}`;
    fetch(`./php_scripts/load_posts.php?${queryString}`)
    .then(response => response.json())
    .then(data => {
        data.posts.forEach(post => {
            const div = document.createElement('div');
            div.classList.add('post-div');
            div.id = post.id;
            div.innerHTML = `
            <div class="user-div">
                <span class="post-date">From ${formatDate(post.created_at)}</span>
                <img src="${post.pp_path}" alt="Avatar" class="post-pic">
                <a class="username" href="./profile?username=${post.username}">${post.username}</a>
            </div>
            <div class="cloud">
                <div class="spike in-post"></div>
                <textarea readonly id="post-textarea" class="post-text">${post.content}</textarea>
            </div>`;
            if (data.role === "admin" || data.login === post.username)
                div.innerHTML += '<button class="delete-btn">&#10006;</button>'
            feed.appendChild(div);
        });
        const deleteBtns = document.querySelectorAll('.delete-btn');
        deleteBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const postDiv = btn.parentElement;
                fetch(`php_scripts/delete_post.php?id=${postDiv.id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        postDiv.remove();
                    } else {
                        console.log(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
