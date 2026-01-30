// Initialize Icons
lucide.createIcons();

// Sticky CTA Visibility
const stickyCta = document.querySelector(".sticky-cta");
window.addEventListener("scroll", () => {
  if (window.scrollY > 500) {
    stickyCta.classList.add("visible");
  } else {
    stickyCta.classList.remove("visible");
  }
});

// Smooth Scroll
document.querySelectorAll(".scroll-to-form").forEach((btn) => {
  btn.addEventListener("click", (e) => {
    e.preventDefault();
    document.querySelector("#contact").scrollIntoView({ behavior: "smooth" });
  });
});


