{{-- resources/views/admin/laporan/show.blade.php --}}
<div class="row p-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5><b>Detail Laporan Transaksi</b></h5>

                <p><b>Tanggal Transaksi:</b> {{ $transaksi->created_at }}</p>
                <p><b>Kasir:</b> {{ $transaksi->kasir_name }}</p>
                <p><b>Status:</b> {{ ucfirst($transaksi->status) }}</p>
                <p><b>Total Transaksi:</b> Rp. {{ number_format($transaksi->total, 0, ',', '.') }}</p>

                <h6><b>Detail Produk</b></h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>QTY</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi->details as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->produk_name }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>Rp. {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Kembali ke Laporan</a>
            </div>
        </div>
    </div>
</div>
