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
                    <h4>Daftar Ushers</h4>
                </label>
                <div class="col-sm-12"> <!-- Set the width to half (50% of the parent container) -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Nama Usher</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($ushers as $usher)
                                <tr>
                                    <td class="align-middle">{{$usher->user->username}}</td>
                                    <td class="align-middle">
                                        <form action="/ibadah/delete/ushers/{{$usher->id}}" method="post">
                                            @method('delete')
                                            @csrf
                                                <button type="submit" class="btn btn-danger" 
                                                onclick="return confirm('Apa anda yakin mau menghapus {{$usher->user->username}} ?')">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <form action="/ibadah/add/ushers/{{$ibadah->id}}" method="POST" class="m-4">
                        @csrf
                        <div class="form-group row">
                            <label for="selectedUsher" class="col-sm-12 col-form-label">Daftar Usher</label>
                            <select class="form-select" id="multiple-select-field" data-placeholder="Choose anything" multiple name="selectedUsher[]">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" class="w-75">{{ $user->username }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">(Note: Click a selected user to remove)</small>
                        </div>
                        <div class="pt-1 mb-4 pb-1">
                            <button class="btn btn-primary mb-3 form-control col-sm-12" type="submit">Add Ushers</button>
                        </div>
                    </form>
                    
                </div>
            </div>
            
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#multiple-select-field').select2();
    });
    $('#multiple-select-field').select2({
    theme: "bootstrap-5",
    width: '75%', // Set the width to 75%
    placeholder: $(this).data('placeholder'),
    closeOnSelect: false
    });
</script>
@endsection
