const textarea = document.getElementById('write-textarea');
const sendPostButton = document.getElementById('send-post');
const feed = document.getElementById('feed');
const world = document.getElementById('world');
const following = document.getElementById('following');
const content = document.getElementById('content');
let postCount = 0;
let currentCase = "all"

function resizeTextarea() {
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
}

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

function fetchHomePosts(postCase, count) {
    if (count === 0) {
        feed.innerHTML = '';
        postCount = 0;
    }
    if (postCount < 0) return;
    fetch(`./php_scripts/load_posts.php?case=${postCase}&count=${count}`)
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
            if (data.role === "admin" || data.login === post.username) {
                deleteBtn = document.createElement('button');
                deleteBtn.classList.add('delete-btn');
                deleteBtn.innerHTML = '&#10006;';
                deleteBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    fetch(`php_scripts/delete_post.php?id=${div.id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            div.remove();
                            postCount--;
                        } else console.log(data.message);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
                div.appendChild(deleteBtn);
            }
            feed.appendChild(div);
            postCount++;
        });
        if (data.posts.length < 10) {
            const div = document.createElement('div');
            div.classList.add('post-div', 'end');
            div.innerHTML = `<p>That was the last post</p>`;
            feed.appendChild(div);
            postCount = -1;
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    fetchHomePosts("all", 0);
});

textarea.addEventListener('input', (e) => {
    e.preventDefault();
    resizeTextarea();
});

sendPostButton.addEventListener('click', () => {
    const text = textarea.value;
    const formData = new FormData();
    formData.append('postText', text);
    fetch('./php_scripts/send_post.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data === "success") {
            fetchHomePosts("all", 0);
            textarea.value = "";
        } else if (data === "empty") alert("Post cannot be empty");
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

world.addEventListener('click', () => {
    currentCase = "all";
    fetchHomePosts("all", 0);
});

following.addEventListener('click', () => {
    currentCase = "following";
    fetchHomePosts("following", 0);
});

function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

const debouncedFetchHomePosts = debounce(() => {
    fetchHomePosts(currentCase, postCount);
}, 200);

content.addEventListener('scroll', () => {
    if ((content.scrollTop + content.clientHeight) >= (content.scrollHeight - 500)) {
        debouncedFetchHomePosts();
    }
});
