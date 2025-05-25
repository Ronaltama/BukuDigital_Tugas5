document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.getElementById("sidebar");
  const sidebarToggle = document.getElementById("sidebar-toggle");
  const sidebarOverlay = document.getElementById("sidebar-overlay");
  const closeSidebar = document.getElementById("close-sidebar");

  // Toggle sidebar
  sidebarToggle.addEventListener("click", function (e) {
    e.preventDefault();
    sidebar.classList.toggle("active");
    sidebarOverlay.classList.toggle("active");
  });

  // Close sidebar
  function closeSidebarFunc() {
    sidebar.classList.remove("active");
    sidebarOverlay.classList.remove("active");
  }

  // Close handlers
  sidebarOverlay.addEventListener("click", closeSidebarFunc);
  closeSidebar.addEventListener("click", closeSidebarFunc);

  // Close on resize if desktop
  window.addEventListener("resize", function () {
    if (window.innerWidth >= 992) {
      closeSidebarFunc();
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {
  // Animasi Scroll
  const animateOnScroll = () => {
    const elements = document.querySelectorAll(
      ".fade-in, .section-title, .book-card"
    );
    elements.forEach((element) => {
      const elementTop = element.getBoundingClientRect().top;
      const elementBottom = element.getBoundingClientRect().bottom;

      if (elementTop < window.innerHeight && elementBottom > 0) {
        element.style.opacity = "1";
        element.style.transform = "translateY(0)";
      }
    });
  };

  // Inisialisasi animasi
  window.addEventListener("scroll", animateOnScroll);
  animateOnScroll(); // Trigger awal

  // Hover effect untuk card buku
  document.querySelectorAll(".book-card").forEach((card) => {
    card.addEventListener("mouseenter", function () {
      this.style.transform = "translateY(-10px) scale(1.02)";
    });

    card.addEventListener("mouseleave", function () {
      this.style.transform = "translateY(0) scale(1)";
    });
  });

  // Animasi untuk tombol
  document.querySelectorAll(".btn").forEach((button) => {
    button.addEventListener("mouseenter", function () {
      this.style.transform = "scale(1.05)";
    });

    button.addEventListener("mouseleave", function () {
      this.style.transform = "scale(1)";
    });
  });

  // Smooth scroll untuk navigasi
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute("href"));
      if (target) {
        target.scrollIntoView({
          behavior: "smooth",
          block: "start",
        });
      }
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  // Scroll horizontal dengan tombol
  const scrollContainers = document.querySelectorAll(".scroll-container");

  scrollContainers.forEach((container) => {
    const scrollLeftBtn =
      container.parentElement.querySelector(".scroll-btn.left");
    const scrollRightBtn =
      container.parentElement.querySelector(".scroll-btn.right");

    const scrollAmount = 300; // Jarak scroll per klik

    // Fungsi untuk tombol kiri
    scrollLeftBtn.addEventListener("click", () => {
      container.scrollBy({ left: -scrollAmount, behavior: "smooth" });
    });

    // Fungsi untuk tombol kanan
    scrollRightBtn.addEventListener("click", () => {
      container.scrollBy({ left: scrollAmount, behavior: "smooth" });
    });

    // Sembunyikan tombol saat di ujung scroll
    const checkScroll = () => {
      scrollLeftBtn.style.display = container.scrollLeft > 0 ? "block" : "none";
      scrollRightBtn.style.display =
        container.scrollLeft + container.clientWidth < container.scrollWidth
          ? "block"
          : "none";
    };

    // Event listener untuk update tombol
    container.addEventListener("scroll", checkScroll);
    window.addEventListener("resize", checkScroll);
    checkScroll();
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const header = document.querySelector("header");
  const nav = document.querySelector("nav");
  const main = document.querySelector("main");

  const headerHeight = header.offsetHeight;
  const navHeight = nav.offsetHeight;
  const totalHeight = headerHeight + navHeight;

  main.style.marginTop = `${totalHeight}px`;
});

let lastScroll = 0;
const navbar = document.getElementById("mainNav");

window.addEventListener("scroll", () => {
  const currentScroll = window.pageYOffset;

  if (currentScroll > lastScroll && currentScroll > 100) {
    navbar.classList.add("navbar-hidden");
  } else {
    navbar.classList.remove("navbar-hidden");
  }
  lastScroll = currentScroll;
});
