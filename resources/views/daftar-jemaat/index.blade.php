@extends('layouts.dashboard')

@section('content')
    <div class="container-fluid row">
        <div class="mt-4 text-center col-6">
            <h2 class="pb-5">Daftar Jemaat</h2>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="text-center">Number</th>
                        <th class="text-center">Name</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                    @endphp

                    @foreach ($jemaats as $jemaat)
                        <tr>
                            <td class="text-center">{{ $count++ }}</td>
                            <td class="text-center">{{ $jemaat->username }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
