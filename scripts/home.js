const textarea = document.getElementById('write-textarea');
const sendPostButton = document.getElementById('send-post');
const feed = document.getElementById('feed');

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

function fetchPosts() {
    feed.innerHTML = '';
    fetch('./php_scripts/load_posts.php?case=all')
    .then(response => response.json())
    .then(posts => {
        console.log(posts);
        posts.forEach(post => {
            const div = document.createElement('div');
            div.classList.add('post-div');
            div.innerHTML = `
            <div class="user-div">
                <span class="post-date">From ${formatDate(post.created_at)}</span>
                <img src="${post.pp_path}" alt="Avatar" class="post-pic">
                <a class="username" href="#">${post.username}</a>
            </div>
            <div class="cloud">
                <div class="spike in-post"></div>
                <textarea readonly id="post-textarea" class="post-text">${post.content}</textarea>
            </div>`;
            feed.appendChild(div);
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    fetchPosts();
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
        if (data === "success") fetchPosts();
        else if (data === "empty") alert("Post cannot be empty");
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
