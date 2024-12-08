<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV - {{ $user->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        header h1 {
            font-size: 2em;
            margin: 0;
        }

        header p {
            margin: 5px 0;
        }

        section {
            margin-bottom: 20px;
        }

        section h2 {
            font-size: 1.5em;
            border-bottom: 2px solid #000;
            margin-bottom: 10px;
        }

        section h3 {
            font-size: 1.2em;
            margin-bottom: 5px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 5px;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .date-location {
            text-align: right;
            font-size: 0.9em;
            color: #555;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="container">
        <header>
            <h1>{{ $user->name ?? 'No Username' }}</h1>
            <p>{{ $user->email }} | {{ $user->whatsapp ?? 'No Phone Provided' }} |
                {{ $user->pencari->alamat ?? 'Tidak Ada Alamat' }} {{ $user->pencari->kodepos ?? 'Tidak Ada Kode Pos' }}
            </p>
            <p><a href="#">{{ $user->pencari->medsos ?? 'Tidak Ada Media Sosial' }}</a></p>
        </header>
        @if ($pendidikan->isNotEmpty())
            <section class="education">
                <h2>Pendidikan</h2>
                <ul>
                    @foreach ($pendidikan as $item)
                        <li>
                            <div class="flex-container">
                                <p><strong>{{ $item->nama_sekolah ?? 'Tidak Ada Nama Sekolah' }}</strong></p>
                                <p class="date-location">
                                    {{ $item->lulus ?? 'Tidak Ada Tanggal Mulai' }} -
                                    {{ $item->alamat_sekolah ?? 'Tidak Ada Lokasi' }}
                                </p>
                            </div>
                            <p>{{ $item->jurusan_name ?? 'Tidak Ada Jurusan' }}</p>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif
        @if ($pengalaman->isNotEmpty())
            <section class="internship">
                <h2>Pengalaman Kerja</h2>
                <ul>
                    @foreach ($pengalaman as $item)
                        <li>
                            <div class="flex-container">
                                <p><strong>{{ $item->jabatan ?? 'Tidak Ada Nama Jabatan' }}</strong></p>
                                <p class="date-location">
                                    {{ $item->mulai_tahun ?? '-' }} - {{ $item->berhenti_tahun ?? '-' }} |
                                    {{ $item->alamat_perusahaan ?? 'Tidak Ada Lokasi' }}
                                </p>
                            </div>
                            <p>{{ $item->nama_perusahaan ?? 'Tidak Ada Nama Perusahaan' }}</p>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif
        @if ($keterampilan->isNotEmpty())
            <section class="certifications">
                <h2>Keterampilan</h2>
                <ul>
                    @foreach ($keterampilan as $item)
                        <li>
                            <div class="flex-container">
                                {{ $item->lembaga_penyelenggara ?? '-' }} - {{ $item->no_sertifikat ?? '-' }} -
                                {{ $item->lulus_tahun ?? '-' }} | {{ $item->lembaga_penguji ?? '-' }}
                                <p class="date-location">
                                    {{ $item->alamat_penyelenggara ?? 'Tidak Ada Lokasi' }}
                                </p>
                            </div>
                            <p></p>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif
    </div>
</body>

</html>
