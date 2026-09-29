@extends('layouts.app')

@section('title', isset($countryservices) ? 'Edit Country Services Detail' : 'Add Country Services Detail')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @include('common.alert')
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ isset($countryservices) ? 'Edit' : 'Add' }} Country Services Detail for {{ $country->strCountryName }}</h4>
                        <div class="page-title-right">
                            <a href="{{ route('admin.countryservices.index', ['iCountryId' => $country->iCountryId]) }}" class="btn btn-sm btn-primary">
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
                            <form 
                                action="{{ isset($countryservices) 
                                    ? route('admin.countryservices.update', ['iCountryServiceId' => $countryservices->iCountryServiceId]) 
                                    : route('admin.countryservices.store', ['iCountryId' => $country->iCountryId]) }}" 
                                method="POST" 
                                enctype="multipart/form-data"
                            >
                                @csrf
                                @if(isset($countryservices))
                                    @method('PUT')
                                @endif
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="strTitle" class="form-label">Title <span style="color:red">*</span></label>
                                        <input type="text" name="strTitle" class="form-control" 
                                            value="{{ old('strTitle', $countryservices->strTitle ?? '') }}">
                                        @if($errors->has('strTitle'))
                                            <span class="text-danger">{{ $errors->first('strTitle') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-md-6">
                                        <label for="strPhoto" class="form-label">Photo</label>
                                        <input type="file" name="strPhoto" class="form-control">
                                        @if($errors->has('strPhoto'))
                                            <span class="text-danger">{{ $errors->first('strPhoto') }}</span>
                                        @endif
                                        @if(isset($countryservices->strPhoto))
                                            <img src="{{ asset('/$countryservices/' . $countryservices->strPhoto) }}" width="100" class="mt-2">
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="strDescription" class="form-label">Description</label>
                                    <textarea name="strDescription" class="form-control" rows="4">{{ old('strDescription', $countryservices->strDescription ?? '') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="iStatus" class="form-select">
                                        <option value="1" {{ (old('iStatus', $countryservices->iStatus ?? 1) == 1) ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ (old('iStatus', $countryservices->iStatus ?? 1) == 0) ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="card-footer mt-2">
                                        <div class="mb-3" style="float: right;">
                                        <button type="submit" class="btn btn-success">
                                            {{ isset($countryservices) ? 'Update' : 'Save' }}
                                        </button>
                                        @if(isset($countryservices))
                                            <a href="{{ route('admin.countryservices.index') }}" class="btn btn-primary">Cancel</a>
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
