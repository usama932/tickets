<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Feature;

class FeatureController extends Controller
{

    
    public function create($package_id)
    {
        $package = Package::findOrFail($package_id);

        return view('packages', compact('package'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'package_id' => 'required|exists:packages,id',
        ]);
        
        $feature = new Feature([
            'title' => $request->get('title'),
            'package_id' => $request->get('package_id'),
            'status' => 'inactive',
        ]);

        $feature->save();

        return redirect('packages')->with('success', 'Feature has been added');
    }
}

