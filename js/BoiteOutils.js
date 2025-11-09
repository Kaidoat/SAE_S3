const textarea = document.getElementById('commentaire');
const details = document.getElementById('comment-details');
let shown = false;

textarea.addEventListener('input', () => {
    if (textarea.value.trim().length > 0 && !shown) {
        details.style.display = 'block';
        setTimeout(() => { details.style.opacity = 1; }, 50);
        shown = true;
    }
});