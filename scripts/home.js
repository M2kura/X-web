const textarea = document.getElementById('write-textarea');

function resizeTextarea() {
    textarea.style.height = 'auto'; // Reset the height
    textarea.style.height = textarea.scrollHeight + 'px'; // Set the height to the scroll height
}

textarea.addEventListener('input', (e) => {
    e.preventDefault();
    resizeTextarea();
});
