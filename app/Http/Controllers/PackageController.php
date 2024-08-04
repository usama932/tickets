<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;


class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return view('packages', compact('packages'));
    }
    public function subrip()
    {
        $all_packages = Package::all();
        return view('subcrip', compact('all_packages'));
    }

    public function create()
    {
        return view('packages.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'level1_commission' => 'nullable|numeric|min:0',
            'level2_commission' => 'nullable|numeric|min:0',
        ]);

        $package = Package::create($validatedData);

        return redirect('/packages')->with('success', 'Package has been added');
    }

    public function edit($id)
    {
        $package = Package::find($id);

        return view('packages.edit', compact('package'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        $package = Package::find($id);
        $package->name = $request->get('name');
        $package->description = $request->get('description');
        $package->price = $request->get('price');
        $package->save();

        return redirect('/packages')->with('success', 'Package has been updated');
    }

    public function destroy($id)
    {
        $package = Package::find($id);
        $package->delete();

        return redirect('/packages')->with('success', 'Package has been deleted Successfully');
    }
}
