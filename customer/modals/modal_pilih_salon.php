<?php
/* =====================================================================
   RESERVIN — MODAL PILIH SALON (customer/modals/modal_pilih_salon.php)
   Pop-up konfirmasi pemilihan salon sebelum menuju form booking.
   ===================================================================== */
?>
<!-- MODAL PILIH SALON -->
<div class="modal" id="modalSalon">
    <div class="modal-box">
        <h2 id="namaSalon">Pilih Salon</h2>
        <p class="modal-info">Kamu memilih salon ini. Selanjutnya pilih layanan, tanggal, jam, dan apakah ingin dilayani Owner atau Pegawai.</p>
        <button type="button" class="modal-btn lanjut" onclick="lanjutBooking()">Lanjut Booking</button>
        <button type="button" class="modal-btn batal" onclick="tutupModal()">Batal</button>
    </div>
</div>

