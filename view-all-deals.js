function toggleMenu() {
    console.log("Toggle Menu Clicked"); // Debugging line
    const menuContainer = document.getElementById("menu-container");
    if (menuContainer.style.right === "0px") {
      menuContainer.style.right = "-250px"; // Hide the menu
      console.log("Menu Hidden"); // Debugging line
    } else {
      menuContainer.style.right = "0px"; // Show the menu
      console.log("Menu Shown"); // Debugging line
    }
  }
  
  // Close menu when close button is clicked
  document.querySelector('.close-button').addEventListener('click', toggleMenu);
  
  // Ensure the menu is closed by default on mobile
  window.onload = function() {
    const menuContainer = document.getElementById("menu-container");
    if (window.innerWidth <= 768) {
      menuContainer.style.right = "-250px"; // Close the menu on mobile
    }
  };
  
  // Toggle the slide-out menu
  function toggleMenu() {
    const menuContainer = document.getElementById("menu-container");
    menuContainer.style.right = menuContainer.style.right === "0px" ? "-250px" : "0px";
  }
  
  // Ensure the close button triggers the menu toggle
  document.querySelector('.menu-close').addEventListener('click', toggleMenu);
  