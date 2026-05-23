<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
     public function index()
    {
        $districts = District::latest()->get();

        return view('district', compact('districts'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'district_name' => 'required'
        ]);

        District::create([
            'district_name' => $request->district_name
        ]);

        return redirect()->back()
            ->with('success', 'District added successfully');
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'district_name' => 'required'
        ]);

        $district = District::findOrFail($id);

        $district->update([
            'district_name' => $request->district_name
        ]);

        return redirect()->back()
            ->with('success', 'District updated successfully');
    }

    // Delete data
    public function destroy($id)
    {
        $district = District::findOrFail($id);

        $district->delete();

        return redirect()->back()
            ->with('success', 'District deleted successfully');
    }
}
