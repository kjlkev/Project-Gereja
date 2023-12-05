@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h2 class="mt-4">Financial Data</h2>
    <a href="/finance/export" class="btn btn-success mb-4">
        <i class="bi bi-file-excel">Export Excel </i>
    </a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Jenis</th>
                <th>Keterangan</th>
                <th>Nominal</th>
                <th>Action</th>
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
                    <td>
                        <a href="/finance/edit/{{ $finance->id }}" class="btn btn-warning">Edit</a>
                        <form action="/finance/delete/{{ $finance->id }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
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
        </tbody>
    </table>
    
    <div class="text-right">
        <p>Total Pemasukkan: Rp. {{ number_format($totalPemasukkan, 0, ',', '.') }}</p>
        <p>Total Pengeluaran: Rp. {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
        <p>Total Saldo: Rp. {{ number_format($totalPemasukkan - $totalPengeluaran, 0, ',', '.') }}</p>
    </div>
    
    <a href="/finance/create" class="btn btn-success">Add New Finance</a>
</div>
@endsection
