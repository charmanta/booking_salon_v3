/**
 * =====================================================================
 * RESERVIN — ADMIN SCRIPT UTAMA (admin/js/admin.js)
 * Mengatur interaktivitas global admin:
 * 1. Toggle Sidebar (Buka/Tutup di Mobile & Desktop)
 * 2. Simpan Preferensi Sidebar ke LocalStorage
 * 3. Menu Profil Pengguna (Dropdown Kanan Atas)
 * 4. Penanganan Tombol Escape & Resize Window
 * =====================================================================
 */

(function () {
    "use strict";

    const body = document.body;
    const burger = document.getElementById("burger");
    const overlay = document.getElementById("overlay");
    const userBtn = document.getElementById("userBtn");
    const userMenu = document.getElementById("userMenu");
    const LEBAR_DESKTOP = 1000;

    function desktop() {
        return window.innerWidth >= LEBAR_DESKTOP;
    }

    /**
     * Mengatur status sidebar buka/tutup
     * @param {boolean} buka
     * @param {boolean} simpan
     */
    function aturSidebar(buka, simpan) {
        body.classList.toggle("sb-open", buka);

        if (burger) {
            burger.setAttribute("aria-expanded", buka ? "true" : "false");
            burger.setAttribute("aria-label", buka ? "Tutup menu" : "Buka menu");
        }

        // Pilihan buka/tutup hanya diingat untuk tampilan desktop
        if (simpan && desktop()) {
            try {
                localStorage.setItem("adminSidebar", buka ? "1" : "0");
            } catch (e) {
                /* abaikan jika localStorage dibatasi browser */
            }
        }
    }

    // Keadaan awal sidebar: desktop terbuka (kecuali pernah ditutup), HP tertutup
    let awal = desktop();
    if (desktop()) {
        try {
            const s = localStorage.getItem("adminSidebar");
            if (s !== null) awal = s === "1";
        } catch (e) {
            /* abaikan */
        }
    }

    aturSidebar(awal, false);

    // Aktifkan animasi setelah DOM & layout selesai di-render
    requestAnimationFrame(function () {
        requestAnimationFrame(function () {
            body.classList.add("sb-ready");
        });
    });

    // Event listener burger & overlay
    if (burger) {
        burger.addEventListener("click", function () {
            aturSidebar(!body.classList.contains("sb-open"), true);
        });
    }

    if (overlay) {
        overlay.addEventListener("click", function () {
            aturSidebar(false, false);
        });
    }

    // Deteksi perubahan ukuran layar (resize)
    let sebelumnyaDesktop = desktop();
    window.addEventListener("resize", function () {
        const sekarang = desktop();
        if (sekarang !== sebelumnyaDesktop) {
            aturSidebar(sekarang, false);
            sebelumnyaDesktop = sekarang;
        }
    });

    /**
     * Menutup dropdown profil pengguna
     */
    function tutupUserMenu() {
        if (userMenu && userBtn) {
            userMenu.classList.remove("show");
            userBtn.setAttribute("aria-expanded", "false");
        }
    }

    // Event dropdown pengguna di kanan atas
    if (userBtn && userMenu) {
        userBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            const buka = !userMenu.classList.contains("show");
            userMenu.classList.toggle("show", buka);
            userBtn.setAttribute("aria-expanded", buka ? "true" : "false");
        });

        document.addEventListener("click", function (e) {
            if (!userMenu.contains(e.target)) {
                tutupUserMenu();
            }
        });
    }

    // Penanganan tombol Escape
    document.addEventListener("keydown", function (e) {
        if (e.key !== "Escape") return;

        tutupUserMenu();

        if (body.classList.contains("sb-open") && !desktop()) {
            aturSidebar(false, false);
        }
    });

})();

