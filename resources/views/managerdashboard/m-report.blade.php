@extends('layouts.manager')

@section('content')

<!-- Search Criteria for bookings -->
<div class="container my-4">
    <div class="card shadow-sm p-4">
        <h4 class="text-center mb-4">Search Bookings</h4>
        <form method="GET" action="">
            <div class="row">
                <div class="col-md-3">
                    <label for="userName">Search by Customer Name:</label>
                    <input type="text" class="form-control" id="userName" placeholder="Input User Name" name="userName">
                </div>
                <div class="col-md-3">
                    <label for="status">Search by Booking Status:</label>
                    <select class="form-control" id="status" name="status">
                        <option value="">Select Status</option>
                        <option value="Approved">Approved</option>
                        <option value="Reject">Rejected</option>
                        <option value="waiting">Waiting</option>
                        <option value="Cancelled">Cancelled</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status">Search by Payment Status:</label>
                    <select class="form-control" id="status" name="status">
                        <option value="">Select Status</option>
                        <option value="Paid">Paid</option>
                        <option value="Pending">Pending</option>
                        <option value="Not Paid">Not Paid</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="phone_no">Search by Phone Number:</label>
                    <input type="text" class="form-control" id="phone_no" placeholder="Input Phone Number" name="phone_no">
                </div>
                <div class="col-md-3">
                    <label for="unit">Search by Unit:</label>
                    <input type="text" class="form-control" id="unit" placeholder="Input Unit" name="unit">
                </div>
                <div class="col-md-3">
                    <label for="email">Search by Email:</label>
                    <input type="text" class="form-control" id="email" placeholder="Input Email" name="email">
                </div>
                <div class="col-md-3">
                    <label for="startDate">Check-in Date</label>
                    <input type="date" class="form-control" id="startDate" name="startDate">
                </div>
                <div class="col-md-3">
                    <label for="endDate">Check-out Date</label>
                    <input type="date" class="form-control" id="endDate" name="endDate">
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Booking Table -->
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-dark d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-white">Booking Reports</h5>
            <div>
                <a href="#" class="btn btn-success me-2">Generate Report</a>
                <a href="#" class="btn btn-info">View Record</a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <!-- Table Headers -->
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Booking ID</th>
                            <th scope="col">User ID</th>
                            <th scope="col">Unit ID</th>
                            <th scope="col">Status</th>  <!-- Booking Status -->
                            <th scope="col">Customer Name</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Email</th>
                            <th scope="col">Number of Guests</th>
                            <th scope="col">Check-in Date</th>
                            <th scope="col">Check-in Time</th>
                            <th scope="col">Check-out Date</th>
                            <th scope="col">Check-out Time</th>
                            <th scope="col">Total Payment</th>
                            <th scope="col">Payment Status</th> <!-- payment Status -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example Row 1 -->
                        <tr>
                            <td>1001</td>
                            <td>200</td>
                            <td>A101</td>
                            <td><span class="badge bg-primary">Approved</span></td>
                            <td>Jann Ryn Gay-as</td>
                            <td>+1-555-555-5555</td>
                            <td>jann@gmail.com</td>
                            <td>2</td>
                            <td>2024-09-15</td>
                            <td>14:00</td>
                            <td>2024-09-20</td>
                            <td>12:00</td>
                            <td>2500</td>
                            <td><span class="badge bg-success">Paid</span></td>
                        </tr>

                        <!-- Example Row 2 -->
                        <tr>
                            <td>1002</td>
                            <td>201</td>
                            <td>A102</td>
                            <td><span class="badge bg-danger">Rejected</span></td>
                            <td>harnelle Castro</td>
                            <td>+1-555-123-4567</td>
                            <td>harnelle@gmail.com</td>
                            <td>3</td>
                            <td>2024-09-16</td>
                            <td>15:00</td>
                            <td>2024-09-22</td>
                            <td>11:00</td>
                            <td>2500</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                        </tr>

                        <!-- Example Row 3 -->
                        <tr>
                            <td>1003</td>
                            <td>202</td>
                            <td>B103</td>
                            <td><span class="badge bg-warning">Waiting</span></td>
                            <td>Marie Frauline Dela Cruz</td>
                            <td>+1-555-987-6543</td>
                            <td>marie@gmail.com</td>
                            <td>1</td>
                            <td>2024-09-18</td>
                            <td>16:00</td>
                            <td>2024-09-23</td>
                            <td>11:00</td>
                            <td>2500</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                        </tr>

                        <!-- Example Row 4 -->
                        <tr>
                            <td>1004</td>
                            <td>203</td>
                            <td>B104</td>
                            <td><span class="badge bg-secondary">Cancelled</span></td>
                            <td>Mary Joyce Ann Galliguez</td>
                            <td>+1-555-444-6789</td>
                            <td>mjann@gmail.com</td>
                            <td>4</td>
                            <td>2024-09-19</td>
                            <td>13:00</td>
                            <td>2024-09-25</td>
                            <td>11:00</td>
                            <td>2500</td>
                            <td><span class="badge bg-danger">Not Paid</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Static Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</div>

@endsection
