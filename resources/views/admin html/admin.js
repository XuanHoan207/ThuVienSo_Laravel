/* ============================================
   ADMIN THƯ VIỆN SỐ - JAVASCRIPT
   ============================================ */

// ============================================
// SIDEBAR TOGGLE
// ============================================
function toggleSidebar() {
    const sidebar = document.querySelector('.admin-sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    
    sidebar.classList.toggle('show');
    if (overlay) {
        overlay.classList.toggle('show');
    }
}

// Close sidebar when clicking overlay
document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.querySelector('.sidebar-overlay');
    if (overlay) {
        overlay.addEventListener('click', toggleSidebar);
    }
});

// ============================================
// TOAST NOTIFICATIONS
// ============================================
function showToast(type, title, message) {
    const container = document.querySelector('.toast-container') || createToastContainer();
    
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `
        <div class="toast-icon">
            <i class="fas ${getToastIcon(type)}"></i>
        </div>
        <div class="toast-content">
            <h4>${title}</h4>
            <p>${message}</p>
        </div>
    `;
    
    container.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease forwards';
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

function createToastContainer() {
    const container = document.createElement('div');
    container.className = 'toast-container';
    document.body.appendChild(container);
    return container;
}

function getToastIcon(type) {
    const icons = {
        success: 'fa-check',
        error: 'fa-times',
        warning: 'fa-exclamation',
        info: 'fa-info'
    };
    return icons[type] || 'fa-info';
}

// Add animation for toast removal
const style = document.createElement('style');
style.textContent = `
    @keyframes slideOut {
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// ============================================
// MODAL FUNCTIONS
// ============================================
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('show');
        document.body.style.overflow = 'auto';
    }
}

// Close modal when clicking backdrop
document.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal-backdrop')) {
        e.target.classList.remove('show');
        document.body.style.overflow = 'auto';
    }
});

// Close modal with Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const modals = document.querySelectorAll('.modal-backdrop.show');
        modals.forEach(modal => {
            modal.classList.remove('show');
        });
        document.body.style.overflow = 'auto';
    }
});

// ============================================
// CONFIRM DELETE
// ============================================
function confirmDelete(itemName, callback) {
    if (confirm(`Bạn có chắc chắn muốn xóa "${itemName}" không? Hành động này không thể hoàn tác.`)) {
        callback();
    }
}

// ============================================
// STATUS UPDATE
// ============================================
function updateStatus(itemId, newStatus, type) {
    // Simulated status update - in real app, call API
    showToast('success', 'Cập nhật thành công', `Trạng thái đã được thay đổi thành "${getStatusText(newStatus)}"`);
}

// ============================================
// FORM VALIDATION
// ============================================
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });
    
    return isValid;
}

// Remove invalid class on input
document.addEventListener('input', (e) => {
    if (e.target.classList.contains('is-invalid')) {
        e.target.classList.remove('is-invalid');
    }
});

// ============================================
// DATA TABLE FUNCTIONS
// ============================================
function searchTable(tableId, searchInputId) {
    const input = document.getElementById(searchInputId);
    const filter = input.value.toLowerCase();
    const table = document.getElementById(tableId);
    const rows = table.getElementsByTagName('tr');
    
    for (let i = 1; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        let found = false;
        
        for (let j = 0; j < cells.length; j++) {
            const cellText = cells[j].textContent || cells[j].innerText;
            if (cellText.toLowerCase().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }
        
        rows[i].style.display = found ? '' : 'none';
    }
}

function sortTable(tableId, column, direction) {
    const table = document.getElementById(tableId);
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    rows.sort((a, b) => {
        const aValue = a.cells[column].textContent.trim();
        const bValue = b.cells[column].textContent.trim();
        
        if (direction === 'asc') {
            return aValue.localeCompare(bValue, 'vi');
        } else {
            return bValue.localeCompare(aValue, 'vi');
        }
    });
    
    rows.forEach(row => tbody.appendChild(row));
}

// ============================================
// PAGINATION
// ============================================
class Pagination {
    constructor(options) {
        this.tableId = options.tableId;
        this.rowsPerPage = options.rowsPerPage || 10;
        this.currentPage = 1;
        this.init();
    }
    
    init() {
        this.updateTable();
        this.renderPagination();
    }
    
    getTotalRows() {
        const table = document.getElementById(this.tableId);
        return table.querySelector('tbody').querySelectorAll('tr').length;
    }
    
    getTotalPages() {
        return Math.ceil(this.getTotalRows() / this.rowsPerPage);
    }
    
    updateTable() {
        const table = document.getElementById(this.tableId);
        const rows = table.querySelector('tbody').querySelectorAll('tr');
        const start = (this.currentPage - 1) * this.rowsPerPage;
        const end = start + this.rowsPerPage;
        
        rows.forEach((row, index) => {
            if (index >= start && index < end) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    renderPagination() {
        const totalPages = this.getTotalPages();
        const paginationContainer = document.getElementById('pagination');
        
        if (!paginationContainer) return;
        
        let html = '';
        
        // Previous button
        html += `<div class="pagination-item ${this.currentPage === 1 ? 'disabled' : ''}" onclick="paginationInstance.prevPage()">
            <i class="fas fa-chevron-left"></i>
        </div>`;
        
        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            if (i === 1 || i === totalPages || (i >= this.currentPage - 1 && i <= this.currentPage + 1)) {
                html += `<div class="pagination-item ${i === this.currentPage ? 'active' : ''}" onclick="paginationInstance.goToPage(${i})">${i}</div>`;
            } else if (i === this.currentPage - 2 || i === this.currentPage + 2) {
                html += '<div class="pagination-item">...</div>';
            }
        }
        
        // Next button
        html += `<div class="pagination-item ${this.currentPage === totalPages ? 'disabled' : ''}" onclick="paginationInstance.nextPage()">
            <i class="fas fa-chevron-right"></i>
        </div>`;
        
        paginationContainer.innerHTML = html;
        
        // Update info
        const info = document.getElementById('paginationInfo');
        if (info) {
            const start = (this.currentPage - 1) * this.rowsPerPage + 1;
            const end = Math.min(this.currentPage * this.rowsPerPage, this.getTotalRows());
            info.textContent = `Hiển thị ${start} - ${end} của ${this.getTotalRows()} mục`;
        }
    }
    
    goToPage(page) {
        this.currentPage = page;
        this.updateTable();
        this.renderPagination();
    }
    
    nextPage() {
        if (this.currentPage < this.getTotalPages()) {
            this.currentPage++;
            this.updateTable();
            this.renderPagination();
        }
    }
    
    prevPage() {
        if (this.currentPage > 1) {
            this.currentPage--;
            this.updateTable();
            this.renderPagination();
        }
    }
}

// ============================================
// FILE UPLOAD PREVIEW
// ============================================
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            if (preview) {
                preview.src = e.target.result;
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// ============================================
// UTILITY FUNCTIONS
// ============================================
function getStatusText(status) {
    const statusTexts = {
        'pending': 'Đang chờ',
        'approved': 'Đã duyệt',
        'rejected': 'Từ chối',
        'hidden': 'Ẩn',
        'active': 'Hoạt động',
        'inactive': 'Không hoạt động',
        'completed': 'Hoàn thành',
        'failed': 'Thất bại',
        'cancelled': 'Đã hủy'
    };
    return statusTexts[status] || status;
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('vi-VN', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
}

function formatDateTime(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('vi-VN', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

function formatNumber(num) {
    return new Intl.NumberFormat('vi-VN').format(num);
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
        minimumFractionDigits: 0
    }).format(amount);
}

// ============================================
// CHART INITIALIZATION (placeholder for Chart.js)
// ============================================
function initCharts() {
    // This would be implemented with Chart.js
    // For now, it's a placeholder
    console.log('Charts initialized');
}

// ============================================
// EXPORT DATA
// ============================================
function exportTableToCSV(tableId, filename) {
    const table = document.getElementById(tableId);
    const rows = table.querySelectorAll('tr');
    let csv = [];
    
    rows.forEach(row => {
        const cols = row.querySelectorAll('td, th');
        const rowData = Array.from(cols).map(col => {
            let text = col.innerText.replace(/"/g, '""');
            return `"${text}"`;
        }).join(',');
        csv.push(rowData);
    });
    
    const csvContent = csv.join('\n');
    const blob = new Blob(['\ufeff' + csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = filename + '.csv';
    link.click();
}

// ============================================
// TABS
// ============================================
function openTab(tabId, contentId) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });
    
    // Remove active from all tab buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected tab content
    document.getElementById(contentId).classList.add('active');
    
    // Add active to clicked button
    document.querySelector(`[onclick="openTab('${tabId}', '${contentId}')"]`).classList.add('active');
}

// ============================================
// SIDEBAR ACTIVE LINK
// ============================================
function setActiveLink() {
    const currentPage = window.location.pathname.split('/').pop() || 'admin-dashboard.html';
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href') === currentPage) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
}

// Initialize active link on load
document.addEventListener('DOMContentLoaded', setActiveLink);

// ============================================
// SEARCH WITH DEBOUNCE
// ============================================
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// ============================================
// COPY TO CLIPBOARD
// ============================================
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showToast('success', 'Đã sao chép', 'Nội dung đã được sao chép vào clipboard');
    }).catch(() => {
        showToast('error', 'Lỗi', 'Không thể sao chép nội dung');
    });
}

// ============================================
// GLOBAL EXPORTS
// ============================================
window.Admin = {
    toggleSidebar,
    showToast,
    openModal,
    closeModal,
    confirmDelete,
    updateStatus,
    validateForm,
    searchTable,
    sortTable,
    exportTableToCSV,
    openTab,
    formatDate,
    formatDateTime,
    formatNumber,
    formatCurrency,
    previewImage,
    Pagination
};
