{{-- Widget chat WhatsApp (gaya panel si Caker) — klik "Kirim Pesan" POST ke klik-sipet lalu redirect WA --}}
<style>
    .wa-sipet-widget {
        position: fixed;
        right: 24px;
        bottom: 24px;
        z-index: 1060;
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
    }

    .wa-sipet-panel {
        display: none;
        position: absolute;
        right: 0;
        bottom: 72px;
        width: min(340px, calc(100vw - 32px));
        max-height: min(480px, 70vh);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 12px 40px rgba(0, 0, 0, .28);
        flex-direction: column;
        background: #fff;
    }

    .wa-sipet-widget.is-open .wa-sipet-panel {
        display: flex;
    }

    .wa-sipet-header {
        background: linear-gradient(135deg, #075e54 0%, #128c7e 100%);
        color: #fff;
        padding: 14px 40px 14px 14px;
        position: relative;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .wa-sipet-header-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .wa-sipet-header-avatar svg {
        width: 26px;
        height: 26px;
        fill: #25d366;
    }

    .wa-sipet-header-text h2 {
        margin: 0;
        font-size: 15px;
        font-weight: 700;
        line-height: 1.25;
    }

    .wa-sipet-header-text p {
        margin: 2px 0 0;
        font-size: 12px;
        opacity: .9;
    }

    .wa-sipet-close {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 32px;
        height: 32px;
        border: none;
        background: rgba(255, 255, 255, .15);
        color: #fff;
        border-radius: 8px;
        cursor: pointer;
        font-size: 18px;
        line-height: 1;
        padding: 0;
    }

    .wa-sipet-close:hover {
        background: rgba(255, 255, 255, .25);
    }

    .wa-sipet-body {
        flex: 1;
        overflow-y: auto;
        padding: 16px 12px 12px;
        background-color: #e5ddd5;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23c9c5bd' fill-opacity='0.35'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .wa-sipet-bubble {
        background: #fff;
        border-radius: 0 10px 10px 10px;
        padding: 10px 12px 12px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, .08);
        max-width: 100%;
    }

    .wa-sipet-bubble small {
        display: block;
        color: #8696a0;
        font-size: 11px;
        margin-bottom: 6px;
    }

    .wa-sipet-bubble p {
        margin: 0;
        font-size: 14px;
        line-height: 1.45;
        color: #303030;
    }

    .wa-sipet-form {
        padding: 0 12px 14px;
        background: #f0f0f0;
    }

    .wa-sipet-submit {
        width: 100%;
        border: none;
        border-radius: 24px;
        background: #25d366;
        color: #fff;
        font-weight: 600;
        font-size: 15px;
        padding: 12px 16px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: background .15s;
    }

    .wa-sipet-submit:hover {
        background: #1ebe57;
        color: #fff;
    }

    .wa-sipet-submit svg {
        width: 22px;
        height: 22px;
        fill: currentColor;
    }

    .wa-sipet-fab {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        background: #25d366;
        color: #fff;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 18px rgba(0, 0, 0, .25);
        margin-left: auto;
        cursor: pointer;
        transition: transform .2s ease-in-out;
    }

    .wa-sipet-fab:hover {
        transform: scale(1.06);
        color: #fff;
    }

    .wa-sipet-fab svg {
        width: 30px;
        height: 30px;
    }
</style>

<div class="wa-sipet-widget" id="waSipetWidget" aria-live="polite">
    <div class="wa-sipet-panel" id="waSipetPanel" role="dialog" aria-labelledby="waSipetTitle">
        <div class="wa-sipet-header">
            <div class="wa-sipet-header-avatar" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                    <path
                        d="M19.11 17.21c-.27-.13-1.6-.79-1.85-.88-.25-.09-.43-.13-.61.13-.18.27-.7.88-.86 1.06-.16.18-.32.2-.59.07-.27-.13-1.13-.42-2.15-1.35-.79-.7-1.33-1.56-1.49-1.83-.16-.27-.02-.42.12-.55.12-.12.27-.32.41-.48.14-.16.18-.27.27-.45.09-.18.05-.34-.02-.48-.07-.13-.61-1.47-.84-2.01-.22-.53-.44-.46-.61-.47-.16-.01-.34-.01-.52-.01-.18 0-.48.07-.73.34-.25.27-.95.93-.95 2.27 0 1.34.97 2.63 1.1 2.81.13.18 1.9 2.91 4.61 4.08.64.28 1.14.44 1.53.56.64.2 1.22.17 1.68.1.51-.08 1.6-.65 1.83-1.28.23-.63.23-1.17.16-1.28-.07-.11-.25-.18-.52-.31z" />
                    <path
                        d="M27.27 4.69C24.3 1.73 20.36.1 16.17.1 7.53.1.5 7.13.5 15.77c0 2.76.72 5.45 2.1 7.82L.37 31.9l8.52-2.2a15.6 15.6 0 0 0 7.28 1.85h.01c8.63 0 15.66-7.03 15.66-15.67 0-4.18-1.63-8.12-4.57-11.19zm-11.1 24.2h-.01a13 13 0 0 1-6.62-1.81l-.47-.28-5.06 1.31 1.35-4.94-.31-.51a12.95 12.95 0 0 1-1.99-6.89c0-7.17 5.84-13.01 13.02-13.01 3.48 0 6.75 1.35 9.21 3.81a12.93 12.93 0 0 1 3.8 9.2c0 7.18-5.84 13.02-13.02 13.02z" />
                </svg>
            </div>
            <div class="wa-sipet-header-text">
                <h2 id="waSipetTitle">Dinas Perindustrian &amp; Tenaga Kerja Kab. Rembang</h2>
                <p>NAKERBISA · Admin (Chat Only)</p>
            </div>
            <button type="button" class="wa-sipet-close" id="waSipetClose" aria-label="Tutup">&times;</button>
        </div>
        <div class="wa-sipet-body">
            <div class="wa-sipet-bubble">
                <small>Dinas Perindustrian &amp; Tenaga Kerja Kab. Rembang</small>
                <p>Halo admin nakerbisa, saya dari web mau tanya tentang .....</p>
            </div>
        </div>
        <div class="wa-sipet-form">
            <form action="{{ route('klik-sipet.store') }}" method="POST">
                @csrf
                <button type="submit" class="wa-sipet-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" aria-hidden="true">
                        <path
                            d="M19.11 17.21c-.27-.13-1.6-.79-1.85-.88-.25-.09-.43-.13-.61.13-.18.27-.7.88-.86 1.06-.16.18-.32.2-.59.07-.27-.13-1.13-.42-2.15-1.35-.79-.7-1.33-1.56-1.49-1.83-.16-.27-.02-.42.12-.55.12-.12.27-.32.41-.48.14-.16.18-.27.27-.45.09-.18.05-.34-.02-.48-.07-.13-.61-1.47-.84-2.01-.22-.53-.44-.46-.61-.47-.16-.01-.34-.01-.52-.01-.18 0-.48.07-.73.34-.25.27-.95.93-.95 2.27 0 1.34.97 2.63 1.1 2.81.13.18 1.9 2.91 4.61 4.08.64.28 1.14.44 1.53.56.64.2 1.22.17 1.68.1.51-.08 1.6-.65 1.83-1.28.23-.63.23-1.17.16-1.28-.07-.11-.25-.18-.52-.31z" />
                        <path
                            d="M27.27 4.69C24.3 1.73 20.36.1 16.17.1 7.53.1.5 7.13.5 15.77c0 2.76.72 5.45 2.1 7.82L.37 31.9l8.52-2.2a15.6 15.6 0 0 0 7.28 1.85h.01c8.63 0 15.66-7.03 15.66-15.67 0-4.18-1.63-8.12-4.57-11.19zm-11.1 24.2h-.01a13 13 0 0 1-6.62-1.81l-.47-.28-5.06 1.31 1.35-4.94-.31-.51a12.95 12.95 0 0 1-1.99-6.89c0-7.17 5.84-13.01 13.02-13.01 3.48 0 6.75 1.35 9.21 3.81a12.93 12.93 0 0 1 3.8 9.2c0 7.18-5.84 13.02-13.02 13.02z" />
                    </svg>
                    Kirim Pesan
                </button>
            </form>
        </div>
    </div>
    <button type="button" class="wa-sipet-fab" id="waSipetToggle" aria-label="Buka chat WhatsApp NAKERBISA"
        aria-expanded="false" aria-controls="waSipetPanel">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" aria-hidden="true">
            <path
                d="M19.11 17.21c-.27-.13-1.6-.79-1.85-.88-.25-.09-.43-.13-.61.13-.18.27-.7.88-.86 1.06-.16.18-.32.2-.59.07-.27-.13-1.13-.42-2.15-1.35-.79-.7-1.33-1.56-1.49-1.83-.16-.27-.02-.42.12-.55.12-.12.27-.32.41-.48.14-.16.18-.27.27-.45.09-.18.05-.34-.02-.48-.07-.13-.61-1.47-.84-2.01-.22-.53-.44-.46-.61-.47-.16-.01-.34-.01-.52-.01-.18 0-.48.07-.73.34-.25.27-.95.93-.95 2.27 0 1.34.97 2.63 1.1 2.81.13.18 1.9 2.91 4.61 4.08.64.28 1.14.44 1.53.56.64.2 1.22.17 1.68.1.51-.08 1.6-.65 1.83-1.28.23-.63.23-1.17.16-1.28-.07-.11-.25-.18-.52-.31z" />
            <path
                d="M27.27 4.69C24.3 1.73 20.36.1 16.17.1 7.53.1.5 7.13.5 15.77c0 2.76.72 5.45 2.1 7.82L.37 31.9l8.52-2.2a15.6 15.6 0 0 0 7.28 1.85h.01c8.63 0 15.66-7.03 15.66-15.67 0-4.18-1.63-8.12-4.57-11.19zm-11.1 24.2h-.01a13 13 0 0 1-6.62-1.81l-.47-.28-5.06 1.31 1.35-4.94-.31-.51a12.95 12.95 0 0 1-1.99-6.89c0-7.17 5.84-13.01 13.02-13.01 3.48 0 6.75 1.35 9.21 3.81a12.93 12.93 0 0 1 3.8 9.2c0 7.18-5.84 13.02-13.02 13.02z" />
        </svg>
    </button>
</div>

<script>
    (function() {
        const root = document.getElementById('waSipetWidget');
        if (!root) return;
        const toggle = document.getElementById('waSipetToggle');
        const closeBtn = document.getElementById('waSipetClose');

        function setOpen(open) {
            root.classList.toggle('is-open', open);
            if (toggle) {
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            }
        }

        toggle?.addEventListener('click', function(e) {
            e.stopPropagation();
            setOpen(!root.classList.contains('is-open'));
        });
        closeBtn?.addEventListener('click', function() {
            setOpen(false);
        });
        document.addEventListener('click', function(e) {
            if (root.classList.contains('is-open') && !root.contains(e.target)) {
                setOpen(false);
            }
        });
    })();
</script>
