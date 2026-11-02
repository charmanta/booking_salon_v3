/**
 * =====================================================================
 * RESERVIN — ADMIN SCRIPT UTAMA (admin/js/admin.js)
 * Mengatur interaktivitas global admin:
 * 1. Toggle Sidebar (Buka/Tutup di Mobile & Desktop)
 * 2. Simpan Preferensi Sidebar ke LocalStorage
 * 3. Menu Profil Pengguna (Dropdown Kanan Atas)
 * 4. Penanganan Tombol Escape & Resize Window
 * 5. Efek Ripple Wave & Tactile Feedback (Matching Customer)
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

    /**
     * EFEK RIPPLE WAVE & TACTILE FEEDBACK INTERAKTIF
     * Memicu gelombang animasi saat tombol ditekan di seluruh halaman admin
     * — sama persis dengan sistem di customer/ agar tampilan terasa konsisten
     */
    function inisialisasiEfekTombol() {
        document.addEventListener("pointerdown", function (e) {
            const btn = e.target.closest(
                ".ad-btn, .ad-mini, .ad-tab, .ad-burger, .ad-user, " +
                ".ad-x, .iv-btn, .ad-hari label, .ad-fas label, " +
                ".ad-link, .ad-semua, .ad-dd a"
            );

            if (!btn || btn.disabled) return;

            // Pastikan elemen bertipe <button>, <a>, atau label interaktif
            const tag = btn.tagName.toLowerCase();
            const boleh = ["button", "a", "label"].includes(tag) ||
                btn.classList.contains("ad-btn") ||
                btn.classList.contains("ad-mini");
            if (!boleh) return;

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

            // Deteksi warna latar — tentukan kontras ripple
            const bg = style.backgroundColor;
            const isDark =
                bg.includes("43, 30") ||     /* var(--ink) #2b1e19 */
                bg.includes("59, 42") ||     /* sidebar dark */
                bg.includes("196, 160") ||   /* var(--tan) */
                bg.includes("176, 141");     /* var(--tan-dark) */

            if (!isDark) {
                ripple.classList.add("cm-ripple-dark");
            }

            ripple.style.width = diameter + "px";
            ripple.style.height = diameter + "px";
            ripple.style.left = (e.clientX - rect.left - radius) + "px";
            ripple.style.top = (e.clientY - rect.top - radius) + "px";

            // Bersihkan ripple lama
            const rippleLama = btn.querySelector(".cm-ripple");
            if (rippleLama) rippleLama.remove();

            btn.appendChild(ripple);

            setTimeout(function () {
                ripple.remove();
            }, 600);
        });
    }

    inisialisasiEfekTombol();

})();

