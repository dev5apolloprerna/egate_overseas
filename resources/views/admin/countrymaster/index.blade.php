@extends('layouts.app')

@section('title', 'Country List')

@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="row mb-3">
                <div class="col-md-6">
                     <form method="GET" action="{{ route('admin.countrymaster.index') }}" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search Specialty Name" value="{{ request('search') }}">
                            <div class="form-group">
                            <button class="btn btn-primary" type="submit">Search</button>
                            <button class="btn btn-primary " type="reset">Reset</button></div>
                        </div>
                    </form>
                   
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('admin.countrymaster.create') }}" class="btn btn-primary">Add New</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                     <button class="btn btn-danger mb-2" id="bulkDelete">Delete Selected</button>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAll"></th>
                                            <th>Country Name</th>
                                            <th>H1 Tag</th>
                                            <th>Photo</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($country as $specialty)
                                            <tr>
                                            <td><input type="checkbox" class="recordCheckbox" value="{{ $specialty->strSlug }}"></td>
                                                <td>{{ $specialty->strCountryName }}</td>
                                                <td>{{ $specialty->strH1Tag }}</td>
                                                <td>
                                                    <img src="{{ $specialty->strPhoto && file_exists(base_path('../public_html/egate_overseas/country/'. $specialty->strPhoto)) 
                                                    ? asset('country/' . $specialty->strPhoto) 
                                                    : asset('assets/images/noimage.png') }}" width="50">
                                                    
                                                </td>
                                                <td>{{ $specialty->strDescription }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $specialty->iStatus ? 'success' : 'danger' }}">
                                                        {{ $specialty->iStatus ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.countrymaster.edit', $specialty->strSlug) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('admin.countryservices.index', ['iCountryId' => $specialty->iCountryId]) }}" class="btn btn-sm btn-info" title="Manage Details">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger deleteRecord" data-id="{{ $specialty->strSlug }}"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {!! $country->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('scripts')
<script>
    $('#selectAll').on('click', function() {
        $('.recordCheckbox').prop('checked', this.checked);
    });

    $('#bulkDelete').on('click', function () {
    var ids = $('.recordCheckbox:checked').map(function () {
        return $(this).val();
    }).get();

    if (ids.length > 0 && confirm('Are you sure you want to delete selected records?')) {
        $.ajax({
            url: "{{ route('admin.countrymaster.bulk-delete') }}",
            type: 'DELETE',
            data: {
                ids: ids,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                location.reload();
            }
        });
    }
});



    $('.deleteRecord').on('click', function() {

        if (confirm('Are you sure you want to delete this record?')) {
            let id = $(this).data('id');
            $.ajax({
                url: `/egate_overseas/admin/countrymaster/${id}`,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    location.reload();
                }
            });
        }
    });
</script>
@endsection