<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Inter', sans-serif;
            color: #1f2a44;
        }
        .container {
            max-width: 15000px;
            padding: 2rem;
        }
        .header {
            text-align: center;
            margin-bottom: 3rem;
        }
        .header h1 {
            font-size: 2.25rem;
            font-weight: 700;
            color: #1f2a44;
        }
        .header p {
            font-size: 1rem;
            color: #6b7280;
        }
        .card {
            border: none;
            border-radius: 1rem;
            background: #ffffff;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .form-card {
            padding: 1.5rem;
        }
        .form-label {
            font-weight: 600;
            color: #374151;
            font-size: 0.9rem;
        }
        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            padding: 0.5rem;
            font-size: 0.95rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .btn-primary {
            background-color: #3b82f6;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #2563eb;
        }
        .btn-success {
            background-color: #3b82f6;
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.95rem;
        }
        .btn-success:hover {
            background-color: #2563eb;
        }
        .employee-card {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
        }
        .employee-card h5 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1f2a44;
            margin-bottom: 0.5rem;
        }
        .employee-card p {
            font-size: 0.9rem;
            color: #4b5563;
            margin-bottom: 0.5rem;
        }
        .employee-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        .alert {
            border-radius: 0.5rem;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
        }
        .alert-info {
            background-color: #e0f2fe;
            color: #1e40af;
        }
        .modal-content {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }
        .modal-header, .modal-footer {
            border: none;
        }
        .modal-title {
            font-weight: 700;
            color: #1f2a44;
        }
        .modal-body {
            color: #4b5563;
            font-size: 0.95rem;
        }
        .employee-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 1rem;
        }
        .employee-details {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <header class="header">
            <h1>Employee Management</h1>
            <p>Seamlessly manage your team and payroll information</p>
        </header>

        <div id="successAlert" class="alert alert-success alert-dismissible fade d-none text-center" role="alert">
            All employees have been paid successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-md-5">
                <div class="card form-card">
                    <h4 class="card-title text-center mb-4">Add New Employee To Payroll</h4>
                    <form action="{{ route('employees.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="id_number" class="form-label">ID Number</label>
                            <input type="text" class="form-control" id="id_number" name="id_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="nssf_number" class="form-label">NSSF Number</label>
                            <input type="text" class="form-control" id="nssf_number" name="nssf_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="payroll_number" class="form-label">Payroll Number</label>
                            <input type="text" class="form-control" id="payroll_number" name="payroll_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="salary" class="form-label">Salary</label>
                            <input type="number" step="0.01" class="form-control" id="salary" name="salary" required>
                        </div>
                        <div class="mb-4">
                            <label for="date_of_joining" class="form-label">Date of Joining</label>
                            <input type="date" class="form-control" id="date_of_joining" name="date_of_joining" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Employee</button>
                    </form>
                </div>
            </div>

            <div class="col-md-7">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold m-0">Current Employees</h3>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmPayModal">
                        Pay All Employees
                    </button>
                </div>
                
                <div class="mb-4">
                    <input type="text" id="employeeSearch" class="form-control" placeholder="Search employees...">
                </div>

                @if($employees->isEmpty())
                    <div class="alert alert-info text-center" role="alert">
                        No employees found. Add your first employee to get started!
                    </div>
                @else
                    <div class="employee-grid">
                        @foreach($employees as $employee)
                        <div class="card employee-card">
                            <img src="https://controlio.net/i/svg/brand-figure.svg" alt="Employee Avatar" class="employee-avatar">
                            <div class="employee-details">
                                <h5>{{ $employee->first_name }} {{ $employee->last_name }}</h5>
                                <p><strong>Email:</strong> {{ $employee->email }}</p>
                                <p><strong>ID Number:</strong> {{ $employee->id_number }}</p>
                                <p><strong>NSSF Number:</strong> {{ $employee->nssf_number }}</p>
                                <p><strong>Payroll Number:</strong> {{ $employee->payroll_number }}</p>
                                <p><strong>Salary:</strong> ${{ number_format($employee->salary, 2) }}</p>
                                <p><strong>Joined:</strong> {{ $employee->date_of_joining }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmPayModal" tabindex="-1" aria-labelledby="confirmPayModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmPayModalLabel">Confirm Mass Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to proceed with paying all employees? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmPayButton">Yes, Pay All</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('confirmPayButton').addEventListener('click', function() {
            const modal = bootstrap.Modal.getInstance(document.getElementById('confirmPayModal'));
            modal.hide();
            const successAlert = document.getElementById('successAlert');
            successAlert.classList.remove('d-none');
            successAlert.classList.add('show');
            setTimeout(() => {
                successAlert.classList.remove('show');
                successAlert.classList.add('fade');
                setTimeout(() => {
                    successAlert.classList.add('d-none');
                    successAlert.classList.remove('fade');
                }, 150);
            }, 3000);
        });

        // Live search functionality
        document.getElementById('employeeSearch').addEventListener('keyup', function(e) {
            const searchQuery = e.target.value.toLowerCase();
            const employeeCards = document.querySelectorAll('.employee-card');

            employeeCards.forEach(card => {
                const cardText = card.textContent.toLowerCase();
                if (cardText.includes(searchQuery)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>