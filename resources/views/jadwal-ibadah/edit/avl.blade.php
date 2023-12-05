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
                    <h4>Daftar Audio Visual</h4>
                </label>
                <div class="col-sm-12"> <!-- Set the width to half (50% of the parent container) -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Audio Visual</th>
                                <th class="text-center">Alat</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($avls as $avl)
                                <tr>
                                    <td class="align-middle">{{$avl->user?->username}}</td>
                                    <td class="align-middle">{{$avl->alatAvl?->nama}}</td>
                                    <td class="align-middle">
                                        <form action="/ibadah/delete/avls/{{$avl->id}}" method="post">
                                            @method('delete')
                                            @csrf
                                                <button type="submit" class="btn btn-danger" 
                                                onclick="return confirm('Apa anda yakin mau menghapus {{$avl->user?->username}} ?')">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <form action="/ibadah/add/avls/{{$ibadah->id}}" method="POST" class="m-4">
                        @csrf
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
                                    @foreach ($alatAvls as $alatAvl)
                                        <option value="{{ $alatAvl->id }}">{{ $alatAvl->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3 pt-4"> <!-- Adjusted column width -->
                                <label for="addAVL" class="col-form-label"></label>
                                <button id="addAVL" type="button" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                        <div class="pt-1 mb-4 pb-1">
                            <button class="btn btn-primary mb-3 form-control col-sm-12" type="submit">Add Audio Visual</button>
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
    const selectedAVL = [];

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
