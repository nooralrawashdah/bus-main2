<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Bus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .form-card { max-width: 600px; margin: 50px auto; }
    </style>
</head>
<body>
    <!-- ناف بار مشابه للمانجر -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a href="/manger" class="navbar-brand">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            <span class="text-white">Add New Bus</span>
        </div>
    </nav>

    <div class="container">
        <div class="card form-card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="fas fa-bus"></i> Add New Bus</h4>
            </div>
            <div class="card-body">
               <!-- <form action="{{ route('buses.store') }}" method="POST"> 
                    @csrf

                    <div class="row">
                        <!-- Bus Information -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bus Number *</label>
                            <input type="text" class="form-control" name="bus_number" required
                                   placeholder="e.g., BUS-101">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">License Plate *</label>
                            <input type="text" class="form-control" name="license_plate" required
                                   placeholder="e.g., ABC-123">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Capacity *</label>
                            <input type="number" class="form-control" name="capacity" required
                                   min="10" max="100" value="45">
                            <small class="text-muted">Number of seats</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bus Type</label>
                            <select class="form-select" name="type">
                                <option value="regular">Regular</option>
                                <option value="coach">Coach</option>
                                <option value="minibus">Minibus</option>
                                <option value="double_decker">Double Decker</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Manufacturer</label>
                            <input type="text" class="form-control" name="manufacturer"
                                   placeholder="e.g., Mercedes">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Model Year</label>
                            <input type="number" class="form-control" name="model_year"
                                   min="2000" max="2024" value="2020">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Assign Driver</label>
                        <select class="form-select" name="driver_id">
                            <option value="">-- Select Driver --</option>
                            <option value="1">Ahmed Mohammed (DRV-001)</option>
                            <option value="2">Mohammed Ali (DRV-002)</option>
                            <option value="3">Khalid Ahmed (DRV-003)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="active" selected>Active</option>
                            <option value="maintenance">Under Maintenance</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" rows="3"
                                  placeholder="Any additional notes..."></textarea>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between">
                        <a href="/manger" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Save Bus
                        </button>
                    </div>
                </form>
            
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const busNumber = document.querySelector('[name="bus_number"]').value;
            if (!busNumber.startsWith('BUS-')) {
                alert('Bus number should start with BUS-');
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
