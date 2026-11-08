<?php
/* =====================================================================
   RESERVIN — LAYOUT FOOTER CUSTOMER (customer/includes/footer.php)
   Kerangka bawah HTML pelanggan:
   - Footer copyright
   - Script global customer (js/customer.js)
   - Hook script khusus ($extra_js)
   - Penutup </body> dan </html>
   ===================================================================== */
?>
    <!-- FOOTER SITUS -->
    <footer class="site-footer site-footer--slim">
        <div class="copy">© RESERVIN · BOOKING SALON</div>
    </footer>

    <!-- Script Global Interaktivitas Customer -->
    <script src="js/customer.js"></script>

    <!-- Script Khusus Halaman (Opsional) -->
    <?php if (!empty($extra_js)): ?>
        <?= $extra_js ?>
    <?php endif; ?>
        
    <?php include __DIR__ . '/../modal_chatbot.php'; ?>
</body>
</html>

