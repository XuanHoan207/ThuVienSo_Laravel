// Notifications Page JavaScript
function filterNotifications(type, btn) {
    // Update active filter button
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    // Filter notifications
    const notifications = document.querySelectorAll('.notification-card');
    notifications.forEach(notification => {
        if (type === 'all' || notification.dataset.type === type) {
            notification.style.display = '';
        } else {
            notification.style.display = 'none';
        }
    });
}

function markAllRead() {
    const unreadNotifications = document.querySelectorAll('.notification-card.unread');
    unreadNotifications.forEach(notification => {
        notification.classList.remove('unread');
    });
    
    // Show toast notification
    const toast = document.createElement('div');
    toast.className = 'position-fixed bottom-0 end-0 p-3';
    toast.innerHTML = `
        <div class="toast show" role="alert">
            <div class="toast-body bg-success text-white rounded">
                <i class="bi bi-check-circle me-2"></i>Đã đánh dấu tất cả thông báo là đã đọc
            </div>
        </div>
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss notifications on click
    document.querySelectorAll('.notification-card').forEach(card => {
        card.addEventListener('click', function() {
            this.classList.remove('unread');
        });
    });
});
