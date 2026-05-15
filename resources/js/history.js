// History Page JavaScript
function filterHistory(type, btn) {
    // Update active filter button
    document.querySelectorAll('.filter-tabs .btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    // Filter history items
    const items = document.querySelectorAll('.history-card');
    items.forEach(item => {
        if (type === 'all' || item.dataset.type === type) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
}
