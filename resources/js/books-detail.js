// Book Detail Page JavaScript
let selectedRating = 0;

document.addEventListener('DOMContentLoaded', function() {
    // Star rating input
    const ratingStars = document.querySelectorAll('#ratingInput i');
    ratingStars.forEach(star => {
        star.addEventListener('click', function() {
            selectedRating = parseInt(this.dataset.rating);
            updateRatingDisplay();
        });

        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            highlightStars(rating);
        });

        star.addEventListener('mouseleave', function() {
            updateRatingDisplay();
        });
    });

    // Form submissions
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (selectedRating === 0) {
                alert('Vui lòng chọn xếp hạng của bạn!');
                return;
            }
            alert('Cảm ơn bạn đã gửi đánh giá!');
        });
    }

    const commentForm = document.getElementById('commentForm');
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Bình luận của bạn đã được gửi!');
        });
    }
});

function highlightStars(count) {
    document.querySelectorAll('#ratingInput i').forEach((star, index) => {
        if (index < count) {
            star.classList.add('active');
        } else {
            star.classList.remove('active');
        }
    });
}

function updateRatingDisplay() {
    document.querySelectorAll('#ratingInput i').forEach((star, index) => {
        if (index < selectedRating) {
            star.classList.add('active');
        } else {
            star.classList.remove('active');
        }
    });
}

// Add to cart
function addToCart() {
    const btn = document.getElementById('addToCartBtn');
    if (!btn) return;
    btn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Đã thêm!';
    btn.classList.remove('btn-primary');
    btn.classList.add('btn-success');
    
    setTimeout(() => {
        btn.innerHTML = '<i class="bi bi-cart-plus me-2"></i>Thêm vào giỏ';
        btn.classList.remove('btn-success');
        btn.classList.add('btn-primary');
    }, 2000);
}

// Toggle wishlist
function toggleWishlist() {
    const btn = document.getElementById('wishlistBtn');
    if (!btn) return;
    if (btn.classList.contains('btn-outline-danger')) {
        btn.classList.remove('btn-outline-danger');
        btn.classList.add('btn-danger');
        btn.innerHTML = '<i class="bi bi-heart-fill"></i> Đã yêu thích';
    } else {
        btn.classList.remove('btn-danger');
        btn.classList.add('btn-outline-danger');
        btn.innerHTML = '<i class="bi bi-heart"></i> Yêu thích';
    }
}

// Report book
function reportBook() {
    const modal = new bootstrap.Modal(document.getElementById('reportModal'));
    modal.show();
}

function submitReport() {
    alert('Cảm ơn bạn đã báo cáo! Chúng tôi sẽ xem xét trong thời gian sớm nhất.');
    bootstrap.Modal.getInstance(document.getElementById('reportModal')).hide();
}

function loadMoreReviews() {
    alert('Đang tải thêm đánh giá...');
}
