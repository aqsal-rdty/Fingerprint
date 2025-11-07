<script src="{{ url('asset/js/plugins/jquery.datatables.min.js') }}"></script>
<script src="{{ url('asset/js/plugins/datatables.bootstrap.min.js') }}"></script>

<div id="scrollDiv" style="width: 100%; height: 340px; overflow: auto;">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th style="width:5%">No</th>
                <th style="width:50%">Nama</th>
                <th>NIP</th>
                <th>Waktu</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $abs)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $abs->guru->nama ?? 'Tidak ditemukan' }}</td>
                    <td>{{ $abs->nip }}</td>
                    <td>{{ $abs->waktu }}</td>
                    <td>1</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada data absensi hari ini</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script type="text/javascript">
    var $el = $("#scrollDiv");
    function anim() {
        var st = $el.scrollTop();
        var sb = $el.prop("scrollHeight") - $el.innerHeight();
        $el.animate({ scrollTop: st < sb/2 ? sb : 0 }, 50000, anim);
    }
    function stop(){ $el.stop(); }
    anim();
    $el.hover(stop, anim);
</script>