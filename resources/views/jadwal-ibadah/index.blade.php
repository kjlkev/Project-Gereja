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
        <h2 class="">Jadwal Ibadah</h2>
        <a href="/jadwal-ibadah/export" class="btn btn-success mb-3">
            <i class="bi bi-file-excel">Export Excel </i>
        </a>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="text-center">Tanggal Ibadah</th>
                    <th class="text-center">Nama Ibadah</th>
                    <th class="text-center">Topik Ibadah</th>
                    <th class="text-center">Pembawa Ibadah</th>
                    <th class="text-center">Jemaat</th>
                    <th class="text-center">Pengajaran</th>
                    <th class="text-center">Usher</th>
                    <th class="text-center">Pemusik</th>
                    <th class="text-center">Audio Visual</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <!-- Loop through your ibadah data and display it in the table rows -->
                @foreach ($ibadahSchedule as $ibadah)
                    <tr>
                        <td class="align-middle">{{ \Carbon\Carbon::parse($ibadah->tanggal)->translatedFormat('j F Y') }}</td>
                        <td class="align-middle">{{$ibadah->nama}}</td>
                        <td class="align-middle">{{$ibadah->topik}}</td>
                        <td class="align-middle">{{$ibadah->pembawa}}</td>
                        <td class="align-middle">
                            @if($ibadah->users->isEmpty() && !Auth::user()->is_admin)
                                -
                            @else
                                <a href="/jadwal-ibadah/jemaat/{{$ibadah->id}}" class="btn btn-primary">View</a>
                            @endif
                        </td>
                        
                        <td class="align-middle">
                            @if($ibadah->pengajarans->isEmpty() && !Auth::user()->is_admin)
                                -
                            @elseif($ibadah->pengajarans->isEmpty())
                                <a href="/jadwal-ibadah/edit/pengajarans/{{$ibadah->id}}">
                                    <i class="bi bi-plus-square"></i>
                                </a>
                            @else
                                @foreach ($ibadah->pengajarans as $pengajaran)
                                    {{ $pengajaran->topik }} <br>
                                @endforeach
                            @endif
                        </td>
                        <td class="align-middle">
                            <!-- Display ushers for this ibadah -->
                            @if($ibadah->ushers->isEmpty() && !Auth::user()->is_admin)
                                -
                            @elseif($ibadah->ushers->isEmpty())
                                <a href="/jadwal-ibadah/edit/ushers/{{$ibadah->id}}">
                                    <i class="bi bi-plus-square"></i>
                                </a>
                            @else
                                @foreach ($ibadah->ushers as $usher)
                                    {{ $usher->user->username }} <br>
                                @endforeach
                            @endif
                        </td>
                        <td class="align-middle">
                            <!-- Display pemusiks for this ibadah -->
                            @if($ibadah->pemusiks->isEmpty() && !Auth::user()->is_admin)
                                -
                            @elseif($ibadah->pemusiks->isEmpty()) 
                                <a href="/jadwal-ibadah/edit/pemusiks/{{$ibadah->id}}">
                                    <i class="bi bi-plus-square"></i>
                                </a>
                            @else
                                @php
                                    $pemusikNames = [];
                                    foreach ($ibadah->pemusiks as $pemusik) {
                                        if ($pemusik->user && $pemusik->instrument) {
                                            $pemusikNames[$pemusik->user->username][] = $pemusik->instrument->nama;
                                        }
                                    }
                                @endphp

                                @foreach ($pemusikNames as $username => $instruments)
                                    {{ $username }}: {{ implode('/', $instruments) }}<br>
                                @endforeach
                            @endif
                        </td>
                        <td class="align-middle">
                            @if($ibadah->avls->isEmpty() && !Auth::user()->is_admin)
                                -
                            @elseif($ibadah->avls->isEmpty()) 
                                <a href="/jadwal-ibadah/edit/avls/{{$ibadah->id}}">
                                    <i class="bi bi-plus-square"></i>
                                </a>
                            @else
                                <!-- Display AVLs for this ibadah -->
                                @php
                                    $avlNames = [];
                                    foreach ($ibadah->avls as $avl) {
                                        if ($avl->user && $avl->alatAvl) {
                                            $avlNames[$avl->user->username][] = $avl->alatAvl->nama;
                                        }
                                    }
                                @endphp
                                @foreach($avlNames as $username => $alatAvls)
                                    {{ $username }}: {{ implode('/', $alatAvls) }}<br>
                                @endforeach
                            @endif
                        </td>
                        @if(Auth::user()->is_admin == 1)
                            <td class="align-middle">
                                <!-- Add action buttons here, e.g., Edit, Delete -->
                                <a href="/jadwal-ibadah/edit/{{$ibadah->id}}" class="btn btn-primary mb-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="/ibadah/delete/ibadah/{{$ibadah->id}}" method="post" onsubmit="return confirm('Apa anda yakin mau menghapus {{$ibadah->nama}} ?')">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger mb-1">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                <a href="/jadwal-ibadah/export/{{$ibadah->id}}" class="btn btn-success">
                                    <i class="bi bi-file-excel"></i>
                                </a>
                            </td>
                        @else
                            <td class="align-middle">
                                    @if (!$ibadah->users->contains(Auth::user()))
                                        <form action="/ibadah/signup/{{$ibadah->id}}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Daftar</button>
                                        </form>
                                    @else
                                        Registered
                                    @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if(Auth::user()->is_admin == 1)
            <a href="/jadwal-ibadah/create" class="btn btn-primary mt-3">Add New Ibadah</a> 
        @endif
    </div>

</div>
@endsection
