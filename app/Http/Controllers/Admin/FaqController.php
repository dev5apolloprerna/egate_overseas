<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\CountryMaster;
use App\Models\VisaMaster;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::where('isDelete', 0)->paginate(10);
        $countries = CountryMaster::orderBy('strCountryName', 'asc')->get();
        $visas = VisaMaster::orderBy('strVisaName', 'asc')->get();
        return view('admin.faqs.index', compact('faqs', 'countries', 'visas'));
    }

    public function create()
    {
        $countries = CountryMaster::orderBy('strCountryName', 'asc')->get();
        $visas = VisaMaster::orderBy('strVisaName', 'asc')->get();
        return view('admin.faqs.form', compact('countries', 'visas'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|integer',
            'visa_id' => 'required|integer',
            'question' => 'required|string',
            'answer' => 'required|string'
        ]);

        Faq::create([
            'country_id' => $request->country_id,
            'visa_id' => $request->visa_id,
            'question' => $request->question,
            'answer' => $request->answer,
            'iStatus' => $request->iStatus ?? 1,
            'strIP' => $request->ip()
        ]);

        return redirect()->back()->with('success', 'FAQ added successfully');
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        $countries = CountryMaster::orderBy('strCountryName', 'asc')->get();
        $visas = VisaMaster::orderBy('strVisaName', 'asc')->get();
        return view('admin.faqs.form', compact('faq', 'countries', 'visas'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'country_id' => 'required|integer',
            'visa_id' => 'required|integer',
            'question' => 'required|string',
            'answer' => 'required|string'
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update([
            'country_id' => $request->country_id,
            'visa_id' => $request->visa_id,
            'question' => $request->question,
            'answer' => $request->answer,
            'iStatus' => $request->iStatus ?? 1,
        ]);

        return redirect()->back()->with('success', 'FAQ updated successfully');
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->isDelete = 1;
        $faq->save();

        return redirect()->back()->with('success', 'FAQ deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        Faq::whereIn('id', $ids)->update(['isDelete' => 1]);
        return response()->json(['success' => 'FAQs deleted successfully']);
    }

    public function toggleStatus($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->iStatus = !$faq->iStatus;
        $faq->save();
        return redirect()->back()->with('success', 'Status updated successfully');
    }
}
