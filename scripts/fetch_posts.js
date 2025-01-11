export function formatDate(dateString) {
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

export function fetchPosts(postCase, username="") {
    feed.innerHTML = '';
    const queryString = `case=${postCase}&username=${username}`;
    fetch(`./php_scripts/load_posts.php?${queryString}`)
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
                <a class="username" href="./profile?username=${post.username}">${post.username}</a>
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
