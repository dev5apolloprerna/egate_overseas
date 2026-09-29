@extends('layouts.app')

@section('title', isset($visaservices) ? 'Edit Visa Services Detail' : 'Add Visa Services Detail')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @include('common.alert')
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ isset($visaservices) ? 'Edit' : 'Add' }} Visa Services Detail for {{ $visa->strVisaName }}</h4>
                        <div class="page-title-right">
                            <a href="{{ route('admin.visaservices.index', ['iVisaId' => $visa->iVisaId]) }}" class="btn btn-sm btn-primary">
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
                                action="{{ isset($visaservices) 
                                    ? route('admin.visaservices.update', ['iVisaServiceId' => $visaservices->iVisaServiceId]) 
                                    : route('admin.visaservices.store', ['iVisaId' => $visa->iVisaId]) }}" 
                                method="POST" 
                                enctype="multipart/form-data"
                            >
                                @csrf
                                @if(isset($visaservices))
                                    @method('PUT')
                                @endif
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="strTitle" class="form-label">Title <span style="color:red">*</span></label>
                                        <input type="text" name="strTitle" class="form-control" 
                                            value="{{ old('strTitle', $visaservices->strTitle ?? '') }}">
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
                                        @if(isset($visaservices->strPhoto))
                                            <img src="{{ asset('/visaservices/' . $visaservices->strPhoto) }}" width="100" class="mt-2">
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="strDescription" class="form-label">Description</label>
                                    <textarea name="strDescription" class="form-control" rows="4">{{ old('strDescription', $visaservices->strDescription ?? '') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="iStatus" class="form-select">
                                        <option value="1" {{ (old('iStatus', $visaservices->iStatus ?? 1) == 1) ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ (old('iStatus', $visaservices->iStatus ?? 1) == 0) ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <div class="card-footer mt-2">
                                        <div class="mb-3" style="float: right;">
                                        <button type="submit" class="btn btn-success">
                                            {{ isset($visaservices) ? 'Update' : 'Save' }}
                                        </button>
                                        @if(isset($visaservices))
                                            <a href="{{ route('admin.visaservices.index') }}" class="btn btn-primary">Cancel</a>
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
