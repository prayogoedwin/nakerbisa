<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV - {{ $user->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            margin: 2rem auto;
            max-width: 800px;
            padding: 1rem;
        }

        h1,
        h2,
        h3 {
            margin: 0 0 10px;
        }

        .section {
            margin-bottom: 1.5rem;
        }

        .section h2 {
            font-size: 1.5rem;
            border-bottom: 1px solid #ddd;
            padding-bottom: 0.3rem;
            margin-bottom: 1rem;
        }

        ul {
            padding-left: 20px;
        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <section class="section">
            <h1>{{ $user->name ?? 'No Username' }} </h1>
            <p>{{ $user->email }} | {{ $user->whatsapp ?? 'No Phone Provided' }} |
                {{ $user->pencari->alamat ?? 'No Address Provided' }}</p>
        </section>

        <!-- Ringkasan Profil -->
        @if ($user->profile_summary)
            <section class="section">
                <h2>Ringkasan Profil</h2>
                <p>{{ $user->profile_summary }}</p>
            </section>
        @endif

        @if ($pendidikan->isNotEmpty())
            <section class="section">
                <h2>Pendidikan</h2>
                <ul>
                    @foreach ($pendidikan as $item)
                        <li>
                            <p>
                                <span class="bold">{{ $item->pendidikan_name ?? 'Tidak Ada Pendidikan' }}</span> -
                                <span class="bold">{{ $item->nama_sekolah ?? 'Tidak Ada Nama Sekolah' }}</span>,
                                {{ $item->jurusan_name ?? 'Tidak Ada Jurusan' }} | Tahun Lulus: {{ $item->lulus ?? 'Tidak Ada Tahun Lulus' }}
                            </p>
                            <p class="content">{{ $item->alamat_sekolah ?? 'Tidak Ada Alamat Sekolah' }}</p>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif

        <!-- Pengalaman Kerja -->
        @if ($pengalaman->isNotEmpty())
            <section class="section">
                <h2>Pengalaman Kerja</h2>
                <ul>
                    @foreach ($pengalaman as $item)
                        <li>
                            <p><span class="bold">{{ $item->nama_perusahaan ?? 'Tidak Ada Nama Perusahaan' }}</span> - {{ $item->jabatan ?? 'Tidak Ada Nama Jabatan' }} |
                                {{ $item->mulai_tahun ?? '-' }} - {{ $item->berhenti_tahun ?? '-'}}</p>
                            </p>
                            <p>{{ $item->alamat_perusahaan ?? '-' }}</p>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif

        <!-- Keterampilan -->
        @if ($keterampilan->isNotEmpty())
            <section class="section">
                <h2>Keterampilan</h2>
                <ul>
                    @foreach ($keterampilan as $item)
                        <li>
                            <p>{{ $item->lembaga_penyelenggara ?? '-' }} - {{ $item->no_sertifikat ?? '-' }}</p>
                            <p>{{ $item->alamat_penyelenggara ?? '-' }}</p>
                            <p>{{ $item->lulus_tahun ?? '-' }} | {{ $item->lembaga_penguji ?? '-' }}</p>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif
    </div>
</body>

</html>
