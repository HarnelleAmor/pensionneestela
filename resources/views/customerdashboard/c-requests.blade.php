@extends('layouts.masterlayout.userdashboardlayout')

@section('page_title', 'Request Services')

@section('content')

<!-- Request Services Section -->
<div class="request-services-section py-5">
    <div class="container mt-5 pt-5">
        <!-- Title and Intro -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="titlepage text-center">
                    <h2>Request Services</h2>
                    <p>Select a service below to request or provide details for a new service request.</p>
                </div>
            </div>
        </div>

        <!-- Available Services -->
        <div class="row mt-4">
            <!-- Service 1 -->
            <div class="col-md-4 mb-4">
                <div class="service-card p-3 border bg-light shadow-sm">
                    <div class="service-image text-center">
                        <img src="{{ asset('images/banner1.jpg') }}" alt="Service 1 Image" class="img-fluid" style="height:200px; width:100%; object-fit: cover;">
                    </div>
                    <div class="service-details mt-3 text-center">
                        <h4>Cleaning Services</h4>
                        <p>baka tamad ka maglinis ng unit mo, magpalinis ka nalang</p>
                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#serviceModal" data-service="1">Request Service</button>
                    </div>
                </div>
            </div>

            <!-- Service 2 -->
            <div class="col-md-4 mb-4">
                <div class="service-card p-3 border bg-light shadow-sm">
                    <div class="service-image text-center">
                        <img src="{{ asset('images/banner2.jpg') }}" alt="Service 2 Image" class="img-fluid" style="height:200px; width:100%; object-fit: cover;">
                    </div>
                    <div class="service-details mt-3 text-center">
                        <h4>Cooking Services</h4>
                        <p>Pwede magpaluto kung tamad kayo magluto, bayad nlng service fee</p>
                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#serviceModal" data-service="2">Request Service</button>
                    </div>
                </div>
            </div>

            <!-- Service 3 -->
            <div class="col-md-4 mb-4">
                <div class="service-card p-3 border bg-light shadow-sm">
                    <div class="service-image text-center">
                        <img src="{{ asset('images/banner3.jpg') }}" alt="Service 3 Image" class="img-fluid" style="height:200px; width:100%; object-fit: cover;">
                    </div>
                    <div class="service-details mt-3 text-center">
                        <h4>Request Ammenities</h4>
                        <p>Kulang kayo ng higaan kasi sabi 6 lang eh. edi request na kayo extra foam. </p>
                        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#serviceModal" data-service="3">Request Service</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Service Request Modal -->
<div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceModalLabel">Request Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>    

                    <!-- Description -->
                    <div class="form-group mb-3">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" class="form-control" rows="3" placeholder="Provide details about your request" required></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary w-100">Submit Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection


