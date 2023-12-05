@extends('layouts.dashboard')

@section('content')
<div class="container-fluid row">
    <div class="col-12 mt-4 text-center">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h2>Jemaat Activity</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Ibadah Count</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <!-- Loop through your ibadah data and display it in the table rows -->
                @foreach ($usersWithIbadahCount as $user)
                    <tr>
                        <td>{{ $user->fullname }}</td>
                        <td>{{ $user->ibadah_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-6">
        <form method="get" action="{{ route('jemaat') }}" class="mb-4">
            @csrf
            <div class="form-group">
                <label for="userMonthSelect">Select User:</label>
                <select name="userMonthSelect" id="userMonthSelect" class="form-control">
                    <option value="{{old('userMonthSelect')}}">All Users</option>
                    @foreach($usersWithIbadahCount as $user)
                        <option value="{{ $user->fullname }}">{{ $user->fullname }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="monthSelect">Select Month:</label>
                <input type="month" name="monthSelect" id="monthSelect" class="form-control" value="{{ old('monthSelect', $monthSelect) }}">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="#" id="jemaatMonthChart" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf"></i>
                Export to Bar
                <i class="bi bi-bar-chart"></i>
            </a>
            <a href="#" id="jemaatMonthPieChart" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf"></i>
                Export to Pie
                <i class="bi bi-pie-chart"></i>
            </a>
        </form>
        <canvas id="userActivityChart"></canvas>
    </div>

    <div class="col-6">
        <form method="get" action="{{ route('jemaat') }}" class="mb-4">
            @csrf
            <div class="form-group">
                <label for="userYearSelect">Select User:</label>
                <select name="userYearSelect" id="userYearSelect" class="form-control">
                    <option value="{{old('userYearSelect')}}">All Users</option>
                    @foreach($usersWithIbadahCount as $user)
                        <option value="{{ $user->fullname }}">{{ $user->fullname }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="yearSelect">Select Year:</label>
                <select name="yearSelect" id="yearSelect" class="form-control">
                    @php
                        $currentYear = date('Y') + 1;
                    @endphp
                    @for ($years = $currentYear; $years >= $currentYear - 10; $years--)
                        <option value="{{ $years }}" {{ old('yearSelect', $yearSelect) == $years ? 'selected' : '' }}>{{ $years }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="#" id="jemaatYearChart" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf"></i>
                Export to Bar
                <i class="bi bi-bar-chart"></i>
            </a>
            <a href="#" id="jemaatYearPieChart" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf"></i>
                Export to Pie
                <i class="bi bi-pie-chart"></i>
            </a>
        </form>
        <canvas id="userActivityYearChart"></canvas>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var userData = @json($month);
    var yearData = @json($year);
    var month = @json($monthSelect);
    var year = @json($yearSelect);

    var dynamicMonthBackgroundColors = generateRandomColors(userData.length);
    var dynamicYearBackgroundColors = generateRandomColors(yearData.length);
    // console.log(dynamicMonthBackgroundColors, dynamicYearBackgroundColors);

    function generateRandomColors(numColors) {
        var colors = [];
        for (var i = 0; i < numColors; i++) {
            var color = `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 0.2)`;
            colors.push(color);
        }
        return colors;
    }

    document.addEventListener("DOMContentLoaded", function() {
        var yearChartLabels = yearData.map(function(user) {
            return user.fullname;
        });
        var yearChartData = yearData.map(function(user) {
            return user.ibadah_count;
        });
        // console.log(yearData);
        var yearChart = {
            type: 'bar',
            data: {
                labels: yearChartLabels,
                datasets: [
                    {
                        label: 'Ibadah Count',
                        data: yearChartData,
                        backgroundColor: dynamicYearBackgroundColors,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                    },
                ],
            },
        };
        var link = document.getElementById('jemaatYearChart');
        // var queryString = '?yearData=' + JSON.stringify(yearData) + '&yearSelect=' + year;
        var yearChartUrl = 'https://quickchart.io/chart?w=500&h=300&c=' + encodeURIComponent(JSON.stringify(yearChart)) + '&format=pdf';
        // var yearChartUrl .= '&c=' . urlencode(json_encode(yearChart)) . '&format=pdf';
        // console.log(yearChartUrl);
        // var chartUrl = '/quickchart' + queryString;
        
        link.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent the default link behavior
            window.open(yearChartUrl, '_blank'); // Open the URL in a new tab
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        var yearChartLabels = yearData.map(function(user) {
            return user.fullname;
        });
        var yearChartData = yearData.map(function(user) {
            return user.ibadah_count;
        });
        // console.log(yearData);
        var yearChart = {
            type: 'pie',
            data: {
                labels: yearChartLabels,
                datasets: [
                    {
                        label: 'Ibadah Count',
                        data: yearChartData,
                        backgroundColor: dynamicYearBackgroundColors,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                    },
                ],
            },
        };
        var link = document.getElementById('jemaatYearPieChart');
        // var queryString = '?yearData=' + JSON.stringify(yearData) + '&yearSelect=' + year;
        var yearChartUrl = 'https://quickchart.io/chart?w=500&h=300&c=' + encodeURIComponent(JSON.stringify(yearChart)) + '&format=pdf';
        // var yearChartUrl .= '&c=' . urlencode(json_encode(yearChart)) . '&format=pdf';
        // console.log(yearChartUrl);
        // var chartUrl = '/quickchart' + queryString;
        
        link.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent the default link behavior
            window.open(yearChartUrl, '_blank'); // Open the URL in a new tab
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        var jemaatChartLabels = userData.map(function(user) {
            return user.fullname;
        });
        var jemaatChartData = userData.map(function(user) {
            return user.ibadah_count;
        });
        // console.log(jemaatData);
        var monthChart = {
            type: 'bar',
            data: {
                labels: jemaatChartLabels,
                datasets: [
                    {
                        label: 'Ibadah Count',
                        data: jemaatChartData,
                        backgroundColor: dynamicMonthBackgroundColors,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                    },
                ],
            },
        };
        var link = document.getElementById('jemaatMonthChart');
        // var queryString = '?yearData=' + JSON.stringify(yearData) + '&yearSelect=' + year;
        var monthChartUrl = 'https://quickchart.io/chart?w=500&h=300&c=' + encodeURIComponent(JSON.stringify(monthChart)) + '&format=pdf';
        // var yearChartUrl .= '&c=' . urlencode(json_encode(yearChart)) . '&format=pdf';
        // console.log(yearChartUrl);
        // var chartUrl = '/quickchart' + queryString;
        
        link.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent the default link behavior
            window.open(monthChartUrl, '_blank'); // Open the URL in a new tab
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        var jemaatChartLabels = userData.map(function(user) {
            return user.fullname;
        });
        var jemaatChartData = userData.map(function(user) {
            return user.ibadah_count;
        });
        // console.log(jemaatData);
        var monthChart = {
            type: 'pie',
            data: {
                labels: jemaatChartLabels,
                datasets: [
                    {
                        label: 'Ibadah Count',
                        data: jemaatChartData,
                        backgroundColor: dynamicMonthBackgroundColors,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                    },
                ],
            },
        };
        var link = document.getElementById('jemaatMonthPieChart');
        // var queryString = '?yearData=' + JSON.stringify(yearData) + '&yearSelect=' + year;
        var monthChartUrl = 'https://quickchart.io/chart?w=500&h=300&c=' + encodeURIComponent(JSON.stringify(monthChart)) + '&format=pdf';
        // var yearChartUrl .= '&c=' . urlencode(json_encode(yearChart)) . '&format=pdf';
        // console.log(yearChartUrl);
        // var chartUrl = '/quickchart' + queryString;
        
        link.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent the default link behavior
            window.open(monthChartUrl, '_blank'); // Open the URL in a new tab
        });
    });



    var monthName;
    if (month) {
        // Split the date into year and month parts
        var parts = month.split('-');
        var year = parts[0];
        var monthNumber = parseInt(parts[1], 10);

        // Array of month names
        var monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June', 'July',
            'August', 'September', 'October', 'November', 'December'
        ];

        // Get the month name
        monthName = monthNames[monthNumber - 1];
    }
    var labels = userData.map(function(user) {
        return user.fullname;
    });
    var data = userData.map(function(user) {
        return user.ibadah_count;
    });
    var ctx = document.getElementById('userActivityChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Ibadah Count',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: monthName
                    }
                },
                y: {
                    beginAtZero: false,
                    min: 0,
                    stepSize: 1,
                    callback: function(value) {
                        if (Number.isInteger(value)) {
                            return value;
                        }
                    }
                }
            }
        }
    });
    // Chart for the yearly data
    var yearLabels = yearData.map(function(user) {
        return user.fullname;
    });
    var yearChartData = yearData.map(function(user) {
        return user.ibadah_count;
    });
    var ctx = document.getElementById('userActivityYearChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: yearLabels,
            datasets: [{
                label: 'Ibadah Count',
                data: yearChartData,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: year
                    }
                },
                y: {
                    beginAtZero: false,
                    min: 0,
                    stepSize: 1,
                    callback: function(value) {
                        if (Number.isInteger(value)) {
                            return value;
                        }
                    }
                }
            }
        }
    });
</script>

@endsection

