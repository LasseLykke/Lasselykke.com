window.onload = function () {
    // Mobile menu toggle
    const menu_btn = document.querySelector(".hamburger");
    const mobile_menu = document.querySelector(".mobile-nav");

    if (menu_btn && mobile_menu) {
        menu_btn.addEventListener("click", function () {
            menu_btn.classList.toggle("is-active");
            mobile_menu.classList.toggle("is-active");
        });
    }

    // Dark mode toggle
    const toggleButton = document.getElementById("theme-toggle");

    if (toggleButton) {  // Undgå fejl hvis knappen mangler
        const currentTheme = localStorage.getItem("theme") || "light";
        document.documentElement.setAttribute("data-theme", currentTheme);
        toggleButton.textContent = currentTheme === "dark" ? "☀️" : "🌙";

        toggleButton.addEventListener("click", () => {
            const newTheme = document.documentElement.getAttribute("data-theme") === "dark" ? "light" : "dark";
            document.documentElement.setAttribute("data-theme", newTheme);
            localStorage.setItem("theme", newTheme);
            toggleButton.textContent = newTheme === "dark" ? "☀️" : "🌙";
        });
    }
};
