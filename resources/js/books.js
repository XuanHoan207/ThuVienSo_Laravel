// Books Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Price range display
    const priceRange = document.getElementById('priceRange');
    if (priceRange) {
        priceRange.addEventListener('input', function() {
            document.getElementById('priceTo').value = this.value;
        });
    }
});

// Tag filter toggle
function toggleTag(element) {
    element.classList.toggle('selected');
    if (element.classList.contains('selected')) {
        element.style.backgroundColor = 'var(--themeColor, #ED553B)';
        element.style.color = 'white';
    } else {
        element.style.backgroundColor = '';
        element.style.color = '';
    }
    updateActiveFilters();
}

// View toggle
function setView(view, btn) {
    document.querySelectorAll('.view-toggle').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
}

// Update active filters display
function updateActiveFilters() {
    const container = document.querySelector('.active-filters');
    if (!container) return;
    container.innerHTML = '';
    
    document.querySelectorAll('.tag-badge.selected').forEach(tag => {
        const filterTag = document.createElement('span');
        filterTag.className = 'filter-tag';
        filterTag.innerHTML = `${tag.textContent} <i class="bi bi-x" onclick="removeTag(this, '${tag.textContent}')"></i>`;
        container.appendChild(filterTag);
    });

    document.querySelectorAll('.category-filter:checked').forEach(cat => {
        if (cat.value) {
            const filterTag = document.createElement('span');
            filterTag.className = 'filter-tag';
            filterTag.innerHTML = `${cat.nextElementSibling.textContent} <i class="bi bi-x"></i>`;
            container.appendChild(filterTag);
        }
    });
}

function removeTag(icon, tagName) {
    icon.parentElement.remove();
    document.querySelectorAll('.tag-badge').forEach(tag => {
        if (tag.textContent === tagName) {
            tag.classList.remove('selected');
            tag.style.backgroundColor = '';
            tag.style.color = '';
        }
    });
}

function clearFilters() {
    document.querySelectorAll('.tag-badge').forEach(tag => {
        tag.classList.remove('selected');
        tag.style.backgroundColor = '';
        tag.style.color = '';
    });
    document.querySelectorAll('.category-filter').forEach(cat => {
        cat.checked = cat.id === 'catAll';
    });
    document.querySelectorAll('.active-filters').forEach(container => {
        container.innerHTML = '';
    });
    document.getElementById('priceFrom').value = '';
    document.getElementById('priceTo').value = '';
    document.getElementById('priceRange').value = 2000;
}
