<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisaServices;
use App\Models\VisaMaster;

class VisaServicesController extends Controller
{
    public function index($iVisaId)
    {
        $visa = VisaMaster::findOrFail($iVisaId);
        $visaservices = VisaServices::where('iVisaId', $iVisaId)
            ->where('isDelete', 0)->orderBy('iVisaServiceId','desc')->paginate(10);

        return view('admin.visaservices.index', compact('visa', 'visaservices'));
    }

    public function create($iVisaId)
    {
        $visa = VisaMaster::findOrFail($iVisaId);
        return view('admin.visaservices.create-edit', compact('visa'));
    }

        public function store(Request $request, $iVisaId)
    {
        $visa = VisaMaster::findOrFail($iVisaId);
    
        $request->validate([
            'strTitle' => 'required',
            'strPhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        $data = $request->only(['strTitle', 'strDescription', 'iStatus']);
        $data['iVisaId'] = $iVisaId;
    
        $uploadPath = base_path('../public_html/egate_overseas/visaservices');
    
        if ($request->hasFile('strPhoto')) {
            $file = $request->file('strPhoto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $data['strPhoto'] = $filename;
        }
    
        VisaServices::create($data);
        return redirect()->route('admin.visaservices.index', $iVisaId)->with('success', 'Visa Service added successfully.');
    }


    public function show($iVisaServiceId)
    {
        $visaservices = VisaServices::findOrFail($iVisaServiceId);
        return view('admin.visaservices.index', compact('visaservices'));
    }

    public function edit($iVisaServiceId)
    {
        $visaservices = VisaServices::findOrFail($iVisaServiceId);
        $visa = $visaservices->visa;
        return view('admin.visaservices.create-edit', compact('visaservices', 'visa'));
    }

    public function update(Request $request, $iVisaServiceId)
    {
        $visaservices = VisaServices::findOrFail($iVisaServiceId);
    
        $request->validate([
            'strTitle' => 'required',
            'strPhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        $data = $request->only(['strTitle', 'strDescription', 'iStatus']);
        $uploadPath = base_path('../public_html/egate_overseas/visaservices');
    
        if ($request->hasFile('strPhoto')) {
            if ($visaservices->strPhoto && file_exists($uploadPath . '/' . $visaservices->strPhoto)) {
                unlink($uploadPath . '/' . $visaservices->strPhoto);
            }
    
            $file = $request->file('strPhoto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $data['strPhoto'] = $filename;
        }
    
        $visaservices->update($data);
        return redirect()->route('admin.visaservices.index', $visaservices->iVisaId)->with('success', 'Visa Service updated successfully.');
    }


    public function destroy($iVisaServiceId)
    {
        $visaservices = VisaServices::findOrFail($iVisaServiceId);
        if ($visaservices->strPhoto && file_exists(base_path('../public_html/egate_overseas/visaservices/' . $visaservices->strPhoto))) {
            unlink(base_path('../public_html/egate_overseas/visaservices/' . $visaservices->strPhoto));
        }
        $visaservices->update(['isDelete' => 1]);
        return response()->json(['success' => true]);
    }

    public function bulkDelete(Request $request)
{
    $ids = $request->ids;
    $uploadPath = base_path('../public_html/egate_overseas/visaservices');

    if (!$ids || !is_array($ids)) {
        return response()->json(['success' => false, 'message' => 'No items selected.']);
    }

    $visaservicess = VisaServices::whereIn('iVisaServiceId', $ids)->get();

    foreach ($visaservicess as $visaservices) {
        if ($visaservices->strPhoto && file_exists($uploadPath . '/' . $visaservices->strPhoto)) {
            unlink($uploadPath . '/' . $visaservices->strPhoto);
        }

        if ((new VisaServices)->getConnection()->getSchemaBuilder()->hasColumn('visaservices', 'isDelete')) {
            $visaservices->update(['isDelete' => 1]);
        } else {
            $visaservices->delete();
        }
    }

    return response()->json(['success' => true]);
}

}
