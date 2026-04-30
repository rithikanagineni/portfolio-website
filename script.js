// Welcome alert when page loads
document.addEventListener("DOMContentLoaded", () => {
  alert("Welcome to Rithika's Portfolio!");
});

// Project links - Only show alert for project cards without real links
document.querySelectorAll(".project-card a").forEach(link => {
  // If the link goes to allproject.html, let it work normally
  if (link.getAttribute("href") === "allproject.html") {
    return; // Skip this link, let it work normally
  }
  
  // For other project links, show the alert
  link.addEventListener("click", (e) => {
    e.preventDefault();
    alert("This project will be added soon!");
  });
});

// Typing Animation
const typingElement = document.getElementById("typing");
const text = "Welcome to Rithika's Portfolio";
let index = 0;

function typeEffect() {
  if (index < text.length) {
    typingElement.textContent += text.charAt(index);
    index++;
    setTimeout(typeEffect, 100);
  }
}
typeEffect();

// Dark Mode Toggle
const darkModeToggle = document.getElementById("darkModeToggle");
darkModeToggle.addEventListener("click", () => {
  document.body.classList.toggle("dark-mode");
});

// Project Filtering
const filterButtons = document.querySelectorAll(".filter-buttons button");
const projectCards = document.querySelectorAll(".project-card");

filterButtons.forEach(button => {
  button.addEventListener("click", () => {
    const filter = button.getAttribute("data-filter");
    projectCards.forEach(card => {
      if (filter === "all" || card.getAttribute("data-category") === filter) {
        card.style.display = "block";
      } else {
        card.style.display = "none";
      }
    });
  });
});

// Contact form validation - UPDATED FOR AJAX
document.getElementById("contactForm").addEventListener("submit", function(event) {
    event.preventDefault();
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const message = document.getElementById("message").value.trim();

    if (name === "" || email === "" || message === "") {
        alert("❌ Please fill in all fields.");
        return;
    }

    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    if (!email.match(emailPattern)) {
        alert("❌ Please enter a valid email address.");
        return;
    }

    // Send form data using AJAX
    const formData = new FormData(this);

    fetch("contact.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.message.includes("Thank you")) {
            document.getElementById("contactForm").reset();
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("❌ An error occurred. Please try again.");
    });
});

// Back to Top Button
const backToTopBtn = document.getElementById("backToTop");
window.addEventListener("scroll", () => {
  if (window.scrollY > 200) {
    backToTopBtn.style.display = "block";
  } else {
    backToTopBtn.style.display = "none";
  }
});
backToTopBtn.addEventListener("click", () => {
  window.scrollTo({ top: 0, behavior: "smooth" });
});

// Animate skill bars when visible
const skillBars = document.querySelectorAll(".progress-bar");
function animateSkills() {
  skillBars.forEach(bar => {
    const rect = bar.getBoundingClientRect();
    if (rect.top < window.innerHeight && rect.bottom >= 0) {
      bar.style.transition = "width 1s ease-in-out";
      bar.style.width = bar.textContent; // e.g. "90%"
    }
  });
}
window.addEventListener("scroll", animateSkills);
