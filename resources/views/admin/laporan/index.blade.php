<div class="row p-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5><b>Laporan Transaksi</b></h5>
                    
                    <!-- Tombol PDF, Penghasilan Bulanan, dan Excel -->
                    <div class="d-flex gap-3 align-items-center justify-content-start">


                        <!-- Form Unduh PDF -->
                        <form action="{{ route('admin.laporan.transaksiPdf') }}" method="GET" class="d-flex align-items-center">
                            <div class="me-2 d-flex align-items-center">
                                <label for="bulan" class="form-label m-0" style="line-height: 1.8;">Bulan:</label>
                                <input type="month" name="bulan" id="bulan" class="form-control form-control-sm" value="{{ request('bulan') }}">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-file-pdf"></i> PDF
                            </button>
                        </form>

                        <!-- Tombol Penghasilan Bulanan -->
                        <a href="/admin/laporan/bulanan" class="btn btn-info btn-sm">
                            <i class="fas fa-chart-bar"></i> Penghasilan Bulanan
                        </a>
                    </div>


                </div>

                <!-- Filter Laporan -->
                @if(request()->has('tanggal_awal') || request()->has('tanggal_akhir') || request()->has('kasir') || request()->has('status'))
                    <p><b>Filter Laporan:</b></p>
                    <ul>
                        @if(request('tanggal_awal')) <li>Tanggal Awal: {{ request('tanggal_awal') }}</li> @endif
                        @if(request('tanggal_akhir')) <li>Tanggal Akhir: {{ request('tanggal_akhir') }}</li> @endif
                        @if(request('kasir')) <li>Kasir: {{ $kasir_name }}</li> @endif
                        @if(request('status')) <li>Status: {{ request('status') == 'selesai' ? 'Selesai' : 'Pending' }}</li> @endif
                    </ul>
                @endif

                <!-- Tabel Laporan -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Transaksi</th>
                            <th>Kasir</th>
                            <th>Status</th>
                            <th>Total Transaksi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->kasir_name }}</td>
                            <td>{{ $item->status }}</td>
                            <td>{{ 'Rp. ' . format_rupiah($item->total) }}</td>
                            <td>
                                <a href="/admin/laporan/{{ $item->id }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $laporan->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
