<div class="row p-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5><b>Buat Laporan Transaksi</b></h5>

                <form action="/admin/laporan" method="GET">
                    <div class="form-group">
                        <label for="tanggal_awal">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal') }}">
                    </div>

                    <div class="form-group">
                        <label for="tanggal_akhir">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir') }}">
                    </div>

                    <div class="form-group">
                        <label for="kasir">Kasir</label>
                        <select name="kasir" class="form-control">
                            <option value="">-- Semua Kasir --</option>
                            @foreach ($kasirs as $kasir)
                                <option value="{{ $kasir->id }}" {{ request('kasir') == $kasir->id ? 'selected' : '' }}>{{ $kasir->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option value="">-- Semua Status --</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
                </form>
            </div>
        </div>
    </div>
</div>
