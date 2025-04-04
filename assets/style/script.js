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

    if (toggleButton) {
        const prefersDark = window.matchMedia("(prefers-color-scheme: dark)");

        // Funktion til at sætte tema og opdatere knap
        function setTheme(theme, save = false) {
            document.documentElement.setAttribute("data-theme", theme);
            toggleButton.textContent = theme === "dark" ? "☀️" : "🌙";
            if (save) localStorage.setItem("theme", theme);
        }

        // Vælg tema ud fra localStorage eller system præference
        let storedTheme = localStorage.getItem("theme");
        if (storedTheme) {
            setTheme(storedTheme);
        } else {
            setTheme(prefersDark.matches ? "dark" : "light");
        }

        // Lyt efter ændringer i systemindstillinger
        prefersDark.addEventListener("change", (e) => {
            const newTheme = e.matches ? "dark" : "light";

            // Kun ændr tema hvis brugeren ikke selv har valgt noget
            if (!localStorage.getItem("theme")) {
                setTheme(newTheme);
            }
        });

        // Håndter klik på knappen
        toggleButton.addEventListener("click", () => {
            const current = document.documentElement.getAttribute("data-theme");
            const newTheme = current === "dark" ? "light" : "dark";
            setTheme(newTheme, true); // gem brugerens valg
        });
    }
};
