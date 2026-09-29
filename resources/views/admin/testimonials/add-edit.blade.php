@extends('layouts.app')
@section('title', isset($testimonial)?'Edit Testimonial':'Add Testimonial')
@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @include('common.alert')
            <div class="card">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{ isset($testimonial)?route('admin.testimonials.update',$testimonial->id):route('admin.testimonials.store') }}">
                        @csrf
                        @if(isset($testimonial)) @method('PUT') @endif
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Country <span style="color:red;">*</span></label>
                                <select name="iCountryId" class="form-control">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $c)
                                        <option value="{{ $c->iCountryId }}" {{ isset($testimonial)&&$testimonial->iCountryId==$c->iCountryId?'selected':'' }}>{{ $c->strCountryName }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('iCountryId'))<span class="text-danger">{{ $errors->first('iCountryId') }}</span>@endif
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Visa <span style="color:red;">*</span></label>
                                <select name="iVisaId" class="form-control">
                                    <option value="">Select Visa</option>
                                    @foreach($visas as $v)
                                        <option value="{{ $v->iVisaId }}" {{ isset($testimonial)&&$testimonial->iVisaId==$v->iVisaId?'selected':'' }}>{{ $v->strVisaName }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('iVisaId'))<span class="text-danger">{{ $errors->first('iVisaId') }}</span>@endif
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Name <span style="color:red;">*</span></label>
                                <input type="text" name="name" value="{{ old('name',$testimonial->name??'') }}" class="form-control">
                                @if($errors->has('name'))<span class="text-danger">{{ $errors->first('name') }}</span>@endif
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Designation <span style="color:red;">*</span></label>
                                <input type="text" name="designation" value="{{ old('designation',$testimonial->designation??'') }}" class="form-control">
                                @if($errors->has('designation'))<span class="text-danger">{{ $errors->first('designation') }}</span>@endif
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="form-label">Description <span style="color:red;">*</span></label>
                                <textarea name="description" class="form-control ckeditor">{{ old('description',$testimonial->description??'') }}</textarea>
                                @if($errors->has('description'))<span class="text-danger">{{ $errors->first('description') }}</span>@endif
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Photo</label>
                                <input type="file" name="photo" class="form-control">
                                @if(isset($testimonial) && $testimonial->photo)
                                    <img src="{{ asset('egate_overseas/testimonials/'.$testimonial->photo) }}" width="80" class="mt-2">
                                @endif
                                @if($errors->has('photo'))<span class="text-danger">{{ $errors->first('photo') }}</span>@endif
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Status</label>
                                <select name="iStatus" class="form-control">
                                    <option value="1" {{ isset($testimonial)&&$testimonial->iStatus==1?'selected':'' }}>Active</option>
                                    <option value="0" {{ isset($testimonial)&&$testimonial->iStatus==0?'selected':'' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
				        <div class="card-footer mt-2">
                        <div class="mb-3" style="float: right;">
                        <button type="submit" class="btn btn-success">
                           {{ isset($testimonial)?'Update':'Save' }}
                        </button>
                        @if(isset($testimonial))
                            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-primary">Cancel</a>
                            @else
                            <button type="reset" class="btn btn-primary">Clear</button>
                        @endif
                    </div>
                
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script>CKEDITOR.replace('description');</script>
@endsection
