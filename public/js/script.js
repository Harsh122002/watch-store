// Logo animation
gsap.fromTo(
    ".logo",
    { opacity: 0, y: -30, scale: 0.8 },
    { opacity: 1, y: 0, scale: 1, duration: 4 }
);

// Menu, Cart, and Login image animation with stagger effect
gsap.fromTo(
    ".menu img, .cart img, .login img,.username,.cart sup",
    { opacity: 0, x: 50 },
    { opacity: 1, x: 0, duration: 5, stagger: 0.2 }
);

// Change background color of nav over 5 seconds
gsap.to(".nav", { duration: 5 });

// Toggle dropdown menu content with GSAP animation and stagger effect
document.getElementById("menu-toggle").addEventListener("click", function () {
    const dropdown = document.getElementById("dropdown-content");
    const items = dropdown.querySelectorAll("a");

    if (dropdown.classList.contains("show")) {
        gsap.to(items, {
            opacity: 0,
            y: 10,
            duration: 0.5,
            stagger: 0.2,
            ease: "power.out",
            onComplete: function () {
                dropdown.classList.remove("show");
                dropdown.style.display = "none";
            },
        });
    } else {
        dropdown.style.display = "block";
        gsap.fromTo(
            items,
            { opacity: 0, y: -10 },
            {
                opacity: 1,
                x: 2,
                duration: 0.5,
                stagger: 0.2,
                ease: "power.out",
                onComplete: function () {
                    dropdown.classList.add("show");
                },
            }
        );
    }
});
document.addEventListener("DOMContentLoaded", function () {
    gsap.from(".product-heading", {
        opacity: 0,
        y: -50,
        duration: 2,
        ease: "power2.out",
    });

    gsap.from("#search-bar", {
        opacity: 0,
        x: -50,
        duration: 2,
        ease: "power2.in",
    });
    // GSAP animation for product items
    gsap.from(".product", {
        opacity: 0,
        y: 50,
        duration: 1,
        ease: "power2.out",
        stagger: 0.8,
    });
});
