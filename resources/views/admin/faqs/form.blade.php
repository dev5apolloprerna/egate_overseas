@extends('layouts.app')

@section('title', isset($faq) ? 'Edit FAQ' : 'Add FAQ')

@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ isset($faq) ? 'Edit FAQ' : 'Add FAQ' }}</h4>
                        <div class="page-title-right">
                            <a href="{{ route('faqs.index') }}" class="btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ isset($faq) ? route('faqs.update', $faq->id) : route('faqs.store') }}">
                @csrf
                @if(isset($faq))
                    @method('POST')
                @endif

                <div class="card">
                    <div class="card-body row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Country <span style="color:red;">*</span></label>
                            <select name="country_id" class="form-control">
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->iCountryId }}" {{ isset($faq) && $faq->country_id == $country->iCountryId ? 'selected' : '' }}>
                                        {{ $country->strCountryName }}
                                    </option>
                                @endforeach
                            </select>
                            @if($errors->has('country_id'))
                                <span class="text-danger">{{ $errors->first('country_id') }}</span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Visa <span style="color:red;">*</span></label>
                            <select name="visa_id" class="form-control">
                                <option value="">Select Visa</option>
                                @foreach($visas as $visa)
                                    <option value="{{ $visa->iVisaId }}" {{ isset($faq) && $faq->visa_id == $visa->iVisaId ? 'selected' : '' }}>
                                        {{ $visa->strVisaName }}
                                    </option>
                                @endforeach
                            </select>
                            @if($errors->has('visa_id'))
                                <span class="text-danger">{{ $errors->first('visa_id') }}</span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Question <span style="color:red;">*</span></label>
                            <input type="text" name="question" class="form-control" value="{{ old('question', $faq->question ?? '') }}">
                            @if($errors->has('question'))
                                <span class="text-danger">{{ $errors->first('question') }}</span>
                            @endif
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Answer <span style="color:red;">*</span></label>
                            <textarea name="answer" class="form-control ckeditor">{{ old('answer', $faq->answer ?? '') }}</textarea>
                            @if($errors->has('answer'))
                                <span class="text-danger">{{ $errors->first('answer') }}</span>
                            @endif
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Status</label>
                            <select name="iStatus" class="form-control">
                                <option value="1" {{ isset($faq) && $faq->iStatus == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ isset($faq) && $faq->iStatus == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                            <div class="card-footer mt-2">
                                <div class="mb-3" style="float: right;">
                                <button type="submit" class="btn btn-success">
                                    {{ isset($faq) ? 'Update' : 'Submit' }}
                                </button>
                                @if(isset($faq))
                                    <a href="{{ route('faqs.index') }}" class="btn btn-primary">Cancel</a>
                                    @else
                                    <button type="reset" class="btn btn-primary">Clear</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replaceAll('ckeditor');
</script>

@endsection
