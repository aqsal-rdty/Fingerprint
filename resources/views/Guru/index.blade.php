@extends('layouts.layoutguru')

@section('content')
    <div class="container mt-4">
        <div class="container mt-4">
            <h3 class="mb-2 text-secondary text-start">
                <i class="bi bi-person-check"></i> Kehadiran Guru Hari Ini
            </h3>
            <p class="text-secondary small ms-3 text-start">
                Fingerprint > <i class="fa fa-angle-right"></i> Kehadiran Guru ({{ date('d M Y') }})
            </p>
            <h5 id="timeDisplay" class="fw-bold text-primary mt-2 ms-3"></h5>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex align-items-center justify-content-start">
                            <h5 class="mb-0"><i class="bi bi-check2-circle me-2"></i>Guru yang Sudah Hadir</h5>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table id="tabel-hadir" class="table table-bordered table-hover mb-0">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Nama Guru</th>
                                    <th style="width: 130px;">Waktu Datang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse($absensi as $a)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td>{{ $a->nama }}</td>
                                        <td class="text-center">{{ $a->waktu }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">
                                            <i class="bi bi-exclamation-circle me-1"></i> Belum ada guru yang hadir
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex align-items-center justify-content-start">
                            <h5 class="mb-0"><i class="bi bi-x-circle me-2"></i>Guru yang Belum Hadir</h5>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table id="tabel-belum" class="table table-bordered table-hover mb-0">
                            <thead class="table-primary text-center">
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Nama Guru</th>
                                    <th style="width: 130px;">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse($tidakhadir as $t)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td>{{ $t->nama }}</td>
                                        <td class="text-center">-</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">
                                            <i class="bi bi-check2-all me-1"></i> Semua guru sudah hadir
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('asset_footer')
    <script type="text/javascript">
        function updateTime() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            document.getElementById('timeDisplay').textContent = `${hours}:${minutes}`;
        }
        setInterval(updateTime, 1000);
        updateTime();

        async function refreshData() {
            try {
                const res = await fetch("{{ route('kehadiran.refresh') }}");
                const data = await res.json();

                const hadirTbody = document.querySelector('#tabel-hadir tbody');
                const belumTbody = document.querySelector('#tabel-belum tbody');

                hadirTbody.innerHTML = '';
                if (data.kehadiran.length === 0) {
                    hadirTbody.innerHTML = `<tr><td colspan="3" class="text-center text-muted">
                        <i class="bi bi-exclamation-circle me-1"></i> Belum ada guru yang hadir
                    </td></tr>`;
                } else {
                    data.kehadiran.forEach((absen, i) => {
                        hadirTbody.innerHTML += `
                            <tr>
                                <td class="text-center">${i + 1}</td>
                                <td>${absen.nama}</td>
                                <td class="text-center">${absen.waktu}</td>
                            </tr>`;
                    });
                }

                belumTbody.innerHTML = '';
                let no = 1;
                data.guru.forEach(g => {
                    const cek = data.kehadiran.find(k => k.nip === g.nip);
                    if (!cek) {
                        belumTbody.innerHTML += `
                            <tr>
                                <td class="text-center">${no++}</td>
                                <td>${g.nama}</td>
                                <td class="text-center">-</td>
                            </tr>`;
                    }
                });

                if (no === 1) {
                    belumTbody.innerHTML = `<tr><td colspan="3" class="text-center text-muted">
                        <i class="bi bi-check2-all me-1"></i> Semua guru sudah hadir
                    </td></tr>`;
                }

            } catch (err) {
                console.error("Gagal memuat data:", err);
            }
        }

        setInterval(refreshData, 10000);
        refreshData();
    </script>
@endsection