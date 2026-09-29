@extends('layouts.app')

@section('title', isset($country) ? 'Edit Country Detail' : 'Add Country Detail')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @include('common.alert')
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ isset($country) ? 'Edit' : 'Add' }} Country Detail</h4>
                        <div class="page-title-right">
                            <a href="{{ route('admin.countrymaster.index') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ isset($country) ? route('admin.countrymaster.update', $country->strSlug) : route('admin.countrymaster.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if(isset($country))
                                    @method('PUT')
                                @endif
                                <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label>Country Name <span style="color:red">*</span></label>
                                    <input type="text" name="strCountryName" class="form-control" value="{{ old('strCountryName', $country->strCountryName ?? '') }}">
                                    @if($errors->has('strCountryName'))
                                        <span class="text-danger">{{ $errors->first('strCountryName') }}</span>
                                    @endif
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label>H1 Tag</label>
                                    <input type="text" name="strH1Tag" class="form-control" value="{{ old('strH1Tag', $country->strH1Tag ?? '') }}">
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label>Photo</label>
                                    <input type="file" name="strPhoto" class="form-control">
                                    @if(isset($country->strPhoto))
                                        <img src="{{ asset('/country/' . $country->strPhoto) }}" width="100">
                                    @endif
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label>Description</label>
                                    <textarea name="strDescription" class="form-control">{{ old('strDescription', $country->strDescription ?? '') }}</textarea>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <label>Status</label>
                                    <select name="iStatus" class="form-control">
                                        <option value="1" {{ (old('iStatus', $country->iStatus ?? '') == 1) ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ (old('iStatus', $country->iStatus ?? '') == 0) ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                
                                <div class="card-footer mt-2">
                                        <div class="mb-3" style="float: right;">
                                        <button type="submit" class="btn btn-success">
                                            {{ isset($country) ? 'Update' : 'Save' }}
                                        </button>
                                        @if(isset($country))
                                            <a href="{{ route('admin.countrymaster.index') }}" class="btn btn-primary">Cancel</a>
                                            @else
                                            <button type="reset" class="btn btn-primary">Clear</button>
                                        @endif
                                    </div>
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
