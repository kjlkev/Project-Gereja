<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gereja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <!-- Or for RTL support -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

  </head>
  <body>
    
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar" class="">
            <div class="sidebar-header text-center">
                <h3 class="mt-4 mb-5">Gereja</h3>
            </div>

            <ul class="list-unstyled components">
                @if(Auth::user()->is_admin)
                    <li>
                        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false"
                            class="dropdown-toggle">Dashboard</a>
                        <ul class="collapse list-unstyled" id="homeSubmenu">
                            <li>
                                <a href="/dashboard/jemaat">Jemaat</a>
                            </li>
                            <li>
                                <a href="/dashboard/usher">Usher</a>
                            </li>
                            <li>
                                <a href="/dashboard/avl">Audio Visual</a>
                            </li>
                            <li>
                                <a href="/dashboard/pemusik">Pemusik</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="/daftar-jemaat">Daftar Jemaat</a>
                    </li>
                    <li>
                        <a href="/jadwal-ibadah">Jadwal Ibadah</a>
                    </li>
                    <li>
                        <a href="/jadwal-pengajaran">Jadwal Pengajaran</a>
                    </li>
                    <li>
                        <a href="/finance">Finance</a>
                    </li>
                @else
                    <li>
                        <a href="/jadwal-ibadah">Jadwal Ibadah</a>
                    </li>
                    <li>
                        <a href="/jadwal-pengajaran">Jadwal Pengajaran</a>
                    </li>
                @endif
            </ul>

        </nav>

        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                     <!-- Current date -->
                    <span class="navbar-text fs-5" id="currentDate" style="color: #000; font-weight: 400;" >
                        <!-- Date will be displayed here -->
                    </span>

                    <!-- Current time with seconds -->
                    <span class="navbar-text ml-2 fs-5" id="currentTime" style="color: #000; font-weight: 400;">
                        <!-- Time will be displayed here -->
                    </span>

                    <!-- Dropdown button for profile and logout -->
                    <div class="ms-auto pr-3">
                        <div class="dropdown">
                            <a class="text-decoration-none" role="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <!-- This button triggers the dropdown menu -->
                                <p class="fs-5 m-0" style="color: #000; font-weight: 400;">
                                    Hello, {{ Auth::user()->username}}
                                </p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <!-- Add user-related links here -->
                                <a class="dropdown-item" href="/profile">Profile</a>
                                <div class="dropdown-divider"></div>
                                <form action="/logout" method="POST" >
                                    @csrf
                                    <button class="dropdown-item" type="submit">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="container-fluid">
                @yield('content')
            </div>

            
        </div>
    </div>
    <script>    
        // Function to update the current date and time with seconds
        function updateDateTime() {
            var currentDateElement = document.getElementById("currentDate");
            var currentTimeElement = document.getElementById("currentTime");

            var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            var currentDate = new Date().toLocaleDateString('en-US', options);

            var currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });

            currentDateElement.textContent = currentDate;
            currentTimeElement.textContent = currentTime;
        }

        // Update the date and time every second
        setInterval(updateDateTime);

        // Call the function to initially set the date and time
        updateDateTime();
    </script>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
  
</html>