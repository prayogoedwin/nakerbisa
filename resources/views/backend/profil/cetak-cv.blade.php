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
        <!-- Header Section -->
        <section class="section">
            <h1>{{ $user->name ?? 'No Username' }} </h1>
            <p>{{ $user->email }} | {{ $user->whatsapp ?? 'No Phone Provided' }} |
                {{ $user->pencari->alamat ?? 'No Address Provided' }}</p>
        </section>

        <!-- Personal Information Section -->
        <section class="section">
            <h2>Informasi Pribadi</h2>
            <p><strong>Nomor KTP:</strong> {{ $user->pencari->ktp ?? 'Tidak Ada KTP' }}</p>
            <p><strong>Tempat Lahir:</strong> {{ $user->pencari->tempat_lahir ?? 'Tidak Ada Tempat Lahir' }}</p>
            <p><strong>Tanggal Lahir:</strong>
                {{ \Carbon\Carbon::parse($user->pencari->tanggal_lahir)->format('d F, Y') ?? 'Tidak Ada Tanggal Lahir' }}
            </p>
            <p><strong>Jenis Kelamin:</strong>
                {{ $user->pencari->gender == 'L' ? 'Laki-laki' : ($user->pencari->gender == 'P' ? 'Perempuan' : 'Tidak Ada Jenis Kelamin') }}
            </p>
            <p><strong>Alamat:</strong> {{ $user->pencari->alamat ?? 'Tidak Ada Alamat' }}</p>
            <p><strong>Kode Pos:</strong> {{ $user->pencari->kodepos ?? 'Tidak Ada Kode Pos' }}</p>
            <p><strong>Status Perkawinan:</strong>
                @php
                    $maritalStatus = DB::table('naker_marital')
                        ->where('id', $user->pencari->id_status_perkawinan)
                        ->first();
                @endphp

                {{ $maritalStatus ? $maritalStatus->name : 'Tidak Ada Status Perkawinan' }}
            </p>
            <p><strong>Agama:</strong>
                @php
                    $agama = DB::table('naker_agama')
                        ->where('id', $user->pencari->id_agama)
                        ->first();
                @endphp

                {{ $agama ? $agama->name : 'Tidak Ada Agama' }}
            </p>
            <p><strong>Media Sosial:</strong> {{ $user->pencari->medsos ?? 'Tidak Ada Media Sosial' }}</p>
        </section>

        <!-- Pendidikan Section -->
        @if ($pendidikan->isNotEmpty())
            <section class="section">
                <h2>Pendidikan</h2>
                <ul>
                    @foreach ($pendidikan as $item)
                        <li>
                            <p>
                                <span class="bold">{{ $item->pendidikan_name ?? 'Tidak Ada Pendidikan' }}</span> -
                                <span class="bold">{{ $item->nama_sekolah ?? 'Tidak Ada Nama Sekolah' }}</span>,
                                {{ $item->jurusan_name ?? 'Tidak Ada Jurusan' }} | Tahun Lulus:
                                {{ $item->lulus ?? 'Tidak Ada Tahun Lulus' }}
                            </p>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif

        <!-- Pengalaman Kerja Section -->
        @if ($pengalaman->isNotEmpty())
            <section class="section">
                <h2>Pengalaman Kerja</h2>
                <ul>
                    @foreach ($pengalaman as $item)
                        <li>
                            <p><span class="bold">{{ $item->nama_perusahaan ?? 'Tidak Ada Nama Perusahaan' }}</span>
                                -
                                {{ $item->jabatan ?? 'Tidak Ada Nama Jabatan' }} |
                                {{ $item->mulai_tahun ?? '-' }} - {{ $item->berhenti_tahun ?? '-' }}</p>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif

        <!-- Keterampilan Section -->
        @if ($keterampilan->isNotEmpty())
            <section class="section">
                <h2>Keterampilan</h2>
                <ul>
                    @foreach ($keterampilan as $item)
                        <li>
                            <p>{{ $item->lembaga_penyelenggara ?? '-' }} - {{ $item->no_sertifikat ?? '-' }} -
                                {{ $item->lulus_tahun ?? '-' }} | {{ $item->lembaga_penguji ?? '-' }}</p>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif
    </div>
</body>

</html>
