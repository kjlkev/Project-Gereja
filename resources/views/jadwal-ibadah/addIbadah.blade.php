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
        Add New Ibadah
    </h3>
</div>
<div class="">
    <div class="mt-4 border rounded-2">
        <form action="/jadwal-ibadah/create" method="POST" class="m-4">
            @csrf
            <div class="form-group row">
                <label for="tanggal" class="col-sm-12 col-form-label">Tanggal Ibadah</label>
                <div class="col-sm-12">
                    <input type="date" class="form-control datepicker" id="tanggal" name="tanggal" pattern="\d{1,2}/\d{1,2}/\d{4}" placeholder="dd/mm/yyyy" value="">
                </div>
            </div>

            <div class="form-group row">
                <label for="nama" class="col-sm-12 col-form-label">Nama Ibadah</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="nama" name="nama" value="{{old('nama')}}">
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
                  <input type="text" class="form-control" id="topik" name="topik" value={{old('topik')}}>
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
                  <input type="text" class="form-control" id="pembawa" name="pembawa" value={{old('pembawa')}}>
                  @error('pembawa')
                      <div class="alert p-0 text-danger">
                          {{ $message }}
                      </div>
                  @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="selectedUsher" class="col-sm-12 col-form-label">Daftar Usher</label>
                <select class="form-select" id="multiple-select-field" data-placeholder="Choose anything" multiple name="selectedUsher[]">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" class="w-75">{{ $user->username }}</option>
                    @endforeach
                </select>
                <small class="text-muted">(Note: Click a selected user to remove)</small>
            </div>
            

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
                <div class="col-sm-3"> <!-- Adjusted column width -->
                    <label for="addPemusik" class="col-form-label"></label>
                    <button id="addPemusik" type="button" class="btn btn-primary">Add</button>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12">
                    <label id="avlListLabel">List Daftar Audio Visual</label>
                </div>
                <div class="col-sm-12">
                    <div id="selectedAVL" class="pb-2">
                        <input type="hidden" name="selectedAVL[][avlId]" value="">
                        <input type="hidden" name="selectedAVL[][alatId]" value="">
                    </div>
                </div>
                <div class="col-sm-4 pb-1">
                    <label for="pemusik_id" class="col-form-label">Daftar Audio Visual</label>
                    <select class="form-control select2" id="avl_id" name="avl_id">
                        <option value="" disabled selected>Choose Person</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->username }}</option>
                        @endforeach
                    </select>
                </div>
            
                <!-- Dropdown for selecting an instrument -->
                <div class="col-sm-5"> <!-- Adjusted column width -->
                    <label for="instrument_id" class="col-form-label">Daftar Alat</label>
                    <select class="form-control" id="alat_id" name="alat_id">
                        <option value="" disabled selected>Choose Role</option>
                        @foreach ($avls as $avl)
                            <option value="{{ $avl->id }}">{{ $avl->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3"> <!-- Adjusted column width -->
                    <label for="addAVL" class="col-form-label"></label>
                    <button id="addAVL" type="button" class="btn btn-primary">Add</button>
                </div>
            </div>

            
            

            <div class="pt-1 mb-4 pb-1">
                <button class="btn btn-primary mb-3 form-control col-sm-12" type="submit">Create</button>
            </div>
        </form>
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
    const selectedAVL = [];

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

            console.log("Hello " + item.pemusikId);
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


    // Function to add or remove an AVL
    function toggleAVL(avlId, alatId, avlnama, alatNama) {
        selectedAVL.push({ avlId, alatId, avlnama, alatNama });
        updateSelectedAVL();

        // Remove all existing input fields with name 'selectedAVL[][avlId]'
        $("input[name^='selectedAVL']").remove();

        // Rebuild the input fields based on the updated selectedAVL array
        selectedAVL.forEach(function (item, index) {
            const inputAvlId = $("<input>")
                .attr("type", "hidden")
                .attr("name", `selectedAVL[${index}][avlId]`)
                .val(item.avlId);
            const inputAlatId = $("<input>")
                .attr("type", "hidden")
                .attr("name", `selectedAVL[${index}][alatId]`)
                .val(item.alatId);

            $("#selectedAVL").append(inputAvlId);
            $("#selectedAVL").append(inputAlatId);

            $("#avl_id option[value='" + item.avlId + "']").remove();
            $("avl_id").trigger("change");
        });
    }

        // Function to update the selected AVL list
        function updateSelectedAVL() {
            // Sort the selectedAVL array alphabetically by avlname
            selectedAVL.sort((a, b) => a.avlnama.localeCompare(b.avlnama));

            $("#selectedAVL").empty();
            selectedAVL.forEach(function(item, index) {
                const avlNumber = index + 1;
                const avlElement = $("<div>").text(
                    avlNumber + ". " + item.avlnama + " - " + item.alatNama
                );
                $("#selectedAVL").append(avlElement);
            });
            // Show/hide the label and list based on whether there are selected AVLs
            if (selectedAVL.length > 0) {
                $("#avlListLabel").show();
                $("#selectedAVL").show();
            } else {
                $("#avlListLabel").hide();
                $("#selectedAVL").hide();
            }
        }

        // Initially hide the label and list
        $("#avlListLabel").hide();
        $("#selectedAVL").hide();

        // Handle 'Add' button click for AVL
        $("#addAVL").click(function() {
            const selectedAVLId = $("#avl_id option:selected").val();
            const selectedAlatId = $("#alat_id option:selected").val();

            if (selectedAVLId && selectedAlatId) {
                const selectedAVLnama = $("#avl_id option:selected").text();
                const selectedAlatNama = $("#alat_id option:selected").text();
                toggleAVL(selectedAVLId, selectedAlatId, selectedAVLnama, selectedAlatNama);
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
