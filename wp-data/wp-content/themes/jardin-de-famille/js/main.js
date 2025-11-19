document.addEventListener("DOMContentLoaded", () => {
  /* ---------------------------
       Navigation scroll effect
    --------------------------- */
  const navbar = document.getElementById("navbar");
  window.addEventListener("scroll", () => {
    if (window.scrollY > 100) {
      navbar.classList.add("scrolled");
    } else {
      navbar.classList.remove("scrolled");
    }
  });

  /* ---------------------------
       Menu hamburger mobile
    --------------------------- */
  const navToggle = document.querySelector(".nav-toggle");
  const navMenu = document.querySelector(".nav-menu");

  if (navToggle) {
    navToggle.addEventListener("click", () => {
      const isExpanded = navToggle.getAttribute("aria-expanded") === "true";
      navToggle.setAttribute("aria-expanded", !isExpanded);
      navToggle.classList.toggle("active");
      navMenu.classList.toggle("active");
    });

    // Fermer le menu en cliquant sur un lien
    const navLinks = document.querySelectorAll(".nav-menu a");
    navLinks.forEach((link) => {
      link.addEventListener("click", () => {
        navToggle.setAttribute("aria-expanded", "false");
        navToggle.classList.remove("active");
        navMenu.classList.remove("active");
      });
    });
  }

  /* ---------------------------
       Smooth scrolling pour les liens d'ancre
    --------------------------- */
  const anchorLinks = document.querySelectorAll('a[href^="#"]');
  anchorLinks.forEach((anchor) => {
    anchor.addEventListener("click", (e) => {
      e.preventDefault();
      const targetId = anchor.getAttribute("href");
      const target = document.querySelector(targetId);
      if (target) {
        target.scrollIntoView({
          behavior: "smooth",
          block: "start",
        });
      }
    });
  });

  /* ---------------------------
       Animation au scroll (IntersectionObserver)
    --------------------------- */
  const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = "1";
        entry.target.style.transform = "translateY(0)";
      }
    });
  }, observerOptions);

  const animatedElements = document.querySelectorAll(
    ".service-card, .gallery-item"
  );
  animatedElements.forEach((el) => {
    el.style.opacity = "0";
    el.style.transform = "translateY(30px)";
    el.style.transition = "all 0.6s ease-out";
    observer.observe(el);
  });

  /* ---------------------------
       Lightbox/Modal pour la galerie
    --------------------------- */
  const modal = document.getElementById("gallery-modal");
  const modalImg = document.getElementById("gallery-modal-img");
  const closeBtn = document.querySelector(".gallery-modal-close");
  const prevBtn = document.querySelector(".gallery-modal-prev");
  const nextBtn = document.querySelector(".gallery-modal-next");
  const galleryItems = document.querySelectorAll(".gallery-item");

  let currentIndex = 0;
  let galleryImages = [];

  // Collecter toutes les images
  galleryItems.forEach((item, index) => {
    const img = item.querySelector(".gallery-item-img");
    if (img) {
      galleryImages.push({
        url: img.getAttribute("data-full-url") || img.src,
        alt: img.alt,
      });

      // Clic sur une image pour ouvrir la modal
      item.addEventListener("click", () => {
        currentIndex = index;
        openModal();
      });
    }
  });

  function openModal() {
    if (galleryImages[currentIndex]) {
      modalImg.src = galleryImages[currentIndex].url;
      modalImg.alt = galleryImages[currentIndex].alt;
      modal.classList.add("active");
      document.body.style.overflow = "hidden"; // Bloquer le scroll
    }
  }

  function closeModal() {
    modal.classList.remove("active");
    document.body.style.overflow = ""; // Rétablir le scroll
  }

  function showNext() {
    currentIndex = (currentIndex + 1) % galleryImages.length;
    openModal();
  }

  function showPrev() {
    currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length;
    openModal();
  }

  // Événements
  closeBtn.addEventListener("click", closeModal);
  prevBtn.addEventListener("click", showPrev);
  nextBtn.addEventListener("click", showNext);

  // Fermer en cliquant sur le fond
  modal.addEventListener("click", (e) => {
    if (e.target === modal) {
      closeModal();
    }
  });

  // Navigation au clavier
  document.addEventListener("keydown", (e) => {
    if (!modal.classList.contains("active")) return;

    if (e.key === "Escape") closeModal();
    if (e.key === "ArrowRight") showNext();
    if (e.key === "ArrowLeft") showPrev();
  });
});
