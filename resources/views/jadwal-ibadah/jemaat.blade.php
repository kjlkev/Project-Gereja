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
        <h2 class="text-center">Jadwal Ibadah, {{ $ibadah->isEmpty() ? '' : $ibadah[0]->nama }}</h2>
        <div class="d-flex justify-content-between align-items-start m-2">
            <a href="/jadwal-ibadah" class="btn btn-primary mr-3">Back</a>
        </div>
        <!-- Assuming 'name' is the attribute you want to display in the title -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="text-center">Jemaat</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <!-- Loop through your ibadah data and display it in the table rows -->
                @foreach ($ibadah as $item)
                    <tr>
                        <td class="align-middle">
                            @if ($item->users->isEmpty() && !Auth::user()->is_admin)
                                -
                            @else
                                @foreach ($item->users as $user)
                                    {{ $loop->index + 1 }}. {{ $user->username }} <br>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
