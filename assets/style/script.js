window.onload = function () {
  const menu_btn = document.querySelector(".hamburger");
  const mobile_menu = document.querySelector(".mobile-nav");
  const header = document.querySelector("header");

  const isMobile = window.innerWidth <= 768;
  const threshold = isMobile ? 20 : 20;
  const delay = 100;

  if (menu_btn && mobile_menu) {
    menu_btn.addEventListener("click", function () {
      menu_btn.classList.toggle("is-active");
      mobile_menu.classList.toggle("is-active");
    });
  }

  // Her er den fungerende scroll-del – nu korrekt placeret
  let lastScrollY = window.scrollY;
  let scrollTimeout;
  let isScrollingDown = false;

  window.addEventListener("scroll", () => {
    const currentScrollY = window.scrollY;
    const scrollDiff = currentScrollY - lastScrollY;

    if (Math.abs(scrollDiff) > threshold) {
      if (scrollDiff > 0) {
        // Scroller ned
        header.classList.add("hide-on-scroll");
        isScrollingDown = true;
        clearTimeout(scrollTimeout);
      } else {
        // Scroller op
        if (isScrollingDown) {
          clearTimeout(scrollTimeout);
          scrollTimeout = setTimeout(() => {
            header.classList.remove("hide-on-scroll");
            isScrollingDown = false;
          }, delay);
        }
      }

      lastScrollY = currentScrollY;
    }
  });


  // Dark mode toggle
  const toggleButton = document.getElementById("theme-toggle");
  const themeIcon = document.getElementById("theme-icon");

  if (toggleButton && themeIcon) {
    const prefersDark = window.matchMedia("(prefers-color-scheme: dark)");

    function setTheme(theme, save = false) {
      document.documentElement.setAttribute("data-theme", theme);
      themeIcon.innerText = theme === "dark" ? "light_mode" : "dark_mode";
      if (save) localStorage.setItem("theme", theme);
    }

    let storedTheme = localStorage.getItem("theme");
    if (storedTheme) {
      setTheme(storedTheme);
    } else {
      setTheme(prefersDark.matches ? "dark" : "light");
    }

    prefersDark.addEventListener("change", (e) => {
      if (!localStorage.getItem("theme")) {
        setTheme(e.matches ? "dark" : "light");
      }
    });

    toggleButton.addEventListener("click", () => {
      const current = document.documentElement.getAttribute("data-theme");
      const newTheme = current === "dark" ? "light" : "dark";
      setTheme(newTheme, true);
    });
  }
};

// Lytter til procent i progress-bar
document.addEventListener("DOMContentLoaded", () => {
  const observer = new IntersectionObserver(
    (entries, obs) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const bars = entry.target.querySelectorAll(".progress-bar");
          const percents = entry.target.querySelectorAll(".percent");

          bars.forEach((bar) => {
            const percent = bar.getAttribute("data-percent");
            bar.style.width = percent + "%";
          });

          percents.forEach((percentEl) => {
            const target = +percentEl.getAttribute("data-target");
            let count = 0;
            const speed = 500; // lavere = hurtigere

            const updateCount = () => {
              const increment = Math.ceil(target / 100); // juster for smoothness
              count += increment;

              if (count >= target) {
                percentEl.textContent = target + "%";
              } else {
                percentEl.textContent = count + "%";
                requestAnimationFrame(updateCount);
              }
            };

            updateCount();
          });

          obs.unobserve(entry.target);
        }
      });
    },
    {
      threshold: 0.4,
    }
  );

  const wrapper = document.querySelector(".lazy-progress");
  if (wrapper) {
    observer.observe(wrapper);
  }
});
