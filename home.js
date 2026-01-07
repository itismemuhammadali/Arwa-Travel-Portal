// Select carousel and dots container
const carousel = document.querySelector(".carousel");
const dotsContainer = document.querySelector(".carousel-dots");
const totalSlides = parseInt(carousel.getAttribute("data-card-count")) || 0; // Get total slides or set default to 0
let currentSlide = 0; // Current slide index

// Initialize carousel dots and event listeners if there are slides
if (totalSlides > 0) {
    for (let i = 0; i < totalSlides; i++) {
        const dot = document.createElement("span");
        dot.classList.add("dot");
        if (i === 0) dot.classList.add("active"); // Activate first dot by default
        dot.addEventListener("click", () => setSlide(i)); // Set event listener for each dot
        dotsContainer.appendChild(dot);
    }
}

// Function to update carousel display based on the current slide index
function setSlide(index) {
    currentSlide = index; // Update the current slide index
    carousel.style.transform = `translateX(${-currentSlide * 117}%)`; // Slide to the correct card

    // Update active dot
    const dots = document.querySelectorAll(".dot");
    dots.forEach((dot, i) => dot.classList.toggle("active", i === currentSlide));
}

// Auto-scroll setup
let autoScroll = setInterval(nextSlide, 3000); // Change slide every 3 seconds

// Move to the next slide in a loop
function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    setSlide(currentSlide);
}

// Pause auto-scroll on hover
carousel.addEventListener("mouseenter", () => clearInterval(autoScroll));
carousel.addEventListener("mouseleave", () => {
    autoScroll = setInterval(nextSlide, 3000);
});

// Toggle the mobile slide-out menu
function toggleMenu() {
    const menuContainer = document.getElementById("menu-container");
    menuContainer.style.right = menuContainer.style.right === "0px" ? "-250px" : "0px";
}

// Ensure the menu is closed by default on mobile view on page load
window.onload = function() {
    const menuContainer = document.getElementById("menu-container");
    if (window.innerWidth <= 768) {
        menuContainer.style.right = "-250px";
    }
};
