@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Input Financial Data</div>

                <div class="card-body">
                    <form method="POST" action="/finance/create">
                        @csrf

                        <div class="form-group">
                            <label for="nama">Nama:</label>
                            <input type="text" name="nama" id="nama" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="jenis">Jenis:</label>
                            <select name="jenis" id="jenis" class="form-control" required>
                                <option value="" disabled selected>Pilih Jenis</option>
                                <option value="Pengeluaran">Pengeluaran</option>
                                <option value="Pemasukkan">Pemasukkan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="nominal">Nominal:</label>
                            <div class="input-group align-items-center">
                                <span class="input-group-addon mr-2">Rp.</span>
                                <input type="number" name="nominal" id="nominal" class="form-control" required>
                            </div>
                        </div>
                        

                        <div class="form-group">
                            <label for="tanggal">Tanggal:</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan:</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" rows="3" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
