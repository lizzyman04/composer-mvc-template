document.addEventListener('DOMContentLoaded', function() {
    const postLink = document.querySelector('.post-link');
    if (postLink) {
        postLink.addEventListener('click', function(event) {
            if (!confirm("Are you sure you want to post a new blog?")) {
                event.preventDefault();
            }
        });
    }
});
