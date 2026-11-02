/**
 * =====================================================================
 * RESERVIN — SCRIPT GLOBAL CUSTOMER (customer/js/customer.js)
 * Mengatur interaktivitas global customer:
 * 1. Buka/Tutup Sidebar Menu Customer
 * 2. Klik Overlay & Tombol Silang (Tutup)
 * 3. Penanganan Tombol Escape
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

    // Aktifkan animasi transisi setelah halaman siap
    requestAnimationFrame(function () {
        requestAnimationFrame(function () {
            body.classList.add("cm-ready");
        });
    });

})();

