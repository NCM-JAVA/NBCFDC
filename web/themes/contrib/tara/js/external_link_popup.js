document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('a[href^="http://"], a[href^="https://"]').forEach(function(link) {
    link.addEventListener('click', function(e) {
      // Check if the link has the 'no-alert' class
      if (!link.classList.contains('no-alert')) {
        e.preventDefault();
        alert('This link goes to another website.');
        // Optionally open the link in a new tab
        window.open(link.href, '_blank');
      } else {
        // If it is a logo link, allow the default behavior
        window.location.href = link.href;
      }
    });
  });
});