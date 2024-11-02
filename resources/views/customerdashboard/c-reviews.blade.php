@extends('layouts.masterlayout.userdashboardlayout')
@section('page_title', 'Review')
@section('content')

<div class="container-fluid mt-5 pt-5">
    <div class="row justify-content-center">
        <!-- Main Content Area for Reviews -->
        <main class="col-md-10 pt-5">
            <div class="row">
                <!-- Leave a Review Section -->
                <div class="col-md-7">
                    <div class="review-form bg-white p-4 shadow-sm rounded">
                        <h3 class="text-center text-uppercase mb-4">Leave a Review</h3>
                        <p class="text-center mb-4">We'd love to hear your thoughts!</p>

                        <!-- Review Form -->
                        <form>
                            <div class="mb-3">
                                <label for="userRating" class="form-label">Your Rating</label>
                                <select class="form-control" id="userRating">
                                    <option value="">Select Rating</option>
                                    <option value="5">5 - Excellent</option>
                                    <option value="4">4 - Very Good</option>
                                    <option value="3">3 - Average</option>
                                    <option value="2">2 - Poor</option>
                                    <option value="1">1 - Terrible</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="userComment" class="form-label">Your Comment</label>
                                <textarea class="form-control" id="userComment" rows="4" placeholder="Write your comment here"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Submit Review</button>
                        </form>
                    </div>
                </div>

                <!-- Other Reviews Section -->
                <div class="col-md-5">
                    <div class="other-reviews bg-white p-4 shadow-sm rounded">
                        <h4 class="text-center text-uppercase mb-4">Other Reviews</h4>

                        <div class="review-item bg-light p-3 shadow-sm mb-3 rounded">
                            <h5>Harnelle Castro <span class="text-muted">(5/5)</span></h5>
                            <p class="mb-1">"Great experience! Highly recommend."</p>
                            <small class="text-muted">Posted on: 2024-09-10</small>
                        </div>

                        <div class="review-item bg-light p-3 shadow-sm mb-3 rounded">
                            <h5>Marie Frauline Delacruz <span class="text-muted">(4/5)</span></h5>
                            <p class="mb-1">"Good service, but there's room for improvement."</p>
                            <small class="text-muted">Posted on: 2024-09-08</small>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

@endsection
