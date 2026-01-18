<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Driver</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .form-card { max-width: 600px; margin: 50px auto; }
    </style>
</head>
<body>
    <!-- ناف بار مشابه -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a href="/manger" class="navbar-brand">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
            <span class="text-white">Add New Driver</span>
        </div>
    </nav>

    <div class="container">
        <div class="card form-card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-user-tie"></i> Add New Driver</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('drivers.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <!-- Personal Information -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name *</label>
                            <input type="text" class="form-control" name="name" required
                                   placeholder="e.g., Ahmed Mohammed">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" class="form-control" name="email" required
                                   placeholder="e.g., ahmed@example.com">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number *</label>
                            <input type="tel" class="form-control" name="phone" required
                                   placeholder="e.g., 0551234567">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">License Number *</label>
                            <input type="text" class="form-control" name="license_number" required
                                   placeholder="e.g., DRV-2023-001">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">License Expiry Date</label>
                            <input type="date" class="form-control" name="license_expiry">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hire Date</label>
                            <input type="date" class="form-control" name="hire_date"
                                   value="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Assign Bus</label>
                            <select class="form-select" name="bus_id">
                                <option value="">-- No Bus Assigned --</option>
                                <option value="1">BUS-101 (45 seats)</option>
                                <option value="2">BUS-102 (50 seats)</option>
                                <option value="3">BUS-103 (40 seats)</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="active" selected>Active</option>
                                <option value="on_leave">On Leave</option>
                                <option value="suspended">Suspended</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="address" rows="2"
                                  placeholder="Full address..."></textarea>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="has_training" id="training">
                            <label class="form-check-label" for="training">
                                Completed Safety Training
                            </label>
                        </div>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Emergency Contact</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control" name="emergency_name"
                                           placeholder="Contact Name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="tel" class="form-control" name="emergency_phone"
                                           placeholder="Contact Phone">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between">
                        <a href="/manger" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Add Driver
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // License number auto-format مشان رقم الرخصة
        document.querySelector('[name="license_number"]').addEventListener('input', function(e) {
            let value = e.target.value.toUpperCase();
            if (!value.startsWith('DRV-')) {
                e.target.value = 'DRV-' + value.replace('DRV-', '');
            }
        });
    </script>
</body>
</html>
