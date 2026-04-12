// Dark mode
function toggleDarkMode() {
  document.body.classList.toggle("dark-mode");
}

// Typing effect
let text = "Hi, I'm Rithika 👩‍💻";
let index = 0;

function typeEffect() {
  if (index < text.length) {
    document.getElementById("typing").innerHTML += text.charAt(index);
    index++;
    setTimeout(typeEffect, 100);
  }
}
window.onload = typeEffect;

// Success message
const params = new URLSearchParams(window.location.search);
if (params.get("success")) {
  document.getElementById("success-msg").innerText = "Message sent successfully!";
}

// Project filter
function filterProjects(category) {
  let cards = document.querySelectorAll(".project-card");

  cards.forEach(card => {
    if (category === "all" || card.classList.contains(category)) {
      card.style.display = "block";
    } else {
      card.style.display = "none";
    }
  });
}

// Scroll animation
window.addEventListener("scroll", () => {
  document.querySelectorAll("section").forEach(el => {
    if (el.getBoundingClientRect().top < window.innerHeight - 100) {
      el.classList.add("show");
    }
  });
});
