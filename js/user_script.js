document.addEventListener("DOMContentLoaded", () => {
    // Initialize variables
    const userBtn = document.getElementById("user-btn");
    const searchBtn = document.getElementById("search-btn");
    const menuBtn = document.getElementById("menu-btn");
    const popup = document.getElementById("profilePopup");
    const profile = document.querySelector('.profile'); // Added this missing variable
    let searchForm = document.querySelector('.header .flex .search-form');
    let navbar = document.querySelector('.header .flex .navbar'); // More specific selector

    // Check if elements exist before adding event listeners
    if (userBtn && popup) {
        userBtn.addEventListener("click", (e) => {
            e.stopPropagation(); // Prevent event bubbling
            popup.classList.toggle("active");
            // Close other open elements
            if (searchForm) searchForm.classList.remove("active");
            if (navbar) navbar.classList.remove("active");
        });
    }

    if (searchBtn && searchForm) {
        searchBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            searchForm.classList.toggle("active");
            // Close other open elements
            if (popup) popup.classList.remove("active");
            if (navbar) navbar.classList.remove("active");
        });
    }

    if (menuBtn && navbar) {
        menuBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            navbar.classList.toggle("active");
            // Close other open elements
            if (popup) popup.classList.remove("active");
            if (searchForm) searchForm.classList.remove("active");
        });
    }

    // Close popups when clicking outside
    document.addEventListener("click", (e) => {
        if (popup && popup.classList.contains('active')) {
            if (!userBtn.contains(e.target) && !popup.contains(e.target)) {
                popup.classList.remove("active");
            }
        }
        
        if (searchForm && searchForm.classList.contains('active')) {
            if (!searchBtn.contains(e.target) && !searchForm.contains(e.target)) {
                searchForm.classList.remove("active");
            }
        }
        
        if (navbar && navbar.classList.contains('active')) {
            if (!menuBtn.contains(e.target) && !navbar.contains(e.target)) {
                navbar.classList.remove("active");
            }
        }
    });

    // Close on escape key
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            if (popup) popup.classList.remove("active");
            if (searchForm) searchForm.classList.remove("active");
            if (navbar) navbar.classList.remove("active");
        }
    });

    // Slider script (only initialize if slides exist)
    const slides = document.querySelectorAll('.slideBox');
    let currentSlide = 0;

    if (slides.length > 0) {
        // Initialize first slide
        slides[currentSlide].classList.add('active');

        // Auto slide (optional)
        setInterval(() => {
            nextSlide();
        }, 5000);
    }

    function nextSlide() {
        if (slides.length === 0) return;
        
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
    }

    function prevSlide() {
        if (slides.length === 0) return;
        
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        slides[currentSlide].classList.add('active');
    }

    
    window.nextSlide = nextSlide;
    window.prevSlide = prevSlide;
});