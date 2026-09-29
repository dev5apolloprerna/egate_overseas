<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisaMaster;
use Illuminate\Support\Str;

class VisaMasterController extends Controller
{
    public function index(Request $request)
    {
        $query = VisaMaster::where('isDelete', 0);

        if ($request->has('search')) {
            $query->where('strVisaName', 'like', '%' . $request->search . '%');
        }

        $visa = $query->orderBy('iVisaId','desc')->paginate(10);
        return view('admin.visamaster.index', compact('visa'));
    }

    public function create()
    {
        return view('admin.visamaster.create-edit');
    }

   public function store(Request $request)
{
    $request->validate([
        'strVisaName' => 'required|unique:visa_master,strVisaName',
        'strPhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $data = $request->only(['strVisaName', 'strH1Tag', 'strDescription', 'iStatus']);
    $data['strSlug'] = Str::slug($request->strVisaName);

    if ($request->hasFile('strPhoto')) {
        $file = $request->file('strPhoto');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(base_path('../public_html/egate_overseas/visa'), $filename);
        $data['strPhoto'] = $filename;
    }

    VisaMaster::create($data);
    return redirect()->route('admin.visamaster.index')->with('success', 'visa added successfully.');
}


    public function edit($strSlug)
    {
        $visa = VisaMaster::where('strSlug', $strSlug)->firstOrFail();
        return view('admin.visamaster.create-edit', compact('visa'));
    }

    public function update(Request $request, $strSlug)
    {
        $visa = VisaMaster::where('strSlug', $strSlug)->firstOrFail();
    
        $request->validate([
            'strVisaName' => 'required|unique:visa_master,strVisaName,' . $visa->iVisaId . ',iVisaId',
            'strPhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        $data = $request->only(['strVisaName', 'strH1Tag', 'strDescription', 'iStatus']);
        $data['strSlug'] = Str::slug($request->strVisaName);
    
        $uploadPath = base_path('../public_html/egate_overseas/visa');
    
        if ($request->hasFile('strPhoto')) {
            if ($visa->strPhoto && file_exists($uploadPath . '/' . $visa->strPhoto)) {
                unlink($uploadPath . '/' . $visa->strPhoto);
            }
    
            $file = $request->file('strPhoto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $data['strPhoto'] = $filename;
        }
    
        $visa->update($data);
        return redirect()->route('admin.visamaster.index')->with('success', 'visa updated successfully.');
    }


public function show(Request $request,$slug)
    {
        $query = VisaMaster::where('isDelete', 0);

        if ($request->filled('search')) {
            $query->where('strVisaName', 'like', '%' . $request->search . '%');
        }

        $specialties = $query->paginate(10);
        return view('admin.visamaster.index', compact('specialties'));
    }
    public function destroy($strSlug)
    {
       
        $visa = VisaMaster::where('strSlug', $strSlug)->firstOrFail();

        if ($visa->strPhoto && file_exists(base_path('../public_html/egate_overseas/visa/' . $visa->strPhoto))) {
            unlink(base_path('../public_html/egate_overseas/visa/'  . $visa->strPhoto));
        }

        if ((new visa_master)->getConnection()->getSchemaBuilder()->hasColumn('visa_master', 'isDelete')) {
            $visa->update(['isDelete' => 1]);
        } else {
            $visa->delete();
        }

        return response()->json(['success' => true]);
    }

public function bulkDelete(Request $request)
{
    $slugs = $request->ids;
    $uploadPath = base_path('../public_html/egate_overseas/visa');

    if (!$slugs || !is_array($slugs)) {
        return response()->json(['success' => false, 'message' => 'No items selected.']);
    }

    foreach ($slugs as $slug) {
        $record = VisaMaster::where('strSlug', $slug)->first(); // Do NOT use firstOrFail()

        if ($record) {
            // Delete all related otherDetails
            foreach ($record->visaservices as $detail) {
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
            if ((new VisaMaster)->getConnection()->getSchemaBuilder()->hasColumn('visa_master', 'isDelete')) {
                $record->update(['isDelete' => 1]);
            } else {
                $record->delete();
            }
        }
    }

    return response()->json(['success' => true]);
}




}
