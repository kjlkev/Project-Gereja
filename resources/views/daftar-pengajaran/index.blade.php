@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="mt-4 text-center">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h2 class="pb-5">Jadwal Pengajaran</h2>
        <table class="table">
            <thead>
                <tr>
                    <th class="text-center">Nama Ibadah</th>
                    <th class="text-center">Tanggal Pengajaran</th>
                    <th class="text-center">Topik Ajaran</th>
                    <th class="text-center">Pembawa Ajaran</th>
                    @if(Auth::user()->is_admin == 1)
                        <th class="text-center">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody class="text-center">
                <!-- Loop through your ibadah data and display it in the table rows -->
                @foreach ($pengajarans as $pengajaran)
                    <tr>
                        <td class="align-middle">{{ $pengajaran->ibadah->nama }}</td>
                        <td class="align-middle">{{ \Carbon\Carbon::parse($pengajaran->ibadah->tanggal)->translatedFormat('j F Y') }}</td>
                        <td class="align-middle">{{ $pengajaran->topik }}</td>
                        <td class="align-middle">{{ $pengajaran->pembawa}}</td>
                        @if(Auth::user()->is_admin == 1)
                            <td class="align-middle">
                                <!-- Add action buttons here, e.g., Edit, Delete -->
                                <a href="/jadwal-pengajaran/edit/{{$pengajaran->ibadah->id}}" class="btn btn-primary mb-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="/pengajaran/delete/pengajaran/{{$pengajaran->id}}" method="post" onsubmit="return confirm('Apa anda yakin mau menghapus pengajaran dengan topik : {{$pengajaran->topik}} ?')">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger mb-1">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- New Jadwal Pengajaran button -->
        @if(Auth::user()->is_admin == 1)
            <a href="/jadwal-pengajaran/create" class="btn btn-primary mt-3">Add New Pengajaran</a>
        @endif
    </div>
</div>
@endsection
