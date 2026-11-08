<style>
.chatbot-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 99999;
    align-items: center;
    justify-content: center;
}
.chatbot-modal.show { display: flex; }
.chatbot-box {
    width: 400px;
    max-width: 92%;
    height: 520px;
    background: #fff;
    border-radius: 16px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
.chatbot-header {
    background: #c9a27e;
    color: #fff;
    padding: 14px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 600;
}
.chatbot-header button {
    background: none;
    border: 0;
    color: #fff;
    font-size: 24px;
    cursor: pointer;
}
.chatbot-messages {
    flex: 1;
    padding: 14px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 10px;
    background: #faf7f4;
}
.chatbot-messages .msg {
    max-width: 80%;
    padding: 10px 14px;
    border-radius: 14px;
    font-size: 14px;
    line-height: 1.4;
}
.chatbot-messages .msg.bot {
    background: #fff;
    align-self: flex-start;
    border: 1px solid #eee;
}
.chatbot-messages .msg.user {
    background: #c9a27e;
    color: #fff;
    align-self: flex-end;
}
.chatbot-input {
    display: flex;
    gap: 8px;
    padding: 12px;
    border-top: 1px solid #eee;
}
.chatbot-input input {
    flex: 1;
    padding: 10px 14px;
    border: 1px solid #ddd;
    border-radius: 20px;
    outline: none;
}
.chatbot-input button {
    padding: 10px 18px;
    border: 0;
    border-radius: 20px;
    background: #c9a27e;
    color: #fff;
    cursor: pointer;
}
</style>

<div id="chatbotModal" class="chatbot-modal">
    <div class="chatbot-box">
        <div class="chatbot-header">
            <span>Asisten AI Salon</span>
            <button id="closeChatbot" type="button">&times;</button>
        </div>
        <div class="chatbot-messages" id="chatMessages">
            <div class="msg bot">Halo! Ada yang bisa aku bantu soal perawatan rambut atau kecantikan?</div>
        </div>
        <div class="chatbot-input">
            <input type="text" id="chatInput" placeholder="Ketik pertanyaan..." autocomplete="off">
            <button id="sendChat" type="button">Kirim</button>
        </div>
    </div>
</div>

<script>
(function () {
    var modal = document.getElementById('chatbotModal');
    var input = document.getElementById('chatInput');
    var box   = document.getElementById('chatMessages');

    function buka()  { modal.classList.add('show'); input.focus(); }
    function tutup() { modal.classList.remove('show'); }

    // Klik "Tanya AI" di mana pun (topbar, kartu dashboard, sidebar)
    document.addEventListener('click', function (e) {
        var t = e.target.closest('.open-chatbot, a[href="#chatbot"]');
        if (t) { e.preventDefault(); buka(); }
    });

    document.getElementById('closeChatbot').addEventListener('click', tutup);
    modal.addEventListener('click', function (e) { if (e.target === modal) tutup(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') tutup(); });

    function addMsg(text, who) {
        var div = document.createElement('div');
        div.className = 'msg ' + who;
        div.textContent = text;
        box.appendChild(div);
        box.scrollTop = box.scrollHeight;
        return div;
    }

    async function kirim() {
        var text = input.value.trim();
        if (!text) return;
        addMsg(text, 'user');
        input.value = '';
        var loading = addMsg('Sedang mengetik...', 'bot');
        try {
            var res  = await fetch('chatbot_api.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message: text })
            });
            var data = await res.json();
            loading.textContent = data.reply || 'Maaf, terjadi kesalahan.';
        } catch (err) {
            loading.textContent = 'Gagal terhubung ke server.';
        }
    }

    document.getElementById('sendChat').addEventListener('click', kirim);
    input.addEventListener('keydown', function (e) { if (e.key === 'Enter') kirim(); });
})();
</script>