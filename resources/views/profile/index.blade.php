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
        Profile {{ Auth::user()->username }}
    </h3>
</div>
<div class="">
    <div class="mt-4 border rounded-2">
        <form action="/profile/update-profile" method="POST" class="m-4">
            @method('put')
            @csrf
    
            <div class="form-group row">
                <label for="fullname" class="col-sm-12 col-form-label">Full Name</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="fullname" name="fullname" value="{{Auth::user()->fullname}}">
                  @error('fullname')
                      <div class="alert p-0 text-danger">
                          {{ $message }}
                      </div>
                  @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="username" class="col-sm-12 col-form-label">Username</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="username" name="username" value={{Auth::user()->username}}>
                  @error('username')
                      <div class="alert p-0 text-danger">
                          {{ $message }}
                      </div>
                  @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="no_tlpn" class="col-sm-12 col-form-label">No. HP</label>
                <div class="col-sm-12">
                  <input type="number" class="form-control" id="no_tlpn" name="no_tlpn" value={{Auth::user()->no_tlpn}}>
                  @error('no_tlpn')
                      <div class="alert p-0 text-danger">
                          {{ $message }}
                      </div>
                  @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="tgl_lahir" class="col-sm-12 col-form-label">Birth Date</label>
                <div class="col-sm-12">
                    <input type="date" class="form-control datepicker" id="tgl_lahir" name="tgl_lahir" pattern="\d{1,2}/\d{1,2}/\d{4}" placeholder="dd/mm/yyyy" value="{{ Auth::user()->tgl_lahir}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-form-label">Gender</label>
                <div class="col-sm-12">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ Auth::user()->gender === 'female' ? 'checked' : '' }}>
                        <label class="form-check-label" for="female">
                            Female
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ Auth::user()->gender === 'male' ? 'checked' : '' }}>
                        <label class="form-check-label" for="male">
                            Male
                        </label>
                    </div>
                </div>
            </div>
            <div class="pt-1 mb-4 pb-1">
                <button class="btn btn-primary mb-3 form-control col-sm-12" type="submit">Save Update</button>
            </div>
        </form>
    </div>

</div>

@endsection
