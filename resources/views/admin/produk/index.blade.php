<div class="row p-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5><b>{{ $title }}</b></h5>
                <a href="/admin/produk/create" class="btn btn-primary mb-2"><i class="fas fa-plus"></i> Tambah</a>
                <div class="row">
                    @foreach ($produk as $item)
                    <div class="col-md-2 mb-2">
                        <div class="card">
                            <!-- Correct image display with responsive classes -->
                            <img src="{{ asset($item->gambar) }}" class="card-img-top img-fluid w-100" alt="{{ $item->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <p class="card-text">Stok : {{ $item->stok }}</p>
                                <p class="card-text">Harga : Rp {{ number_format($item->harga, 0, ',', '.') }}</p> <!-- Display price -->
                                <div class="d-flex justify-content">
                                    <a href="/admin/produk/{{ $item->id }}/edit" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                    <form action="/admin/produk/{{ $item->id }}" method="POST">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm ml-1"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center">
                    {{ $produk->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>

    .card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .card-img-top {
        width: 100%;
        height: 150px; /* Atur tinggi gambar sesuai dengan yang diinginkan */
        object-fit: cover; /* Agar gambar tidak terdistorsi */
    }
    
    .card-body {
        flex-grow: 1;
    }
</style>
    