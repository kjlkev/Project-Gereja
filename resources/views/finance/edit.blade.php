@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-primary">Edit, {{$finance->nama}}</div>

                <div class="card-body">
                    <form method="POST" action="/finance/update/{{$finance->id}}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="nama">Nama:</label>
                            <input type="text" name="nama" id="nama" class="form-control" required value="{{$finance->nama}}">
                        </div>

                        <div class="form-group">
                            <label for="jenis">Jenis:</label>
                            <select name="jenis" id="jenis" class="form-control" required>
                                <option value="" disabled {{ $finance->jenis ? '' : 'selected' }}>Pilih Jenis</option>
                                <option value="Pengeluaran" {{ $finance->jenis == 2 ? 'selected' : '' }}>Pengeluaran</option>
                                <option value="Pemasukkan" {{ $finance->jenis == 1 ? 'selected' : '' }}>Pemasukkan</option>
                            </select>
                        </div>
                        

                        
                        
                        @if($finance->jenis == 2)
                        <div class="form-group">
                            <label for="nominal">Nominal:</label>
                            <div class="input-group align-items-center">
                                <span class="input-group-addon mr-2">Rp.</span>
                                <input type="number" name="nominal" id="nominal" class="form-control"
                                    required value="{{$finance->pengeluaran->nominal}}">
                            </div>
                        </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal:</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" 
                                    required value="{{$finance->pengeluaran->tanggal}}">
                            </div>
                        @elseif($finance->jenis == 1)
                            <div class="form-group">
                                <label for="nominal">Nominal:</label>
                                <div class="input-group align-items-center">
                                    <span class="input-group-addon mr-2">Rp.</span>
                                    <input type="number" name="nominal" id="nominal" class="form-control"
                                        required value="{{$finance->pemasukkan->nominal}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal:</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" 
                                    required value="{{$finance->pemasukkan->tanggal}}">
                            </div>
                        @endif


                        <div class="form-group">
                            <label for="keterangan">Keterangan:</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" rows="3" required>{{ $finance->jenis == 2 ? $finance->pengeluaran->keterangan : ($finance->jenis == 1 ? $finance->pemasukkan->keterangan : '') }}
                            </textarea>
                        </div>
                        

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
