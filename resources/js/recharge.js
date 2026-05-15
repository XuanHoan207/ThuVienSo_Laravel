// Recharge Page JavaScript
let selectedAmount = 50000;
let selectedPoints = 550;
let selectedPayment = 'vnpay';

function selectPackage(element, amount, points) {
    // Remove selected from all
    document.querySelectorAll('.package-card').forEach(card => {
        card.classList.remove('selected');
    });
    // Add selected to clicked
    element.classList.add('selected');

    // Hide custom amount card if visible
    const customAmountCard = document.getElementById('customAmountCard');
    if (customAmountCard) {
        customAmountCard.style.display = 'none';
    }

    // Update values
    selectedAmount = amount;
    selectedPoints = points;

    // Update summary
    updateSummary();
}

function showCustomAmount() {
    const customAmountCard = document.getElementById('customAmountCard');
    if (customAmountCard) {
        customAmountCard.style.display = 'block';
    }
    document.querySelectorAll('.package-card').forEach(card => {
        card.classList.remove('selected');
    });
    const customAmountInput = document.getElementById('customAmount');
    if (customAmountInput) {
        customAmountInput.focus();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const customAmountInput = document.getElementById('customAmount');
    if (customAmountInput) {
        customAmountInput.addEventListener('input', function() {
            const amount = parseInt(this.value) || 0;
            // 100 points per 10,000 VND
            let points = Math.floor(amount / 100);
            
            // Bonus calculation
            if (amount >= 500000) points = Math.floor(points * 1.5);
            else if (amount >= 200000) points = Math.floor(points * 1.3);
            else if (amount >= 100000) points = Math.floor(points * 1.2);
            else if (amount >= 50000) points = Math.floor(points * 1.1);

            const customPointsEl = document.getElementById('customPoints');
            if (customPointsEl) {
                customPointsEl.textContent = points.toLocaleString() + ' điểm';
            }
            selectedAmount = amount;
            selectedPoints = points;
            updateSummary();
        });
    }

    // Initialize
    updateSummary();
});

function selectPayment(element, method) {
    // Remove selected from all
    document.querySelectorAll('.payment-method').forEach(el => {
        el.classList.remove('selected');
        const checkIcon = el.querySelector('.bi-check-circle-fill');
        if (checkIcon) {
            checkIcon.style.display = 'none';
        }
    });
    // Add selected to clicked
    element.classList.add('selected');
    const checkIcon = element.querySelector('.bi-check-circle-fill');
    if (checkIcon) {
        checkIcon.style.display = 'block';
    }
    selectedPayment = method;

    // Update summary
    updateSummary();
}

function updateSummary() {
    const paymentNames = {
        'vnpay': 'VNPay',
        'momo': 'MoMo',
        'zalo': 'ZaloPay',
        'banking': 'Chuyển khoản'
    };

    const summaryPackage = document.getElementById('summaryPackage');
    const summaryPayment = document.getElementById('summaryPayment');
    const summaryPoints = document.getElementById('summaryPoints');
    const summaryAmount = document.getElementById('summaryAmount');

    if (summaryPackage) {
        summaryPackage.textContent = selectedPoints.toLocaleString() + ' điểm';
    }
    if (summaryPayment) {
        summaryPayment.textContent = paymentNames[selectedPayment];
    }
    if (summaryPoints) {
        summaryPoints.textContent = selectedPoints.toLocaleString() + ' điểm';
    }
    if (summaryAmount) {
        summaryAmount.textContent = 'Thanh toán: ' + selectedAmount.toLocaleString() + 'đ';
    }
}

function processPayment() {
    if (selectedAmount < 10000) {
        alert('Số tiền tối thiểu là 10,000 VNĐ');
        return;
    }

    // Show success modal (simulated)
    const modalPoints = document.getElementById('modalPoints');
    const modalBalance = document.getElementById('modalBalance');
    
    if (modalPoints) {
        modalPoints.textContent = selectedPoints.toLocaleString() + ' điểm';
    }
    if (modalBalance) {
        modalBalance.textContent = (1250 + selectedPoints).toLocaleString() + ' điểm';
    }
    
    var modal = new bootstrap.Modal(document.getElementById('successModal'));
    modal.show();
}
