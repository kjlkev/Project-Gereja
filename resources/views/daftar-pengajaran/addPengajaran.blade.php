@extends('layouts.dashboard')

@section('content')
<div class="mt-2 mb-2">
    <h3>
        Add New Pengajaran
    </h3>
</div>
<div class="">
    <div class="mt-4 border rounded-2">
        <form action="/jadwal-pengajaran/create" method="POST" class="m-4">
            @csrf
            <div class="form-group row">
                <label for="ibadah_id" class="col-sm-12 col-form-label">Select Nama Ibadah</label>
                <div class="col-sm-12">
                    <select class="form-control" id="ibadah_id" name="ibadah_id">
                        <option value="" disabled selected>Select Ibadah</option>
                        @foreach ($ibadahSchedule as $ibadah)
                            <option value="{{ $ibadah->id }}">{{ $ibadah->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row" id="selectedIbadahScheduleContainer" style="display: none;">
                <div class="col-sm-12">
                    <label for="selectedIbadahSchedule" id="selectedIbadahScheduleLabel">Selected Ibadah Schedule</label>
                    <input type="text" class="form-control" id="selectedDate" readonly>
                </div>
            </div>

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
<script>
    document.getElementById('ibadah_id').addEventListener('change', function() {
        var selectedIbadahId = this.value;

        if (selectedIbadahId) {
            fetch('/get-ibadah-schedule/' + selectedIbadahId)
                .then(response => response.json())
                .then(data => {
                    var selectedIbadahDate = data.tanggal;
                    var dateObj = new Date(selectedIbadahDate);

                    var monthNames = [
                        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                    ];

                    var formattedDate = `${dateObj.getDate()} ${monthNames[dateObj.getMonth()]} ${dateObj.getFullYear()}`;

                    var selectedIbadahDateInput = document.getElementById('selectedDate'); // Fixed variable name here
                    selectedIbadahDateInput.value = formattedDate;

                    document.getElementById('selectedIbadahScheduleContainer').style.display = 'block';
                })
                .catch(error => {
                    console.error('Error fetching Ibadah schedule: ' + error);
                });
        } else {
            document.getElementById('selectedIbadahScheduleContainer').style.display = 'none';
            document.getElementById('selectedIbadahScheduleLabel').style.display = 'none';
        }
    });
</script>

@endsection
