(function () {
  const root = document.documentElement;
  const cursor = document.querySelector(".cursor-ring");
  const heroBackdrop = document.querySelector(".hero-backdrop");
  const revealItems = document.querySelectorAll("[data-reveal]");
  const navToggle = document.querySelector(".nav-toggle");
  const mobileMenu = document.querySelector("#mobile-menu");
  const mobileLinks = document.querySelectorAll(".mobile-nav a");
  const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  const coarsePointer = window.matchMedia("(pointer: coarse)").matches;

  if (navToggle && mobileMenu) {
    const closeMenu = function () {
      navToggle.setAttribute("aria-expanded", "false");
      mobileMenu.hidden = true;
      document.body.classList.remove("menu-open");
    };

    navToggle.addEventListener("click", function () {
      const isOpen = navToggle.getAttribute("aria-expanded") === "true";
      navToggle.setAttribute("aria-expanded", String(!isOpen));
      mobileMenu.hidden = isOpen;
      document.body.classList.toggle("menu-open", !isOpen);
    });

    mobileLinks.forEach(function (link) {
      link.addEventListener("click", closeMenu);
    });

    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape") {
        closeMenu();
      }
    });

    document.addEventListener("click", function (event) {
      const isOpen = navToggle.getAttribute("aria-expanded") === "true";

      if (!isOpen) {
        return;
      }

      const clickedInsideMenu = mobileMenu.contains(event.target);
      const clickedToggle = navToggle.contains(event.target);

      if (!clickedInsideMenu && !clickedToggle) {
        closeMenu();
      }
    });

    window.addEventListener("resize", function () {
      if (window.innerWidth > 960) {
        closeMenu();
      }
    });
  }

  if (!coarsePointer && !reducedMotion && cursor) {
    let cursorX = window.innerWidth / 2;
    let cursorY = window.innerHeight / 2;
    let currentX = cursorX;
    let currentY = cursorY;

    window.addEventListener("mousemove", function (event) {
      cursorX = event.clientX;
      cursorY = event.clientY;
      cursor.classList.add("is-active");
    });

    window.addEventListener("mouseleave", function () {
      cursor.classList.remove("is-active");
    });

    const animateCursor = function () {
      currentX += (cursorX - currentX) * 0.18;
      currentY += (cursorY - currentY) * 0.18;
      cursor.style.transform = "translate(" + currentX + "px, " + currentY + "px)";
      window.requestAnimationFrame(animateCursor);
    };

    animateCursor();
  } else if (cursor) {
    cursor.remove();
  }

  if (!reducedMotion && heroBackdrop) {
    let ticking = false;

    const updateParallax = function () {
      const scrollY = window.scrollY || window.pageYOffset;
      root.style.setProperty("--hero-parallax", (scrollY * 0.12).toFixed(2) + "px");
      ticking = false;
    };

    const requestParallaxUpdate = function () {
      if (!ticking) {
        ticking = true;
        window.requestAnimationFrame(updateParallax);
      }
    };

    updateParallax();
    window.addEventListener("scroll", requestParallaxUpdate, { passive: true });
  }

  if ("IntersectionObserver" in window && !reducedMotion) {
    const observer = new IntersectionObserver(function (entries, io) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-visible");
          io.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.16,
      rootMargin: "0px 0px -40px 0px"
    });

    revealItems.forEach(function (item) {
      observer.observe(item);
    });
  } else {
    revealItems.forEach(function (item) {
      item.classList.add("is-visible");
    });
  }
}());
