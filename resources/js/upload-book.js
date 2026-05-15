// Upload Book Page JavaScript
let currentStep = 1;

function nextStep(step) {
    document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
    document.querySelector(`.form-step[data-step="${step}"]`).classList.add('active');
    
    document.querySelectorAll('.step').forEach(el => {
        const stepNum = parseInt(el.dataset.step);
        if (stepNum < step) {
            el.classList.add('completed');
            el.classList.remove('active');
        } else if (stepNum === step) {
            el.classList.add('active');
            el.classList.remove('completed');
        } else {
            el.classList.remove('active', 'completed');
        }
    });

    // Update preview
    if (step === 3) {
        updatePreview();
    }
}

function prevStep(step) {
    nextStep(step);
}

function updatePreview() {
    const title = document.querySelector('input[type="text"]').value || 'Tiêu đề sách';
    const previewTitle = document.getElementById('previewTitle');
    if (previewTitle) {
        previewTitle.textContent = title;
    }
    
    const price = document.querySelector('input[type="number"]').value || '0';
    const previewPrice = document.getElementById('previewPrice');
    if (previewPrice) {
        previewPrice.textContent = price + ' điểm';
    }
}

function addAuthor() {
    const authorList = document.getElementById('authorList');
    if (!authorList) return;
    const newAuthor = document.createElement('div');
    newAuthor.className = 'input-group mb-2';
    newAuthor.innerHTML = `
        <input type="text" class="form-control" placeholder="Tên tác giả">
        <select class="form-select" style="max-width: 150px;">
            <option value="author">Tác giả</option>
            <option value="co-author">Đồng tác giả</option>
            <option value="translator">Dịch giả</option>
            <option value="editor">Biên tập</option>
        </select>
        <button type="button" class="btn btn-outline-danger" onclick="removeAuthor(this)">
            <i class="bi bi-trash"></i>
        </button>
    `;
    authorList.appendChild(newAuthor);
}

function removeAuthor(btn) {
    const authorList = document.getElementById('authorList');
    if (authorList.children.length > 1) {
        btn.closest('.input-group').remove();
    }
}

function formatFileSize(bytes) {
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / 1048576).toFixed(1) + ' MB';
}

document.addEventListener('DOMContentLoaded', function() {
    // File upload handling - Book file
    const bookFileInput = document.getElementById('bookFile');
    if (bookFileInput) {
        bookFileInput.addEventListener('change', function(e) {
            if (this.files.length > 0) {
                const file = this.files[0];
                const fileName = document.getElementById('fileName');
                const fileSize = document.getElementById('fileSize');
                const filePreview = document.getElementById('filePreview');
                
                if (fileName) fileName.textContent = file.name;
                if (fileSize) fileSize.textContent = formatFileSize(file.size);
                if (filePreview) filePreview.style.display = 'block';
            }
        });
    }

    // File upload handling - Thumbnail
    const thumbnailFileInput = document.getElementById('thumbnailFile');
    if (thumbnailFileInput) {
        thumbnailFileInput.addEventListener('change', function(e) {
            if (this.files.length > 0) {
                const file = this.files[0];
                const reader = new FileReader();
                reader.onload = function(e) {
                    const thumbnailPreview = document.getElementById('thumbnailPreview');
                    const thumbnailPlaceholder = document.getElementById('thumbnailPlaceholder');
                    if (thumbnailPreview) {
                        thumbnailPreview.src = e.target.result;
                        thumbnailPreview.style.display = 'block';
                    }
                    if (thumbnailPlaceholder) {
                        thumbnailPlaceholder.style.display = 'none';
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Thumbnail drop zone click
    const thumbnailDropZone = document.getElementById('thumbnailDropZone');
    if (thumbnailDropZone) {
        thumbnailDropZone.addEventListener('click', function() {
            const thumbnailInput = document.getElementById('thumbnailFile');
            if (thumbnailInput) {
                thumbnailInput.click();
            }
        });
    }

    // Tag input handling
    const tagInput = document.getElementById('tagInput');
    if (tagInput) {
        const inputField = tagInput.querySelector('input');
        if (inputField) {
            inputField.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const tag = this.value.trim();
                    if (tag) {
                        const tagEl = document.createElement('span');
                        tagEl.className = 'tag';
                        tagEl.innerHTML = `${tag} <i class="bi bi-x"></i>`;
                        tagEl.querySelector('i').addEventListener('click', function() {
                            tagEl.remove();
                        });
                        tagInput.insertBefore(tagEl, this);
                        this.value = '';
                    }
                }
            });
        }

        tagInput.querySelectorAll('.tag i').forEach(btn => {
            btn.addEventListener('click', function() {
                this.parentElement.remove();
            });
        });
    }

    // Form submission
    const uploadForm = document.getElementById('uploadForm');
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Sách của bạn đã được đăng tải thành công! Sách sẽ được kiểm duyệt trong 24-48 giờ.');
            window.location.href = 'my-account.html';
        });
    }
});

function removeFile() {
    const bookFileInput = document.getElementById('bookFile');
    const filePreview = document.getElementById('filePreview');
    if (bookFileInput) bookFileInput.value = '';
    if (filePreview) filePreview.style.display = 'none';
}
