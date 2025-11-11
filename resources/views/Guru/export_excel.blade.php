<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Waktu</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach($data as $row)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $row->nama }}</td>
                <td>{{ $row->waktu }}</td>
                <td>{{ $row->tanggal }}</td>
                <td>{{ $row->keterangan ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>