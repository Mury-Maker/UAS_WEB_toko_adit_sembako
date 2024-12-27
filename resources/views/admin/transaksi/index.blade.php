<div class="row p-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5><b>{{ $title }}</b></h5>
                <a href="/admin/transaksi/create" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Tambah</a>
                <table class="table">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Transaksi</th>
                        <th>Kasir</th>
                        <th>Status</th>
                        <th>Total Transaksi</th>
                        <th>Action</th>
                    </tr>

                    @foreach ($transaksi as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->kasir_name }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ 'Rp. ' . format_rupiah($item->total) }}</td>
                        <td>
                            @if (strtolower($item->status) === 'pending')
                                <a href="/admin/transaksi/{{ $item->id }}/edit" class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </table>

                <div class="d-flex justify-content-center">
                    {{ $transaksi->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
