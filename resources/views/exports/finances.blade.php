<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>Jenis</th>
            <th>Keterangan</th>
            <th>Nominal</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalPemasukkan = 0;
            $totalPengeluaran = 0;
        @endphp

        @foreach($finances as $finance)
            <tr>
                <td>
                    @if($finance->jenis === 1)
                        {{ \Carbon\Carbon::parse($finance->pemasukkan->tanggal)->translatedFormat('j F Y') }}
                    @elseif($finance->jenis === 2)
                        {{ \Carbon\Carbon::parse($finance->pengeluaran->tanggal)->translatedFormat('j F Y') }}
                    @endif
                </td>
                <td>{{ $finance->nama }}</td>
                <td>{{ ($finance->jenis === 1) ? 'Pemasukkan' : 'Pengeluaran'}}</td>
                <td>
                    @if ($finance->jenis === 1 && $finance->pemasukkan)
                        {{ $finance->pemasukkan->keterangan }}
                    @elseif ($finance->jenis === 2 && $finance->pengeluaran)
                        {{ $finance->pengeluaran->keterangan }}
                    @endif
                </td>
                <td>
                    @if ($finance->jenis === 1 && $finance->pemasukkan)
                        Rp. {{ number_format($finance->pemasukkan->nominal, 0, ',', '.') }}
                    @elseif ($finance->jenis === 2 && $finance->pengeluaran)
                        Rp. {{ number_format($finance->pengeluaran->nominal, 0, ',', '.') }}
                    @endif
                </td>
            </tr>
            @php
                if ($finance->jenis === 1 && $finance->pemasukkan) {
                    $totalPemasukkan += $finance->pemasukkan->nominal;
                }
                if ($finance->jenis === 2 && $finance->pengeluaran) {
                    $totalPengeluaran += $finance->pengeluaran->nominal;
                }
            @endphp
        @endforeach

        <!-- Display total rows without conditional check -->
        <tr>
            <td colspan="3"></td>
            <td><strong>Total Pemasukkan:</strong></td>
            <td><strong>Rp. {{ number_format($totalPemasukkan, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td><strong>Total Pengeluaran:</strong></td>
            <td><strong>Rp. {{ number_format($totalPengeluaran, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td><strong>Total Saldo:</strong></td>
            <td><strong>Rp. {{ number_format($totalPemasukkan - $totalPengeluaran, 0, ',', '.') }}</strong></td>
        </tr>
    </tbody>
</table>
