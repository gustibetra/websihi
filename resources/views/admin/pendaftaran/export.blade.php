<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Lengkap</th>
            <th>Jenis Kelamin</th>
            <th>Tanggal Lahir</th>
            <th>Asal Sekolah</th>
            <th>Tahun Lulus</th>
            <th>Jurusan Saat Sekolah</th>
            <th>Alamat Rumah</th>
            <th>No WhatsApp</th>
            <th>No Orang Tua</th>
            <th>Email</th>
            <th>Program Dipilih</th>
            <th>Status</th>
            <th>Tanggal Daftar</th>
        </tr>
    </thead>
    <tbody>
        @forelse($rows as $i => $r)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $r->nama_lengkap }}</td>
            <td>{{ $r->jenis_kelamin }}</td>
            <td>{{ $r->tgl_lahir }}</td>
            <td>{{ $r->asal_sekolah }}</td>
            <td>{{ $r->tahun_lulus }}</td>
            <td>{{ $r->jurusan_sekolah ?: '-' }}</td>
            <td>{{ $r->alamat_rumah }}</td>
            <td>{{ $r->no_whatsapp }}</td>
            <td>{{ $r->no_ortu ?: '-' }}</td>
            <td>{{ $r->email }}</td>
            <td>{{ $r->program }}</td>
            <td>{{ $r->status }}</td>
            <td>{{ $r->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        @empty
        <tr><td colspan="14">Tidak ada data pendaftar.</td></tr>
        @endforelse
    </tbody>
</table>