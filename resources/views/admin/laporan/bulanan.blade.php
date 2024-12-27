<div class="row p-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- Tombol Kembali -->
                <a href="/admin/laporan" class="btn btn-secondary btn-sm mb-3">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                
                <h5><b>Penghasilan Bulanan</b></h5>

                <!-- Canvas untuk Chart -->
                <canvas id="chartPenghasilanBulanan" width="400" height="200"></canvas>

                <!-- Tabel Data (Opsional) -->
                <table class="table mt-4">
                    <tr>
                        <th>Bulan</th>
                        <th>Total Penghasilan</th>
                    </tr>
                    @foreach ($penghasilan as $item)
                    <tr>
                        <td>{{ $item->bulan }}</td>
                        <td>{{ 'Rp. ' . number_format($item->total_penghasilan, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('chartPenghasilanBulanan').getContext('2d');
    const chartData = @json($chartData); // Data dari controller

    new Chart(ctx, {
        type: 'bar', // Jenis chart (bisa bar, line, dll.)
        data: {
            labels: chartData.labels, // Bulan
            datasets: [{
                label: 'Penghasilan Bulanan',
                data: chartData.data, // Penghasilan
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true // Mulai dari 0
                }
            }
        }
    });
</script>
