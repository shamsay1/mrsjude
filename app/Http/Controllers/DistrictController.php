<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;
use Exception;

class DistrictController extends Controller
{
     public function index()
    {
        $districts = District::latest()->get();

        return view('district', compact('districts'));
    }
    public function store(Request $request)
{
    try {

        $request->validate([
            'district_name' => 'required'
        ]);

        District::create([
            'district_name' => $request->district_name
        ]);

        return redirect()->back()
            ->with('success', 'District added successfully');

    } catch (Exception $e) {

        return redirect()->back()
            ->with('error', $e->getMessage());

        
    }
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

    // DeActive data
    public function toggleStatus($id)
{
    $district = District::findOrFail($id);

    $district->status = $district->status == 'Active'
        ? 'Deactive'
        : 'Active';

    $district->save();

    return redirect()->back()
        ->with('success', 'District status updated successfully.');
}
}
