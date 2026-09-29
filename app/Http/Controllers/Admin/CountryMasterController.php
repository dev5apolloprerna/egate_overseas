<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CountryMaster;
use Illuminate\Support\Str;

class CountryMasterController extends Controller
{
    public function index(Request $request)
    {
        $query = CountryMaster::where('isDelete', 0);

        if ($request->has('search')) {
            $query->where('strCountryName', 'like', '%' . $request->search . '%');
        }

        $country = $query->orderBy('iCountryId','desc')->paginate(10);
        return view('admin.countrymaster.index', compact('country'));
    }

    public function create()
    {
        return view('admin.countrymaster.create-edit');
    }

   public function store(Request $request)
{
    $request->validate([
        'strCountryName' => 'required|unique:country_master,strCountryName',
        'strPhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $data = $request->only(['strCountryName', 'strH1Tag', 'strDescription', 'iStatus']);
    $data['strSlug'] = Str::slug($request->strCountryName);

    if ($request->hasFile('strPhoto')) {
        $file = $request->file('strPhoto');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(base_path('../public_html/egate_overseas/country'), $filename);
        $data['strPhoto'] = $filename;
    }

    CountryMaster::create($data);
    return redirect()->route('admin.countrymaster.index')->with('success', 'visa added successfully.');
}


    public function edit($strSlug)
    {
        $country = CountryMaster::where('strSlug', $strSlug)->firstOrFail();
        return view('admin.countrymaster.create-edit', compact('country'));
    }

    public function update(Request $request, $strSlug)
    {
        $country = CountryMaster::where('strSlug', $strSlug)->firstOrFail();
    
        $request->validate([
            'strCountryName' => 'required|unique:country_master,strCountryName,' . $country->iCountryId . ',iCountryId',
            'strPhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        $data = $request->only(['strCountryName', 'strH1Tag', 'strDescription', 'iStatus']);
        $data['strSlug'] = Str::slug($request->strCountryName);
    
        $uploadPath = base_path('../public_html/egate_overseas/country');
    
        if ($request->hasFile('strPhoto')) {
            if ($country->strPhoto && file_exists($uploadPath . '/' . $country->strPhoto)) {
                unlink($uploadPath . '/' . $country->strPhoto);
            }
    
            $file = $request->file('strPhoto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $data['strPhoto'] = $filename;
        }
    
        $country->update($data);
        return redirect()->route('admin.countrymaster.index')->with('success', 'visa updated successfully.');
    }


public function show(Request $request,$slug)
    {
        $query = CountryMaster::where('isDelete', 0);

        if ($request->filled('search')) {
            $query->where('strCountryName', 'like', '%' . $request->search . '%');
        }

        $specialties = $query->paginate(10);
        return view('admin.countrymaster.index', compact('specialties'));
    }
    public function destroy($strSlug)
    {
       
        $country = CountryMaster::where('strSlug', $strSlug)->firstOrFail();

        if ($country->strPhoto && file_exists(base_path('../public_html/egate_overseas/country/' . $country->strPhoto))) {
            unlink(base_path('../public_html/egate_overseas/country/'  . $country->strPhoto));
        }

        if ((new country_master)->getConnection()->getSchemaBuilder()->hasColumn('country_master', 'isDelete')) {
            $country->update(['isDelete' => 1]);
        } else {
            $country->delete();
        }

        return response()->json(['success' => true]);
    }

public function bulkDelete(Request $request)
{
    $slugs = $request->ids;
    $uploadPath = base_path('../public_html/egate_overseas/country');

    if (!$slugs || !is_array($slugs)) {
        return response()->json(['success' => false, 'message' => 'No items selected.']);
    }

    foreach ($slugs as $slug) {
        $record = CountryMaster::where('strSlug', $slug)->first(); // Do NOT use firstOrFail()

        if ($record) {
            // Delete all related otherDetails
            foreach ($record->countryservices as $detail) {
                if ($detail->strPhoto && file_exists($uploadPath . '/' . $detail->strPhoto)) {
                    unlink($uploadPath . '/' . $detail->strPhoto);
                }
                $detail->update(['isDelete' => 1]);
            }

            // Unlink visa photo
            if ($record->strPhoto && file_exists($uploadPath . '/' . $record->strPhoto)) {
                unlink($uploadPath . '/' . $record->strPhoto);
            }

            // Soft or hard delete parent
            if ((new VisaMaster)->getConnection()->getSchemaBuilder()->hasColumn('country_master', 'isDelete')) {
                $record->update(['isDelete' => 1]);
            } else {
                $record->delete();
            }
        }
    }

    return response()->json(['success' => true]);
}




}
