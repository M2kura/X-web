const textarea = document.getElementById('write-textarea');
const sendPostButton = document.getElementById('send-post');
const feed = document.getElementById('feed');

function resizeTextarea() {
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
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
                <img src="${post.pp_path}" alt="Avatar" class="post-pic">
                <a class="username" href="#">${post.username}</a>
            </div>
            <div class="cloud">
                <div class="spike"></div>
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
