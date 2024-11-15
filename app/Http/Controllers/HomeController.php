<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Unit;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function homepage()
    {
        $units = Unit::with(['amenities', 'photos'])->get();
        $photos = Photo::inRandomOrder()->take(10)->get();
        return view('home.homepage', compact('units', 'photos'));
    }

    public function units()
    {
        $units = Unit::with(['amenities', 'photos'])->get();
        return view('home.home-units', compact('units'));
    }

    public function gallery()
    {
        return view('home.home-gallery');
    }

    public function about()
    {
        return view('home.home-about');
    }
}
