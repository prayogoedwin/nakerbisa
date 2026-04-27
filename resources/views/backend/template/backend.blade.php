@include('backend.template.header')

@if (Auth::check() && Auth::user()->roles[0]['name'] == 'super-admin')
    @include('backend.template.sidebar')
@endif

@if (Auth::check() && Auth::user()->roles[0]['name'] == 'tenaga-kerja')
    @include('backend.template.sidebar-pencari')
@endif

@if (Auth::check() && Auth::user()->roles[0]['name'] == 'penyedia-kerja')
    @include('backend.template.sidebar-penyedia')
@endif

@if (Auth::check() && Auth::user()->roles[0]['name'] == 'admin-bkk')
    @include('backend.template.sidebar-bkk')
@endif

@if (Auth::check() && Auth::user()->roles[0]['name'] == 'admin-blk')
    @include('backend.template.sidebar-blk')
@endif


<body>
    @yield('content')
    <style>
        .wa-floating-button {
            position: fixed;
            right: 24px;
            bottom: 24px;
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
            z-index: 1060;
            transition: transform .2s ease-in-out;
        }

        .wa-floating-button:hover {
            transform: scale(1.06);
            color: #fff;
        }

        .wa-floating-button svg {
            width: 30px;
            height: 30px;
        }
    </style>

    <button type="button" class="wa-floating-button" data-bs-toggle="modal" data-bs-target="#modalKlikSipetBackend"
        aria-label="Buka Form WhatsApp">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" fill="currentColor" aria-hidden="true">
            <path
                d="M19.11 17.21c-.27-.13-1.6-.79-1.85-.88-.25-.09-.43-.13-.61.13-.18.27-.7.88-.86 1.06-.16.18-.32.2-.59.07-.27-.13-1.13-.42-2.15-1.35-.79-.7-1.33-1.56-1.49-1.83-.16-.27-.02-.42.12-.55.12-.12.27-.32.41-.48.14-.16.18-.27.27-.45.09-.18.05-.34-.02-.48-.07-.13-.61-1.47-.84-2.01-.22-.53-.44-.46-.61-.47-.16-.01-.34-.01-.52-.01-.18 0-.48.07-.73.34-.25.27-.95.93-.95 2.27 0 1.34.97 2.63 1.1 2.81.13.18 1.9 2.91 4.61 4.08.64.28 1.14.44 1.53.56.64.2 1.22.17 1.68.1.51-.08 1.6-.65 1.83-1.28.23-.63.23-1.17.16-1.28-.07-.11-.25-.18-.52-.31z" />
            <path
                d="M27.27 4.69C24.3 1.73 20.36.1 16.17.1 7.53.1.5 7.13.5 15.77c0 2.76.72 5.45 2.1 7.82L.37 31.9l8.52-2.2a15.6 15.6 0 0 0 7.28 1.85h.01c8.63 0 15.66-7.03 15.66-15.67 0-4.18-1.63-8.12-4.57-11.19zm-11.1 24.2h-.01a13 13 0 0 1-6.62-1.81l-.47-.28-5.06 1.31 1.35-4.94-.31-.51a12.95 12.95 0 0 1-1.99-6.89c0-7.17 5.84-13.01 13.02-13.01 3.48 0 6.75 1.35 9.21 3.81a12.93 12.93 0 0 1 3.8 9.2c0 7.18-5.84 13.02-13.02 13.02z" />
        </svg>
    </button>

    <div class="modal fade" id="modalKlikSipetBackend" tabindex="-1" aria-labelledby="modalKlikSipetBackendLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalKlikSipetBackendLabel">Kirim ke WhatsApp</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form action="{{ route('klik-sipet.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="klikSipetNamaBackend" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="klikSipetNamaBackend" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="klikSipetWaBackend" class="form-label">No Whatsapp</label>
                            <input type="text" class="form-control" id="klikSipetWaBackend" name="wa" required>
                        </div>
                        <div class="mb-3">
                            <label for="klikSipetJudulBackend" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="klikSipetJudulBackend" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label for="klikSipetIsiBackend" class="form-label">Isi</label>
                            <textarea class="form-control" id="klikSipetIsiBackend" name="isi" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('backend.template.footer')
    @stack('js')
</body>

</html>
