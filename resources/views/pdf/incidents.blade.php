<!DOCTYPE html>
<html>
<head>
    <title>Laporan Incident HSE</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background: #eee;
        }
    </style>
</head>
<body>

    <h2>Laporan Incident HSE</h2>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Tanggal</th>
                <th>Area</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Keparahan</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($incidents as $incident)
            <tr>
                <td>{{ $incident->kode_laporan }}</td>
                <td>{{ $incident->tanggal_kejadian }}</td>
                <td>{{ $incident->area->nama_area }}</td>
                <td>{{ $incident->category->nama_kategori }}</td>
                <td>{{ $incident->lokasi_spesifik }}</td>
                <td>{{ $incident->tingkat_keparahan }}</td>
                <td>{{ $incident->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>