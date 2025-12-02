<table>
    <thead>
        <tr>
            <th colspan="4"
                style="font-weight: bold; font-size: 14px; text-align: center; height: 30px; vertical-align: middle;">
                LAPORAN APOTEK SIDOWARAS</th>
        </tr>
        <tr>
            <th colspan="4" style="text-align: center; font-style: italic;">Periode: {{ $from->format('d F Y') }} -
                {{ $to->format('d F Y') }}</th>
        </tr>
        <tr></tr>
    </thead>
    <tbody>
        <!-- Summary Section -->
        <tr>
            <td colspan="4" style="font-weight: bold; background-color: #e2e8f0;">RINGKASAN KINERJA</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Total Pendapatan</td>
            <td>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
            <td style="font-weight: bold;">Total Transaksi</td>
            <td>{{ number_format($totalTransactions) }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Total Pembelian</td>
            <td>Rp {{ number_format($totalPurchases, 0, ',', '.') }}</td>
            <td style="font-weight: bold;">Total Item Stok</td>
            <td>{{ number_format($totalStock) }}</td>
        </tr>
        <tr></tr>

        <!-- Top Selling Section -->
        <tr>
            <td colspan="4" style="font-weight: bold; background-color: #e2e8f0;">OBAT TERLARIS (TOP 5)</td>
        </tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f8f9fa;">Nama Obat</th>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f8f9fa;">Terjual</th>
            <th colspan="2" style="font-weight: bold; border: 1px solid #000000; background-color: #f8f9fa;">Total
                Pendapatan</th>
        </tr>
        @foreach($topSelling as $item)
            <tr>
                <td style="border: 1px solid #000000;">{{ $item->nama_obat }}</td>
                <td style="border: 1px solid #000000; text-align: center;">{{ $item->total_sold }}</td>
                <td colspan="2" style="border: 1px solid #000000;">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}
                </td>
            </tr>
        @endforeach
        <tr></tr>

        <!-- Low Stock Section -->
        <tr>
            <td colspan="4" style="font-weight: bold; background-color: #e2e8f0;">STOK MENIPIS</td>
        </tr>
        <tr>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f8f9fa;">Nama Obat</th>
            <th style="font-weight: bold; border: 1px solid #000000; background-color: #f8f9fa;">Sisa Stok</th>
            <th colspan="2" style="font-weight: bold; border: 1px solid #000000; background-color: #f8f9fa;">Stok
                Minimum</th>
        </tr>
        @foreach($lowStock as $item)
            <tr>
                <td style="border: 1px solid #000000;">{{ $item->obat->nama_obat }}</td>
                <td style="border: 1px solid #000000; text-align: center; color: #dc3545; font-weight: bold;">
                    {{ $item->total_stock }}</td>
                <td colspan="2" style="border: 1px solid #000000; text-align: center;">{{ $item->obat->stok_minimum }}</td>
            </tr>
        @endforeach
    </tbody>
</table>