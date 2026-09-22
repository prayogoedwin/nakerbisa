@include('components.header')
<!-- Start Breadcrumb
    ============================================= -->
<div class="breadcrumb-area  text-left">
    <div class="breadcrum-shape">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <h1>Lowongan Kerja Emakaryo</h1>
                <ul class="breadcrumb">
                    <li><a href="{{ route('beranda') }}"><i class="fas fa-home"></i> Beranda</a></li>
                    <li>Lowongan Kerja Emakaryo</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->

<!-- Start Blog
        ============================================= -->
<div class="blog-area blog-grid default-padding-bottom">
    <div class="container">
        <style>
            .job-card {
                border: 1px solid #eef2f7;
                border-radius: 14px;
                transition: all 0.2s ease;
                min-height: 100%;
                background: #fff;
            }

            .job-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 24px rgba(34, 72, 140, 0.08);
            }

            .job-logo {
                width: 92px;
                height: 72px;
                object-fit: contain;
            }

            .job-address {
                color: #6a7688;
                font-size: 13px;
                line-height: 1.45;
                margin: 2px 0 2px;
            }

            .job-expire {
                color: #3b455a;
                font-size: 12px;
                margin-bottom: 0;
            }

            .job-title a {
                color: #111;
                font-size: 20px;
                line-height: 1.25;
                font-weight: 700;
            }

            .job-card .thumb {
                margin-bottom: 8px;
            }

            .job-card .info {
                padding-top: 0;
            }

            .job-card .blog-meta ul {
                margin-bottom: 2px;
            }

            .job-title {
                margin-top: 6px;
                margin-bottom: 4px;
            }
        </style>

        <div class="blog-item-box">
            <div class="row" id="ayokerjo-list">
                <div class="col-12">
                    <p class="text-center" id="ayokerjo-status">Memuat lowongan Emakaryo...</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Blog -->

<script>
    (function() {
        const endpoint = 'https://bursakerja.jatengprov.go.id/api/lowongan/index';
        const list = document.getElementById('ayokerjo-list');
        const status = document.getElementById('ayokerjo-status');
        const fallbackLogo = @json(asset('assets/nakerbisa_fe/img/800x600.png'));

        const escapeHtml = (value) => String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');

        const formatDate = (value) => {
            if (!value) {
                return '-';
            }

            const date = new Date(value);
            if (Number.isNaN(date.getTime())) {
                return value;
            }

            return new Intl.DateTimeFormat('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            }).format(date);
        };

        const renderEmpty = (message) => {
            list.innerHTML = `
                <div class="col-12">
                    <p class="text-center">${escapeHtml(message)}</p>
                    <p class="text-center mt-10">
                        <a class="btn btn-primary btn-sm" href="https://bursakerja.jatengprov.go.id/depan/lowongan" target="_blank" rel="noopener noreferrer">
                            Buka Data Langsung di Emakaryo
                        </a>
                    </p>
                </div>
            `;
        };

        const renderVacancies = (vacancies) => {
            if (!Array.isArray(vacancies) || vacancies.length === 0) {
                renderEmpty('Tidak ada lowongan Emakaryo saat ini.');
                return;
            }

            const html = vacancies.map((vacancy) => {
                const logo = vacancy.logo_perusahaan || fallbackLogo;
                const company = vacancy.perusahaan || '-';
                const title = vacancy.judul || '-';
                const link = vacancy.link || '#';
                const location = vacancy.lokasi || vacancy.kabupaten || vacancy.kota || '-';
                const expired = formatDate(vacancy.expired);

                return `
                    <div class="col-xl-4 col-md-6 single-item">
                        <div class="blog-style-one job-card">
                            <div class="thumb">
                                <a href="${escapeHtml(link)}" target="_blank" rel="noopener noreferrer">
                                    <img src="${escapeHtml(logo)}" alt="Logo Perusahaan" class="img-fluid logo-circle job-logo"
                                        onerror="this.onerror=null;this.src='${escapeHtml(fallbackLogo)}';">
                                </a>
                            </div>
                            <div class="info">
                                <div class="blog-meta">
                                    <ul>
                                        <li class="sub-title">${escapeHtml(company)}</li>
                                    </ul>
                                    <div class="job-address">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        ${escapeHtml(location)}
                                    </div>
                                </div>
                                <h3 class="job-title">
                                    <a href="${escapeHtml(link)}" target="_blank" rel="noopener noreferrer">${escapeHtml(title)}</a>
                                </h3>
                                <div class="job-expire">Info expired: ${escapeHtml(expired)}</div>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            list.innerHTML = html;
        };

        fetch(endpoint, {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then((response) => {
                if (!response.ok) {
                    throw new Error('HTTP ' + response.status);
                }
                return response.json();
            })
            .then((payload) => {
                if (!payload || !Array.isArray(payload.data)) {
                    renderEmpty('Data lowongan Emakaryo tidak tersedia.');
                    return;
                }
                renderVacancies(payload.data);
            })
            .catch(() => {
                renderEmpty('Data Emakaryo sedang dibatasi oleh proteksi server sumber. Silakan buka langsung dari Emakaryo.');
            })
            .finally(() => {
                if (status) {
                    status.remove();
                }
            });
    })();
</script>

@include('components.footer')
