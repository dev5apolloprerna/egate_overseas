<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\CountryMaster;
use App\Models\VisaMaster;
use Illuminate\Support\Facades\File;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::where('isDelete', 0)->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        $countries = CountryMaster::orderBy('strCountryName', 'asc')->get();
        $visas = VisaMaster::orderBy('strVisaName', 'asc')->get();
        return view('admin.testimonials.add-edit', compact('countries','visas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'iCountryId' => 'required',
            'iVisaId' => 'required',
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'description' => 'required',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('egate_overseas/testimonials/');
            $image->move($destinationPath, $name);
            $data['photo'] = $name;
        }

        $data['strIP'] = $request->ip();
        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success','Testimonial added successfully');
    }

    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $countries = CountryMaster::orderBy('strCountryName', 'asc')->get();
        $visas = VisaMaster::orderBy('strVisaName', 'asc')->get();
        return view('admin.testimonials.add-edit', compact('testimonial','countries','visas'));
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $request->validate([
            'iCountryId' => 'required',
            'iVisaId' => 'required',
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'description' => 'required',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            if($testimonial->photo && File::exists(public_path('egate_overseas/testimonials/'.$testimonial->photo))) {
                File::delete(public_path('egate_overseas/testimonials/'.$testimonial->photo));
            }
            $image = $request->file('photo');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('egate_overseas/testimonials/');
            $image->move($destinationPath, $name);
            $data['photo'] = $name;
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('success','Testimonial updated successfully');
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        if($testimonial->photo && File::exists(public_path('egate_overseas/testimonials/'.$testimonial->photo))) {
            File::delete(public_path('egate_overseas/testimonials/'.$testimonial->photo));
        }
        $testimonial->update(['isDelete' => 1]);
        return redirect()->route('admin.testimonials.index')->with('success','Testimonial deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        $testimonials = Testimonial::whereIn('id',$ids)->get();
        foreach($testimonials as $testimonial) {
            if($testimonial->photo && File::exists(public_path('egate_overseas/testimonials/'.$testimonial->photo))) {
                File::delete(public_path('egate_overseas/testimonials/'.$testimonial->photo));
            }
            $testimonial->update(['isDelete'=>1]);
        }
        return response()->json(['success'=>true]);
    }
}