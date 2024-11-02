@extends('layouts.guest')
@section('content')

<div class="container mt-5 pt-5">
    <!-- About Us Section -->
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="text-uppercase font-weight-bold mb-4 mt-5">About Us</h1>
            <p class="lead">
                Welcome to Pensionne Estela! Since <strong>2002</strong>, we have offered personalized services, ensuring our guests enjoy comfort and convenience during their stay.
            </p>
        </div>
    </div>

    <!-- Why Choose Us Section -->
    <div class="row mt-5 text-center">
        <div class="col-md-12">
            <h2 class="text-uppercase font-weight-bold mb-4">Why Choose Us?</h2>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-light shadow-sm py-4">
                <i class="bi bi-house-door-fill h1 text-primary mb-3"></i>
                <h5 class="text-uppercase">Comfortable Rooms</h5>
                <p>Modern and well-equipped designed for your comfort.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-light shadow-sm py-4">
                <i class="bi bi-people-fill h1 text-primary mb-3"></i>
                <h5 class="text-uppercase">Friendly Staff</h5>
                <p>Our attentive and welcoming staff, always here to assist you.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-light shadow-sm py-3">
                <i class="bi bi-geo-alt-fill h1 text-primary mb-3"></i>
                <h5 class="text-uppercase">Convenient Location</h5>
                <p>Located close to major attractions, ensuring easy access and transportation.</p>
            </div>
        </div>
    </div>

    <!-- Location Section -->
    <div class="row mt-5 text-center">
        <div class="col-md-12">
            <h2 class="text-uppercase font-weight-bold mb-4">Location</h2>
        </div>
        <div class="col-md-12">
            <div class="map-responsive mx-auto" style="max-width: 600px;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3827.121928515258!2d120.57459767388212!3d16.41863282999196!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3391a1acca18388b%3A0xd58215a005243235!2sPensionne%20Estela!5e0!3m2!1sen!2sph!4v1714650722413!5m2!1sen!2sph"
                    width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</div>
@endsection
