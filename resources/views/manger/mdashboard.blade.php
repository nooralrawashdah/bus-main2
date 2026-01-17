@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bus Manager</title>

    <!-- Bootstrap  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


    <style>
        body { overflow-x: hidden; }
        #sidebar-wrapper { min-height: 100vh; margin-left: -15rem; transition: margin .25s ease-out; }
        #sidebar-wrapper .sidebar-heading { padding: 0.875rem 1.25rem; font-size: 1.2rem; }
        #sidebar-wrapper .list-group { width: 15rem; }
        #page-content-wrapper { min-width: 100vw; }
        #wrapper.toggled #sidebar-wrapper { margin-left: 0; }
        @media (min-width: 768px) {
            #sidebar-wrapper { margin-left: 0; }
            #page-content-wrapper { min-width: 0; width: 100%; }
            #wrapper.toggled #sidebar-wrapper { margin-left: -15rem; }
        }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark border-right" id="sidebar-wrapper" style="width: 250px;">
            <div class="sidebar-heading text-white bg-dark">
                <i class="fas fa-bus"></i> Bus System
            </div>
            <div class="list-group list-group-flush">
                <a href="/manger" class="list-group-item list-group-item-action bg-dark text-white">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="/buses" class="list-group-item list-group-item-action bg-dark text-white">
                    <i class="fas fa-bus"></i> Buses
                </a>
                <a href="/drivers" class="list-group-item list-group-item-action bg-dark text-white">
                    <i class="fas fa-users"></i> Drivers
                </a>
                <a href="/stations" class="list-group-item list-group-item-action bg-dark text-white">
                    <i class="fas fa-map-marker-alt"></i> Stations
                </a>
                <a href="/routes" class="list-group-item list-group-item-action bg-dark text-white">
                    <i class="fas fa-route"></i> Routes
                </a>
                <a href="/tickets" class="list-group-item list-group-item-action bg-dark text-white">
                    <i class="fas fa-ticket-alt"></i> Tickets
                </a>
                <a href="/reports" class="list-group-item list-group-item-action bg-dark text-white">
                    <i class="fas fa-chart-bar"></i> Reports
                </a>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <button class="btn btn-primary" id="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                                <i class="fas fa-user"></i> Manager
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Settings</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="container-fluid p-4">
                <h1 class="mt-4">Bus Management Dashboard</h1>

                <!-- Action Buttons -->
                <div class="row mb-4">
                    <div class="col-md-3">
                       <!-- <button class="btn btn-success btn-block">
                            <i class="fas fa-plus"></i> Add New situation
                        </button>-->
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('bus.buscreae') }}" class="btn btn-success btn-block">
                   <i class="fas fa-plus"></i> Add New Bus
                         </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('driver.drivercreat') }}" class="btn btn-primary btn-block">
                     <i class="fas fa-plus"></i> Add New Driver
                        </a>
                    </div>
                   <!-- <div class="col-md-3">
                        <button class="btn btn-warning btn-block">
                            <i class="fas fa-file-export"></i> Generate Report
                        </button>
                    </div>-->
                </div>

                <!-- Content Here -->
                <div class="card">
                    <div class="card-header">
                        <h5>Bus List</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Bus Number</th>
                                    <th>Driver</th>
                                    <th>Route</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>BUS-101</td>
                                    <td>Ahmed</td>
                                    <td>City Center - North</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                <a href="/test-edit/1" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i>
                </a>
                                        <button class="btn btn-sm btn-danger" onclick="deleteBus(1)"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar Toggle Script -->
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
        function deleteBus(busId) {
    if (confirm('Are you sure you want to delete bus #' + busId + '?')) {
        alert('Bus #' + busId + ' deleted successfully!');

    }
}
    </script>
</body>
</html>
@endsection
