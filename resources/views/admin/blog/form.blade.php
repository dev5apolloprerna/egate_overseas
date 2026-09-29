@extends('layouts.app')

@section('title', 'Add/Edit Blog')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Add/Edit Blog</h4>
                        <div class="page-title-right">
                            <a href="{{ route('admin.blog.index') }}" class="btn btn-sm btn-primary">Back</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ isset($blog) ? route('admin.blog.update', $blog->iBlogId) : route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if(isset($blog)) @method('PUT') @endif

                                <div class="mb-3">
                                    <label for="strBlogTitle" class="form-label">Blog Title <span style="color:red">*</span></label>
                                    <input type="text" name="strBlogTitle" class="form-control" value="{{ old('strBlogTitle', $blog->strBlogTitle ?? '') }}">
                                    @if($errors->has('strBlogTitle'))
                                        <span class="text-danger">{{ $errors->first('strBlogTitle') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="strBlogDescription" class="form-label">Blog Description <span style="color:red">*</span></label>
                                    <textarea name="strBlogDescription" class="form-control" rows="4">{{ old('strBlogDescription', $blog->strBlogDescription ?? '') }}</textarea>
                                    @if($errors->has('strBlogDescription'))
                                        <span class="text-danger">{{ $errors->first('strBlogDescription') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="strBlogImage" class="form-label">Blog Image</label>
                                    <input type="file" name="strBlogImage" class="form-control">
                                    @if(isset($blog) && $blog->strBlogImage)
                                        <img src="{{ asset('/uploads/blog/' . $blog->strBlogImage) }}" width="100" class="mt-2">
                                    @endif
                                    @if($errors->has('strBlogImage'))
                                        <span class="text-danger">{{ $errors->first('strBlogImage') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="strMetaTitle" class="form-label">Meta Title</label>
                                    <input type="text" name="strMetaTitle" class="form-control" value="{{ old('strMetaTitle', $blog->strMetaTitle ?? '') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="strMetaDescription" class="form-label">Meta Description</label>
                                    <textarea name="strMetaDescription" class="form-control" rows="3">{{ old('strMetaDescription', $blog->strMetaDescription ?? '') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="strHead" class="form-label">Head</label>
                                    <textarea name="strHead" class="form-control" rows="2">{{ old('strHead', $blog->strHead ?? '') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="strFooter" class="form-label">Footer</label>
                                    <textarea name="strFooter" class="form-control" rows="2">{{ old('strFooter', $blog->strFooter ?? '') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="iStatus" class="form-label">Status</label>
                                    <select name="iStatus" class="form-select">
                                        <option value="1" {{ old('iStatus', $blog->iStatus ?? '') == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('iStatus', $blog->iStatus ?? '') == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <div class="card-footer mt-2">
                                        <div class="mb-3" style="float: right;">
                                        <button type="submit" class="btn btn-success">
                                           {{ isset($blog) ? 'Update' : 'Save' }}
                                        </button>
                                        @if(isset($blog))
                                            <a href="{{ route('admin.blog.index') }}" class="btn btn-primary">Cancel</a>
                                            @else
                                            <button type="reset" class="btn btn-primary">Clear</button>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
