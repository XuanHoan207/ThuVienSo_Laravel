// Authors Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Letter filter functionality
    const letterFilter = document.getElementById('letterFilter');
    if (letterFilter) {
        letterFilter.addEventListener('change', function(e) {
            const letter = e.target.value;
            filterAuthors(letter);
        });
    }

    // Search functionality
    const searchAuthor = document.getElementById('searchAuthor');
    if (searchAuthor) {
        searchAuthor.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('#authorsGrid .col-lg-3');
            cards.forEach(card => {
                const name = card.querySelector('h5').textContent.toLowerCase();
                if (name.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
});

function filterAuthors(letter) {
    const cards = document.querySelectorAll('#authorsGrid .col-lg-3');
    cards.forEach(card => {
        const name = card.querySelector('h5').textContent;
        if (letter === 'all' || name.toUpperCase().startsWith(letter)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}
