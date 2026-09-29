<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::where('isDelete', 0);

        if ($request->has('search')) {
            $query->where('strBlogTitle', 'like', '%' . $request->search . '%');
        }

        $blogs = $query->orderBy('iBlogId', 'desc')->paginate(10);
        return view('admin.blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blog.form');
    }

    public function store(Request $request)
{
    $request->validate([
        'strBlogTitle' => 'required',
        'strBlogDescription' => 'required',
        'strBlogImage' => 'nullable|image',
    ]);

    $data = $request->except(['strBlogImage']);

    if ($request->hasFile('strBlogImage')) {
        $filename = time() . '.' . $request->strBlogImage->extension();
        $request->strBlogImage->move(base_path('../public_html/orchid_hospital/uploads/blog'), $filename);
        $data['strBlogImage'] = $filename;
    }

    Blog::create($data);
    return redirect()->route('admin.blog.index')->with('success', 'Blog created successfully.');
}



    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blog.form', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'strBlogTitle' => 'required',
            'strBlogDescription' => 'required',
            'strBlogImage' => 'nullable|image',
        ]);
    
        $blog = Blog::findOrFail($id);
        $data = $request->except(['strBlogImage']);
    
        if ($request->hasFile('strBlogImage')) {
            // Delete old image from both locations
            $oldImage = $blog->strBlogImage;
            if ($oldImage) {
                $publicPath = public_path('uploads/' . $oldImage);
                $htmlPath = base_path('../public_html/orchid_hospital/uploads/blog/' . $oldImage);
                if (file_exists($publicPath)) {
                    unlink($publicPath);
                }
                if (file_exists($htmlPath)) {
                    unlink($htmlPath);
                }
            }
    
            // Save new image
            $filename = time() . '.' . $request->strBlogImage->extension();
            $request->strBlogImage->move(public_path('uploads'), $filename);
    
            // Copy to public_html
            $sourcePath = public_path('uploads/' . $filename);
            $destinationPath = base_path('../public_html/orchid_hospital/uploads/blog/' . $filename);
            \File::copy($sourcePath, $destinationPath);
    
            $data['strBlogImage'] = $filename;
        }
    
        $blog->update($data);
        return redirect()->route('admin.blog.index')->with('success', 'Blog updated successfully.');
    }


        public function destroy($id)
        {
            $blog = Blog::findOrFail($id);
        
            // Delete the image file if it exists
            if ($blog->strBlogImage && file_exists(base_path('../public_html/orchid_hospital/uploads/blog/' . $blog->strBlogImage))) {
                unlink(base_path('../public_html/orchid_hospital/uploads/blog/' . $blog->strBlogImage));
            }
        
            $blog->isDelete = 1;
            $blog->save();
        
            return response()->json(['status' => 'success']);
        }
        
        public function bulkDelete(Request $request)
        {
            $ids = $request->ids;
            $blogs = Blog::whereIn('iBlogId', $ids)->get();
        
            foreach ($blogs as $blog) {
                // Delete the image file if it exists
                if ($blog->strBlogImage && file_exists(base_path('../public_html/orchid_hospital/uploads/blog/' . $blog->strBlogImage))) {
                    unlink(base_path('../public_html/orchid_hospital/uploads/blog/' . $blog->strBlogImage));
                }
            }
        
            Blog::whereIn('iBlogId', $ids)->update(['isDelete' => 1]);
        
            return response()->json(['status' => 'success']);
        }

}