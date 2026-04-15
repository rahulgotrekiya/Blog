import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// ========== TOAST NOTIFICATIONS ==========
window.showToast = function(message, type = 'success') {
    // Create toast container if doesn't exist
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }
    
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    
    // Icon based on type
    let icon = '';
    if (type === 'success') {
        icon = '<svg class="toast-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12" stroke-width="2"></polyline></svg>';
    } else if (type === 'error') {
        icon = '<svg class="toast-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2"></circle><line x1="15" y1="9" x2="9" y2="15" strike-width="2"></line><line x1="9" y1="9" x2="15" y2="15" stroke-width="2"></line></svg>';
    } else {
        icon = '<svg class="toast-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2"></circle><line x1="12" y1="16" x2="12" y2="12" stroke-width="2"></line><line x1="12" y1="8" x2="12" y2="8" stroke-width="2"></line></svg>';
    }
    
    toast.innerHTML = `
        ${icon}
        <span class="toast-message">${message}</span>
    `;
    
    container.appendChild(toast);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
};

// ========== ENHANCED LIKE BUTTON ==========
document.addEventListener('DOMContentLoaded', function() {
    const likeButtons = document.querySelectorAll('.like-button, #like-btn');
    
    likeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Optimistic UI update
            const wasLiked = this.classList.contains('liked');
            const countSpan = this.querySelector('.like-count');
            
            if (countSpan) {
                let count = parseInt(countSpan.textContent) || 0;
                count = wasLiked ? count - 1 : count + 1;
                countSpan.textContent = count;
            }
            
            // Toggle liked class
            this.classList.toggle('liked');
            
            // If AJAX request fails, we'll rollback (handled in existing code)
        });
    });
    
    // Smooth scroll to comments after posting
    const commentForm = document.querySelector('.comment-form');
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            setTimeout(() => {
                const commentsSection = document.querySelector('.comments-section');
                if (commentsSection) {
                    commentsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 500);
        });
    }
});

// ========== DROPDOWN ENHANCEMENTS ==========
document.addEventListener('click', function(e) {
    // Close all dropdowns when clicking outside
    if (!e.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown.open').forEach(dropdown => {
            dropdown.classList.remove('open');
        });
    }
});

