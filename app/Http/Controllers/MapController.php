<?php
namespace App\Http\Controllers;


use App\Models\location;
use Illuminate\Http\Request;

class MapController extends Controller 
{ 
    public function index() 
    { $locations = location::all(); // Récupère toutes les coordonnées 
    return view('map', compact('locations')); 
    } 
    };