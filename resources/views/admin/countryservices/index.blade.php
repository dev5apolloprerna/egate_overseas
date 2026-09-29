@extends('layouts.app')

@section('title', 'Country Services Details')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @include('common.alert')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Country Services Details
                                <a href="{{ route('admin.countryservices.create', ['iCountryId' => $country->iCountryId]) }}" style="float: right;" class="btn btn-sm btn-primary">
                                    <i class="far fa-plus"></i> Add New
                                </a>
                            </h5>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-danger mb-2" id="bulkDelete">Delete Selected</button>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAll"></th>
                                            <th>Title</th>
                                            <th>Photo</th>
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($countryservices as $detail)
                                            <tr>
                                                <td><input type="checkbox" class="recordCheckbox" value="{{ $detail->iCountryServiceId }}"></td>
                                                <td>{{ $detail->strTitle }}</td>
                                                <td>
                                                    <img src="{{ $detail->strPhoto && file_exists(base_path('../public_html/egate_overseas/countryservices/' . $detail->strPhoto)) 
                                                    ? asset('/countryservices/' . $detail->strPhoto) 
                                                    : asset('assets/images/noimage.png') }}" width="50">
                                                    <!-- 
                                                    @if($detail->strPhoto)
                                                        <img src="{{ asset('uploads/' . $detail->strPhoto) }}" width="50">
                                                    @endif -->
                                                </td>
                                                <td>{{ $detail->strDescription }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $detail->iStatus ? 'success' : 'danger' }}">
                                                        {{ $detail->iStatus ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.countryservices.edit', [$detail->iCountryServiceId]) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                                    <button class="btn btn-sm btn-danger deleteRecord" data-id="{{ $detail->iCountryServiceId }}"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {!! $countryservices->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#selectAll').on('click', function() {
        $('.recordCheckbox').prop('checked', this.checked);
    });

     $('#bulkDelete').on('click', function () {
    let ids = $('.recordCheckbox:checked').map(function () {
        return $(this).val();
    }).get();

    if (ids.length > 0 && confirm('Are you sure?')) {
        $.ajax({
            url: "{{ route('admin.countryservices.bulk-delete', ['iCountryId' => $country->iCountryId]) }}",
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}',
                ids: ids
            },
            success: function (res) {
                location.reload();
            },
            error: function (err) {
                console.log(err.responseJSON);
                alert('Failed to delete.');
            }
        });
    }
});


    $('.deleteRecord').on('click', function() {
        if (confirm('Are you sure you want to delete this record?')) {
            let id = $(this).data('id');
            $.ajax({
                url: `/egate_overseas/admin/visaservices/${id}`,
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
