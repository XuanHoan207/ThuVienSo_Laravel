// Admin Dashboard JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Sidebar Toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarToggleMobile = document.getElementById('sidebarToggleMobile');
    const adminWrapper = document.querySelector('.admin-wrapper');
    const adminSidebar = document.getElementById('adminSidebar');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            adminWrapper.classList.toggle('collapsed');
        });
    }

    if (sidebarToggleMobile) {
        sidebarToggleMobile.addEventListener('click', function() {
            adminSidebar.classList.toggle('show');
        });
    }

    // Close sidebar on outside click (mobile)
    document.addEventListener('click', function(e) {
        if (window.innerWidth < 992 && 
            adminSidebar && 
            adminSidebar.classList.contains('show') &&
            !adminSidebar.contains(e.target) &&
            !sidebarToggleMobile.contains(e.target)) {
            adminSidebar.classList.remove('show');
        }
    });

    // Dropdown auto-close on click outside
    document.addEventListener('click', function(e) {
        const dropdowns = document.querySelectorAll('.dropdown-menu.show');
        dropdowns.forEach(dropdown => {
            if (!dropdown.contains(e.target) && !dropdown.previousElementSibling?.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });
    });

    // Pending actions (approve/reject)
    const approveBtns = document.querySelectorAll('.pending-actions .btn-success');
    const rejectBtns = document.querySelectorAll('.pending-actions .btn-danger');

    approveBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('Bạn có chắc muốn duyệt sách này?')) {
                const pendingItem = this.closest('.pending-item');
                pendingItem.style.opacity = '0.5';
                setTimeout(() => {
                    pendingItem.remove();
                }, 300);
            }
        });
    });

    rejectBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (confirm('Bạn có chắc muốn từ chối sách này?')) {
                const pendingItem = this.closest('.pending-item');
                pendingItem.style.opacity = '0.5';
                setTimeout(() => {
                    pendingItem.remove();
                }, 300);
            }
        });
    });
});
