const textarea = document.getElementById('write-textarea');
const sendPostButton = document.getElementById('send-post');

function resizeTextarea() {
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
}

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
        console.log(data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
