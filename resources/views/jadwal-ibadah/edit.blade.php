@extends('layouts.dashboard')

@section('content')
@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="mt-2 mb-2">
    <h3>
        Editing {{$ibadah->nama}}
    </h3>
</div>
<div class="">
    <div class="mt-4 border rounded-2">
        <form action="/jadwal-ibadah/update/{{$ibadah->id}}" method="POST" class="m-4">
            @method('put')
            @csrf
            <div class="form-group row">
                <label for="tanggal" class="col-sm-12 col-form-label">Tanggal Ibadah</label>
                <div class="col-sm-12">
                    <input type="date" class="form-control datepicker" id="tanggal" name="tanggal" pattern="\d{1,2}/\d{1,2}/\d{4}" placeholder="dd/mm/yyyy" value="{{old('tanggal', $ibadah->tanggal)}}">
                </div>
            </div>

            <div class="form-group row">
                <label for="nama" class="col-sm-12 col-form-label">Nama Ibadah</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="nama" name="nama" value="{{old('nama', $ibadah->nama)}}">
                  @error('nama')
                      <div class="alert p-0 text-danger">
                          {{ $message }}
                      </div>
                  @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="topik" class="col-sm-12 col-form-label">Topik Ibadah</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="topik" name="topik" value="{{old('topik', $ibadah->topik)}}">
                  @error('topik')
                      <div class="alert p-0 text-danger">
                          {{ $message }}
                      </div>
                  @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="pembawa" class="col-sm-12 col-form-label">Pembawa Ibadah</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="pembawa" name="pembawa" value="{{old('pembawa', $ibadah->pembawa)}}">
                  @error('pembawa')
                      <div class="alert p-0 text-danger">
                          {{ $message }}
                      </div>
                  @enderror
                </div>
            </div>

            
            <div class="pt-1 mb-4 pb-1">
                <button class="btn btn-primary mb-3 form-control col-sm-12" type="submit">Save Update</button>
            </div>
        </form>



        <div class="m-4">
            <div class="form-group row">
                <label for="selectedUsher" class="col-sm-12 col-form-label">Daftar Usher</label>
                <div class="col-sm-6"> <!-- Set the width to half (50% of the parent container) -->
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Nama Usher</th>
                                {{-- <th class="text-center">Action</th> --}}
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($ushers as $item)
                                <tr>
                                    <td class="align-middle">{{$item->user->username}}</td>
                                    {{-- <td class="align-middle">
                                        <button type="button" class="btn btn-danger" onclick="removeUsher({{$index}})">Remove</button>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="/jadwal-ibadah/edit/ushers/{{$ibadah->id}}" class="btn btn-primary">Edit Ushers</a>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="selectedUsher" class="col-sm-12 col-form-label">Daftar Pemusik dan Instrument</label>
                <div class="col-sm-6"> <!-- Set the width to half (50% of the parent container) -->
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Pemusik</th>
                                {{-- <th class="text-center">Action</th> --}}
                            </tr>
                        </thead>
                        <tbody class="text-center">
                                <tr>
                                    <td class="align-middle">
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
                                    </td>
                                    {{-- <td class="align-middle">
                                        <button type="button" class="btn btn-danger" onclick="removeUsher({{$index}})">Remove</button>
                                    </td> --}}
                                </tr>
                        </tbody>
                    </table>
                    <a href="/jadwal-ibadah/edit/pemusiks/{{$ibadah->id}}" class="btn btn-primary">Edit Pemusik</a>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="selectedAVL" class="col-sm-12 col-form-label">Daftar Audio Visual</label>
                <div class="col-sm-6">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Audio Visual</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                                <tr>
                                    <td class="align-middle">
                                        @php
                                            $avlNames = [];
                                            foreach ($ibadah->avls as $item) {
                                                if ($item->user && $item->alatAvl) {
                                                    $avlNames[$item->user->username][] = $item->alatAvl->nama;
                                                }
                                            }
                                        @endphp
                                        @foreach ($avlNames as $username => $alatAvl)
                                            {{ $username }}: {{ implode('/', $alatAvl) }}<br>
                                        @endforeach
                                    </td>
                                    {{-- <td class="align-middle">
                                        <button type="button" class="btn btn-danger" onclick="removeAVL({{$avl->id}})">Remove</button>
                                    </td> --}}
                                </tr>
                        </tbody>
                    </table>
                    <a href="/jadwal-ibadah/edit/avls/{{$ibadah->id}}" class="btn btn-primary">Edit Audio Visual</a>
                </div>
            </div>


            <div class="form-group row">
                <label for="selectedAVL" class="col-sm-12 col-form-label">Daftar Pengajaran</label>
                <div class="col-sm-6">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Pengajaran</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                                <tr>
                                    <td class="align-middle">
                                        @foreach ($pengajarans as  $pengajaran)
                                            {{ $pengajaran->topik }} <br>
                                        @endforeach
                                    </td>
                                    {{-- <td class="align-middle">
                                        <button type="button" class="btn btn-danger" onclick="removeAVL({{$avl->id}})">Remove</button>
                                    </td> --}}
                                </tr>
                        </tbody>
                    </table>
                    <a href="/jadwal-ibadah/edit/pengajarans/{{$ibadah->id}}" class="btn btn-primary">Edit Pengajaran</a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
