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
                    <h4>Daftar Pemusik</h4>
                </label>
                <div class="col-sm-12"> <!-- Set the width to half (50% of the parent container) -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Nama Pemusik</th>
                                <th class="text-center">Instrument</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($pemusiks as $pemusik)
                                <tr>
                                    <td class="align-middle">{{$pemusik->user->username}}</td>
                                    <td class="align-middle">{{$pemusik->instrument->nama}}</td>
                                    <td class="align-middle">
                                        <form action="/ibadah/delete/pemusiks/{{$pemusik->id}}" method="post">
                                            @method('delete')
                                            @csrf
                                                <button type="submit" class="btn btn-danger" 
                                                onclick="return confirm('Apa anda yakin mau menghapus {{$pemusik->user->username}} ?')">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <form action="/ibadah/add/pemusiks/{{$ibadah->id}}" method="POST" class="m-4">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label id="listLabel">List Daftar Pemusik dan Instrument</label>
                            </div>
                            <div class="col-sm-12">
                                <div id="selectedPemusik" class="pb-2">
                                    <input type="hidden" name="selectedPemusik[][pemusikId]" value="">
                                    <input type="hidden" name="selectedPemusik[][instrumentId]" value="">
                                </div>
                            </div>
                            <div class="col-sm-4 pb-1">
                                <label for="pemusik_id" class="col-form-label">Daftar Pemusik</label>
                                <select class="form-control select2" id="pemusik_id" name="pemusik_id">
                                    <option value="" disabled selected>Choose Person</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->username }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <!-- Dropdown for selecting an instrument -->
                            <div class="col-sm-5"> <!-- Adjusted column width -->
                                <label for="instrument_id" class="col-form-label">Daftar Instrument</label>
                                <select class="form-control" id="instrument_id" name="instrument_id">
                                    <option value="" disabled selected>Choose Role</option>
                                    @foreach ($instruments as $instrument)
                                        <option value="{{ $instrument->id }}">{{ $instrument->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3 pt-4"> <!-- Adjusted column width -->
                                <label for="addPemusik" class="col-form-label"></label>
                                <button id="addPemusik" type="button" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                        <div class="pt-1 mb-4 pb-1">
                            <button class="btn btn-primary mb-3 form-control col-sm-12" type="submit">Add Pemusik</button>
                        </div>
                    </form>
                    
                </div>
            </div>
            
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2 for the user_id field
        $('.select2').select2();
    });

    $(document).ready(function() {
    const selectedPemusik = [];

    // Function to add or remove a pemusik
    function togglePemusik(pemusikId, instrumentId, pemusikname, instrumentName) {
        selectedPemusik.push({ pemusikId, instrumentId, pemusikname, instrumentName });
        updateSelectedPemusik();

        // Remove all existing input fields with name 'selectedPemusik[][pemusikId]'
        $("input[name^='selectedPemusik']").remove();

        // Rebuild the input fields based on the updated selectedPemusik array
        selectedPemusik.forEach(function (item, index) {
            const inputPemusikId = $("<input>")
                .attr("type", "hidden")
                .attr("name", `selectedPemusik[${index}][pemusikId]`)
                .val(item.pemusikId);
            const inputInstrumentId = $("<input>")
                .attr("type", "hidden")
                .attr("name", `selectedPemusik[${index}][instrumentId]`)
                .val(item.instrumentId);

            $("#selectedPemusik").append(inputPemusikId);
            $("#selectedPemusik").append(inputInstrumentId);
            
            $("#pemusik_id option[value='" + item.pemusikId + "']").remove();
            $("#pemusik_id").trigger("change");
        });
    }

    // Function to update the selected pemusik list
    function updateSelectedPemusik() {
        // Sort the selectedPemusik array alphabetically by pemusikname
        selectedPemusik.sort((a, b) => a.pemusikname.localeCompare(b.pemusikname));

        $("#selectedPemusik").empty();
        selectedPemusik.forEach(function(item, index) {
            const pemusikNumber = index + 1;
            const pemusikElement = $("<div>").text(
                pemusikNumber + ". " + item.pemusikname + " - " + item.instrumentName
            );
            $("#selectedPemusik").append(pemusikElement);
        });
        // Show/hide the label and list based on whether there are selected pemusik
        if (selectedPemusik.length > 0) {
            $("#listLabel").show();
            $("#selectedPemusik").show();
        } else {
            $("#listLabel").hide();
            $("#selectedPemusik").hide();
        }
    }

    // Initially hide the label and list
    $("#listLabel").hide();
    $("#selectedPemusik").hide();

    // Handle 'Add' button click
    $("#addPemusik").click(function() {
        const selectedPemusikId = $("#pemusik_id option:selected").val();
        const selectedInstrumentId = $("#instrument_id option:selected").val();

        if (selectedPemusikId && selectedInstrumentId) {
            const selectedPemusikname = $("#pemusik_id option:selected").text();
            const selectedInstrumentName = $("#instrument_id option:selected").text();
            togglePemusik(selectedPemusikId, selectedInstrumentId, selectedPemusikname, selectedInstrumentName);
        }
    });

    $('#multiple-select-field').select2({
        theme: "bootstrap-5",
        width: '75%', // Set the width to 75%
        placeholder: $(this).data('placeholder'),
        closeOnSelect: false
    });

});
</script>
@endsection
