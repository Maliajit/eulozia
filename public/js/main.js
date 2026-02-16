// Hamburger menu toggle
document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobile-menu');

    if (hamburger && mobileMenu) {
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Search bar toggle
    const searchToggle = document.querySelector('.search-toggle');
    const searchBar = document.getElementById('search-bar');

    if (searchToggle && searchBar) {
        searchToggle.addEventListener('click', () => {
            searchBar.classList.toggle('hidden');
        });
    }

    // Close mobile menu when clicking on a link
    const mobileLinks = document.querySelectorAll('#mobile-menu a');
    mobileLinks.forEach(link => {
        link.addEventListener('click', () => {
            hamburger.classList.remove('active');
            mobileMenu.classList.add('hidden');
        });
    });

    // Initialize product carousels
    initializeProductCarousels();
});

// Product Carousel Functionality with Touch Support
function initializeProductCarousels() {
    const productCarousels = document.querySelectorAll('.product-carousel');

    productCarousels.forEach(carousel => {
        const imagesContainer = carousel.querySelector('.carousel-images');
        const images = carousel.querySelectorAll('.carousel-image');
        const prevButton = carousel.querySelector('.carousel-prev');
        const nextButton = carousel.querySelector('.carousel-next');
        const indicators = carousel.querySelectorAll('.carousel-indicator');

        let currentIndex = 0;
        const totalImages = images.length;
        let startX = 0;
        let currentX = 0;
        let isDragging = false;

        // Function to update carousel position
        function updateCarousel() {
            imagesContainer.style.transform = `translateX(-${currentIndex * 100}%)`;

            // Update indicators
            indicators.forEach((indicator, index) => {
                if (index === currentIndex) {
                    indicator.classList.add('active');
                    indicator.style.opacity = '1';
                } else {
                    indicator.classList.remove('active');
                    indicator.style.opacity = '0.5';
                }
            });
        }

        // Next button event
        if (nextButton) {
            nextButton.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % totalImages;
                updateCarousel();
            });
        }

        // Previous button event
        if (prevButton) {
            prevButton.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + totalImages) % totalImages;
                updateCarousel();
            });
        }

        // Touch events for mobile
        function handleTouchStart(e) {
            if (window.innerWidth >= 768) return; // Only on mobile

            isDragging = true;
            startX = e.touches[0].clientX;
            currentX = startX;
            imagesContainer.style.transition = 'none';
        }

        function handleTouchMove(e) {
            if (!isDragging || window.innerWidth >= 768) return;

            currentX = e.touches[0].clientX;
            const diff = currentX - startX;
            const currentTranslate = -currentIndex * 100;
            const newTranslate = currentTranslate + (diff / carousel.offsetWidth) * 100;

            imagesContainer.style.transform = `translateX(${newTranslate}%)`;
        }

        function handleTouchEnd() {
            if (!isDragging || window.innerWidth >= 768) return;

            isDragging = false;
            imagesContainer.style.transition = 'transform 0.3s ease-in-out';

            const diff = currentX - startX;
            const threshold = carousel.offsetWidth * 0.15; // 15% threshold

            if (Math.abs(diff) > threshold) {
                if (diff > 0) {
                    // Swipe right - previous image
                    currentIndex = (currentIndex - 1 + totalImages) % totalImages;
                } else {
                    // Swipe left - next image
                    currentIndex = (currentIndex + 1) % totalImages;
                }
            }

            updateCarousel();
        }

        // Add touch event listeners
        carousel.addEventListener('touchstart', handleTouchStart, { passive: true });
        carousel.addEventListener('touchmove', handleTouchMove, { passive: true });
        carousel.addEventListener('touchend', handleTouchEnd, { passive: true });

        // Mouse events for desktop testing (simpler version)
        function handleMouseDown(e) {
            if (window.innerWidth >= 768) return;

            isDragging = true;
            startX = e.clientX;
            currentX = startX;
            imagesContainer.style.transition = 'none';
        }

        function handleMouseMove(e) {
            if (!isDragging || window.innerWidth >= 768) return;

            currentX = e.clientX;
            const diff = currentX - startX;
            const currentTranslate = -currentIndex * 100;
            const newTranslate = currentTranslate + (diff / carousel.offsetWidth) * 100;

            imagesContainer.style.transform = `translateX(${newTranslate}%)`;
        }

        function handleMouseUp() {
            if (!isDragging || window.innerWidth >= 768) return;

            isDragging = false;
            imagesContainer.style.transition = 'transform 0.3s ease-in-out';

            const diff = currentX - startX;
            const threshold = carousel.offsetWidth * 0.15;

            if (Math.abs(diff) > threshold) {
                if (diff > 0) {
                    currentIndex = (currentIndex - 1 + totalImages) % totalImages;
                } else {
                    currentIndex = (currentIndex + 1) % totalImages;
                }
            }

            updateCarousel();
        }

        // Add mouse event listeners for testing
        carousel.addEventListener('mousedown', handleMouseDown);
        carousel.addEventListener('mousemove', handleMouseMove);
        carousel.addEventListener('mouseup', handleMouseUp);
        carousel.addEventListener('mouseleave', handleMouseUp); // Reset if mouse leaves

        // Indicator click events
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                currentIndex = index;
                updateCarousel();
            });
        });

        // Initialize carousel
        updateCarousel();



    });
}


// Cart functionality (if not already in cart.php)
function initializeCart() {
    // Cart icon click handler
    const cartIcon = document.querySelector('button.relative[onclick]');
    if (cartIcon) {
        cartIcon.addEventListener('click', function (e) {
            e.preventDefault();
            if (typeof openCart === 'function') {
                openCart();
            } else {
                // Fallback: redirect to cart page
                window.location.href = baseUrl + 'includes/cart-drawer.php';
            }
        });
    }
}

// Call this in your DOMContentLoaded
document.addEventListener('DOMContentLoaded', function () {
    // ... your existing code ...
    initializeCart();
});




// Toast Notification System
function showToast(message, type = 'success', duration = 3000) {
    let container = document.getElementById('toastContainer');
    
    // Create container if it doesn't exist
    if (!container) {
        container = document.createElement('div');
        container.id = 'toastContainer';
        container.className = 'fixed bottom-8 left-1/2 transform -translate-x-1/2 z-[60] flex flex-col items-center gap-3 pointer-events-none';
        document.body.appendChild(container);
    }

    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast-notification pointer-events-auto transform transition-all duration-300 ease-out opacity-0 translate-y-4 ${
        type === 'success' ? 'bg-green-600' : (type === 'info' ? 'bg-blue-600' : 'bg-red-600')
    } text-white px-6 py-4 rounded-lg shadow-2xl flex items-center gap-3 min-w-[300px] max-w-md`;

    // Icon based on type
    let icon = '';
    if (type === 'success') {
        icon = `<svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
    } else if (type === 'info') {
        icon = `<svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
    } else {
        icon = `<svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>`;
    }

    toast.innerHTML = `
        ${icon}
        <span class="flex-1 font-medium">${message}</span>
        <button onclick="this.parentElement.remove()" class="hover:bg-white hover:bg-opacity-20 rounded p-1 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    `;

    container.appendChild(toast);

    // Trigger animation
    setTimeout(() => {
        toast.classList.remove('opacity-0', 'translate-y-4');
    }, 10);

    // Auto remove after duration
    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-4');
        setTimeout(() => toast.remove(), 300);
    }, duration);
}

// Make showToast globally available
window.showToast = showToast;
