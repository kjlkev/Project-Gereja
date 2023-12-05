@extends('layouts.dashboard')

@section('content')
@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="mt-2 mb-2 d-flex ">
    <a href="/jadwal-ibadah/edit/{{$ibadah->id}}" class="btn btn-primary mr-3">Back</a>
    <h3 class="text-end">
        Editing {{$ibadah->nama}}
    </h3>
</div>
<div class="">
    <div class="mt-4 border rounded-2 p-3">
            <div class="form-group row">
                <label for="selectedUsher" class="col-sm-12 col-form-label text-center">
                    <h4>Daftar Pengajaran</h4>
                </label>
                <div class="col-sm-12"> <!-- Set the width to half (50% of the parent container) -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Tanggal Pengajaran</th>
                                <th class="text-center">Topik Ajaran</th>
                                <th class="text-center">Pembawa Ajaran</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($pengajarans as $pengajaran)
                                <tr>
                                    <td class="align-middle">{{ \Carbon\Carbon::parse($pengajaran->ibadah->tanggal)->translatedFormat('j F Y') }}</td>
                                    <td class="align-middle">{{ $pengajaran->topik }}</td>
                                    <td class="align-middle">{{ $pengajaran->pembawa}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <form action="/ibadah/add/pengajarans/{{$ibadah->id}}" method="POST" class="m-4">
                        @csrf
            
                        <div class="form-group row">
                            <label for="topik" class="col-sm-12 col-form-label">Topik Ajaran</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="topik" name="topik" value={{old('topik')}}>
                              @error('topik')
                                  <div class="alert p-0 text-danger">
                                      {{ $message }}
                                  </div>
                              @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pembawa" class="col-sm-12 col-form-label">Pembawa Ajaran</label>
                            <div class="col-sm-12">
                              <input type="text" class="form-control" id="pembawa" name="pembawa" value={{old('pembawa')}}>
                              @error('pembawa')
                                  <div class="alert p-0 text-danger">
                                      {{ $message }}
                                  </div>
                              @enderror
                            </div>
                        </div>
                        <div class="pt-1 mb-4 pb-1">
                            <button class="btn btn-primary mb-3 form-control col-sm-12" type="submit">Create</button>
                        </div>
                    </form>
                    
                </div>
            </div>
            
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>

</script>
@endsection
