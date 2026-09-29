<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CountryServices;
use App\Models\CountryMaster;

class CountryServicesController extends Controller
{
    public function index($iCountryId)
    {
        $country = CountryMaster::findOrFail($iCountryId);
        $countryservices = CountryServices::where('iCountryId', $iCountryId)
            ->where('isDelete', 0)->orderBy('iCountryServiceId','desc')->paginate(10);

        return view('admin.countryservices.index', compact('country', 'countryservices'));
    }

    public function create($iCountryId)
    {
        $country = CountryMaster::findOrFail($iCountryId);
        return view('admin.countryservices.create-edit', compact('country'));
    }

        public function store(Request $request, $iCountryId)
    {
        $country = CountryMaster::findOrFail($iCountryId);
    
        $request->validate([
            'strTitle' => 'required',
            'strPhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        $data = $request->only(['strTitle', 'strDescription', 'iStatus']);
        $data['iCountryId'] = $iCountryId;
    
        $uploadPath = base_path('../public_html/egate_overseas/countryservices');
    
        if ($request->hasFile('strPhoto')) {
            $file = $request->file('strPhoto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $data['strPhoto'] = $filename;
        }
    
        CountryServices::create($data);
        return redirect()->route('admin.countryservices.index', $iCountryId)->with('success', 'country Service added successfully.');
    }


    public function show($iCountryServiceId)
    {
        $countryservices = CountryServices::findOrFail($iCountryServiceId);
        return view('admin.countryservices.index', compact('countryservices'));
    }

    public function edit($iCountryServiceId)
    {
        $countryservices = CountryServices::findOrFail($iCountryServiceId);
        $country = $countryservices->country;
        
        return view('admin.countryservices.create-edit', compact('countryservices', 'country'));
    }

    public function update(Request $request, $iCountryServiceId)
    {
        $countryservices = CountryServices::findOrFail($iCountryServiceId);
    
        $request->validate([
            'strTitle' => 'required',
            'strPhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        $data = $request->only(['strTitle', 'strDescription', 'iStatus']);
        $uploadPath = base_path('../public_html/egate_overseas/countryservices');
    
        if ($request->hasFile('strPhoto')) {
            if ($countryservices->strPhoto && file_exists($uploadPath . '/' . $countryservices->strPhoto)) {
                unlink($uploadPath . '/' . $countryservices->strPhoto);
            }
    
            $file = $request->file('strPhoto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $data['strPhoto'] = $filename;
        }
    
        $countryservices->update($data);
        return redirect()->route('admin.countryservices.index', $countryservices->iCountryId)->with('success', 'country Service updated successfully.');
    }


    public function destroy($iCountryServiceId)
    {
        $countryservices = CountryServices::findOrFail($iCountryServiceId);
        if ($countryservices->strPhoto && file_exists(base_path('../public_html/egate_overseas/countryservices/' . $countryservices->strPhoto))) {
            unlink(base_path('../public_html/egate_overseas/countryservices/' . $countryservices->strPhoto));
        }
        $countryservices->update(['isDelete' => 1]);
        return response()->json(['success' => true]);
    }

    public function bulkDelete(Request $request)
{
    $ids = $request->ids;
    $uploadPath = base_path('../public_html/egate_overseas/countryservices');

    if (!$ids || !is_array($ids)) {
        return response()->json(['success' => false, 'message' => 'No items selected.']);
    }

    $countryservicess = CountryServices::whereIn('iCountryServiceId', $ids)->get();

    foreach ($countryservicess as $countryservices) {
        if ($countryservices->strPhoto && file_exists($uploadPath . '/' . $countryservices->strPhoto)) {
            unlink($uploadPath . '/' . $countryservices->strPhoto);
        }

        if ((new countryservices)->getConnection()->getSchemaBuilder()->hasColumn('countryservices', 'isDelete')) {
            $countryservices->update(['isDelete' => 1]);
        } else {
            $countryservices->delete();
        }
    }

    return response()->json(['success' => true]);
}

}
