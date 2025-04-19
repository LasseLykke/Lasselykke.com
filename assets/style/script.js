document.addEventListener("DOMContentLoaded", () => {
  // HAMBURGER TOGGLE
  const hamburger = document.getElementById("hamburger-btn");
  const mobileNav = document.getElementById("mobile-nav");

  if (hamburger && mobileNav) {
    hamburger.addEventListener("click", () => {
      hamburger.classList.toggle("is-active");
      mobileNav.classList.toggle("open");
      document.body.classList.toggle("no-scroll");
    });
  }

  // HIDE HEADER ON SCROLL
  let lastScrollTop = 0;
  const header = document.getElementById("main-header");

  if (header) {
    window.addEventListener("scroll", () => {
      const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

      if (scrollTop > lastScrollTop && scrollTop > 50) {
        header.classList.add("header-hidden");
      } else {
        header.classList.remove("header-hidden");
      }

      lastScrollTop = Math.max(scrollTop, 0);
    });
  }

  // DARK MODE TOGGLE
  const toggleButton = document.getElementById("theme-toggle");
  const themeIcon = document.getElementById("theme-icon");

  if (toggleButton && themeIcon) {
    const prefersDark = window.matchMedia("(prefers-color-scheme: dark)");

    function setTheme(theme, save = false) {
      document.documentElement.setAttribute("data-theme", theme);
      themeIcon.innerText = theme === "dark" ? "light_mode" : "dark_mode";
      if (save) localStorage.setItem("theme", theme);
    }

    const storedTheme = localStorage.getItem("theme");
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
      setTheme(current === "dark" ? "light" : "dark", true);
    });
  }

  // PROGRESS BARS
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
            const speed = 500;

            const updateCount = () => {
              const increment = Math.ceil(target / 100);
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
