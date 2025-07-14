// Mobile nav

const hamburgerBtn = document.getElementById("hamburgerBtn");
const closeBtn = document.getElementById("closeBtn");
const mobileMenu = document.getElementById("mobileMenu");
const mobileDropdownBtn = document.getElementById("mobileDropdownBtn");
const mobileDropdown = document.getElementById("mobileDropdown");

hamburgerBtn.addEventListener(
    "click",
    () => (mobileMenu.style.height = "100%")
);
closeBtn.addEventListener("click", () => {
    mobileMenu.style.height = "0%";
    mobileDropdown.classList.add("hidden");
});
mobileDropdownBtn.addEventListener("click", () =>
    mobileDropdown.classList.toggle("hidden")
);

// Scroll animation
const observer = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add("in-view");
            }
        });
    },
    {
        threshold: 0.1,
    }
);

document
    .querySelectorAll(".fade-top, .fade-left, .fade-right, .fade-bottom")
    .forEach((el) => {
        observer.observe(el);
    });

// Image modal functions
function openImageModal(src) {
    const modal = document.getElementById("imageModal");
    const modalImage = document.getElementById("modalImage");
    modalImage.src = src;
    modal.classList.remove("hidden");
    document.body.style.overflow = "hidden";
}

function closeImageModal() {
    const modal = document.getElementById("imageModal");
    modal.classList.add("hidden");
    document.body.style.overflow = "auto";
}

// Close modal when clicking outside the image
document.getElementById("imageModal").addEventListener("click", (e) => {
    if (e.target.id === "imageModal") {
        closeImageModal();
    }
});

// Reservation form handles
function openForm(date, time) {
    document.getElementById("formDate").value = date;
    document.getElementById("formTime").value = time;
    document.getElementById("contactForm").classList.remove("hidden");
    document.getElementById("contactForm").classList.add("flex");
}

function closeForm() {
    document.getElementById("contactForm").classList.add("hidden");
    document.getElementById("contactForm").classList.remove("flex");
}
