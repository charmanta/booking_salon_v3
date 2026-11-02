<?php
/* =====================================================================
   RESERVIN — LAYOUT FOOTER ADMIN (admin/includes/footer.php)
   Bagian bawah kerangka HTML:
   - Penutup <main class="ad-main">
   - Footer copyright
   - Penutup wrapper .ad-wrap
   - Include JS utama (admin.js)
   - Hook script tambahan ($extra_js)
   - Penutup </body> dan </html>
   ===================================================================== */
?>
        </main>

        <footer class="ad-foot">© RESERVIN · BOOKING SALON</footer>

    </div>

    <!-- Script Interaktivitas Global Admin -->
    <script src="js/admin.js"></script>

    <!-- Script Khusus Halaman (Opsional) -->
    <?php if (!empty($extra_js)): ?>
        <?= $extra_js ?>
    <?php endif; ?>

</body>
</html>

