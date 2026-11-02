/**
 * =====================================================================
 * RESERVIN — SCRIPT GLOBAL CUSTOMER (customer/js/customer.js)
 * Mengatur interaktivitas & animasi global customer:
 * 1. Buka/Tutup Sidebar Menu Customer (Mobile)
 * 2. Klik Overlay & Tombol Silang (Tutup)
 * 3. Penanganan Tombol Escape & Resize Window
 * 4. Efek Ripple Wave & Tactile Feedback Saat Tombol Ditekan
 * =====================================================================
 */

(function () {
    "use strict";

    const body    = document.body;
    const burger  = document.getElementById("cmBurger");
    const overlay = document.getElementById("cmOverlay");
    const tutup   = document.getElementById("cmTutup");

    /**
     * Mengatur status buka/tutup sidebar customer
     * @param {boolean} buka
     */
    function aturSidebar(buka) {
        body.classList.toggle("cm-open", buka);
        if (burger) {
            burger.setAttribute("aria-expanded", buka ? "true" : "false");
            burger.setAttribute("aria-label", buka ? "Tutup menu" : "Buka menu");
        }
    }

    if (burger) {
        burger.addEventListener("click", function () {
            aturSidebar(!body.classList.contains("cm-open"));
        });
    }

    if (overlay) {
        overlay.addEventListener("click", function () {
            aturSidebar(false);
        });
    }

    if (tutup) {
        tutup.addEventListener("click", function () {
            aturSidebar(false);
        });
    }

    // Tombol Escape menutup sidebar
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && body.classList.contains("cm-open")) {
            aturSidebar(false);
        }
    });

    // Otomatis menutup sidebar jika layar diperbesar ke mode desktop (> 900px)
    window.addEventListener("resize", function () {
        if (window.innerWidth > 900 && body.classList.contains("cm-open")) {
            aturSidebar(false);
        }
    });

    /**
     * EFEK RIPPLE WAVE & TACTILE FEEDBACK INTERAKTIF
     * Memicu gelombang animasi saat tombol ditekan di seluruh halaman customer
     */
    function inisialisasiEfekTombol() {
        document.addEventListener("pointerdown", function (e) {
            const btn = e.target.closest(
                "button, .btn, .btn-cta, .btn-booking, .modal-btn, .cancel-btn, " +
                ".rv-btn, .add, .btn-line, .schedule-btn, .pilih, .rv-ganti, " +
                ".date:not(.off):not(.kosong), .time:not(.off), .rv-tab, .cm-burger"
            );

            if (!btn || btn.disabled || btn.classList.contains("off")) return;

            const style = window.getComputedStyle(btn);
            if (style.position === "static") {
                btn.style.position = "relative";
            }
            if (style.overflow !== "hidden") {
                btn.style.overflow = "hidden";
            }

            const rect = btn.getBoundingClientRect();
            const diameter = Math.max(rect.width, rect.height) * 1.2;
            const radius = diameter / 2;

            const ripple = document.createElement("span");
            ripple.className = "cm-ripple";

            // Deteksi warna latar belakang tombol untuk menentukan kontras ripple
            const bg = style.backgroundColor;
            if (
                bg.includes("255, 255, 255") ||
                bg.includes("transparent") ||
                bg === "rgba(0, 0, 0, 0)" ||
                btn.classList.contains("batal") ||
                btn.classList.contains("cancel-btn")
            ) {
                ripple.classList.add("cm-ripple-dark");
            }

            ripple.style.width  = diameter + "px";
            ripple.style.height = diameter + "px";
            ripple.style.left   = (e.clientX - rect.left - radius) + "px";
            ripple.style.top    = (e.clientY - rect.top - radius) + "px";

            // Bersihkan ripple lama jika ada
            const rippleLama = btn.querySelector(".cm-ripple");
            if (rippleLama) rippleLama.remove();

            btn.appendChild(ripple);

            setTimeout(function () {
                ripple.remove();
            }, 600);
        });
    }

    inisialisasiEfekTombol();

    // Aktifkan animasi transisi setelah halaman siap
    requestAnimationFrame(function () {
        requestAnimationFrame(function () {
            body.classList.add("cm-ready");
        });
    });

})();

