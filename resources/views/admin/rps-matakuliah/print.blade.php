<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>RPS {{ $rps->mappingMatakuliah->matakuliah->kode_matakuliah }}</title>
    <style>
        /*** Styling minimal untuk cetak PDF ***/
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #000;
        }

        .kop {
            text-align: center;
            margin-bottom: 15px;
        }

        .kop .judul-univ {
            font-size: 16px;
            font-weight: bold;
        }

        .kop .alamat-univ {
            font-size: 11px;
        }

        hr {
            border: none;
            border-top: 2px solid #000;
            margin: 5px 0 20px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: top;
        }

        table th {
            background: #f0f0f0;
            font-weight: normal;
            text-align: left;
        }
    </style>
</head>

<body>

    {{-- Kop Surat --}}
    <div class="kop">
        <div class="judul-univ">UNIVERSITAS WIRARAJA</div>
        <div class="alamat-univ">
            Jl. Pendidikan No. 123, Kota Sumenep – Provinsi Jawa Timur<br>
            Telepon (021) 12345678 – Email: info@wiraraja.ac.id
        </div>
    </div>
    <hr>

    {{-- Judul Dokumen --}}
    <div style="text-align: center; margin-bottom: 20px;">
        <strong>RENCANA PEMBELAJARAN SEMESTER (RPS)</strong><br>
        <span style="font-size: 13px;">
            Mata Kuliah: {{ $rps->mappingMatakuliah->matakuliah->nama_matakuliah }}
            ({{ $rps->mappingMatakuliah->matakuliah->kode_matakuliah }})
        </span>
    </div>

    {{-- Informasi Umum RPS --}}
    <div class="section-title">Data Mata Kuliah</div>
    <table>
        <tr>
            <th style="width: 25%;">Tahun Ajaran</th>
            <td style="width: 25%;">{{ $rps->mappingMatakuliah->tahunAjaran->tahun_ajaran }}</td>
            <th style="width: 25%;">Semester</th>
            <td style="width: 25%;">{{ $rps->mappingMatakuliah->semester }}</td>
        </tr>
        <tr>
            <th>Dosen Pengampu</th>
            <td>{{ optional($rps->mappingMatakuliah->dosen)->name ?? '-' }}</td>
            <th>Admin Verifier</th>
            <td>{{ optional($rps->mappingMatakuliah->adminVerifier)->name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Tanggal Mulai RPS</th>
            <td>{{ \Carbon\Carbon::parse($rps->tanggal_mulai)->translatedFormat('d F Y') }}</td>
            <th>Tanggal Selesai RPS</th>
            <td>{{ \Carbon\Carbon::parse($rps->tanggal_selesai)->translatedFormat('d F Y') }}</td>
        </tr>
    </table>

    {{-- Tabel RPS Detail --}}
    <div class="section-title">Detail RPS</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No.</th>
                <th style="width: 10%;">Sesi</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 20%;">Capaian Pembelajaran</th>
                <th style="width: 15%;">Indikator</th>
                <th style="width: 15%;">Metode Pembelajaran</th>
                <th style="width: 20%;">Materi Pembelajaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rps->rpsDetails as $index => $detail)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td style="text-align: center;">{{ $detail->sesi_pertemuan }}</td>
                <td>
                    {{ \Carbon\Carbon::parse($detail->tanggal_pertemuan)->translatedFormat('d F Y') }}
                </td>
                <td>{!! $detail->capaian_pembelajaran !!}</td>
                <td>{!! $detail->indikator !!}</td>
                <td>{!! $detail->metode_pembelajaran !!}</td>
                <td>{!! $detail->materi_pembelajaran !!}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Tanda tangan --}}
    <div style="margin-top: 40px; width: 100%;">
        <div style="width: 50%; float: left; text-align: center;">
            <div>Dosen Pengampu,</div>
            <br><br><br><br><br>
            <div style="text-decoration: underline;">
                {{ optional($rps->mappingMatakuliah->dosen)->name ?? '—' }}
            </div>
        </div>
        <div style="width: 50%; float: right; text-align: center;">
            <div>Admin Verifikasi,</div>
            <br><br><br><br><br>
            <div style="text-decoration: underline;">
                {{ optional($rps->mappingMatakuliah->adminVerifier)->name ?? '—' }}
            </div>
        </div>
    </div>

</body>

</html>