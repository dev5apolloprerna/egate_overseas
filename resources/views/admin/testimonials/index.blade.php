@extends('layouts.app')
@section('title','Testimonials')
@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            @include('common.alert')
            <div class="d-flex justify-content-between mb-3">
                <h4>Testimonials</h4>
                <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">Add New</a>
            </div>
            <button id="bulkDeleteBtn" class="btn btn-danger mb-3">Bulk Delete</button>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Country</th>
                                <th>Visa</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($testimonials as $t)
                            <tr>
                                <td><input type="checkbox" class="bulk-checkbox" value="{{ $t->id }}"></td>
                                <td>@if($t->photo)<img src="{{ asset('egate_overseas/testimonials/'.$t->photo) }}" width="50">@endif</td>
                                <td>{{ $t->name }}</td>
                                <td>{{ $t->designation }}</td>
                                <td>{{ $t->country->strCountryName ?? '' }}</td>
                                <td>{{ $t->visa->strVisaName ?? '' }}</td>
                                <td>{!! $t->iStatus ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' !!}</td>
                                <td>{{ $t->created_at }}</td>
                                <td>
                                    <a href="{{ route('admin.testimonials.edit',$t->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.testimonials.destroy',$t->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this testimonial?')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">{{ $testimonials->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('selectAll').addEventListener('click',function(){
        document.querySelectorAll('.bulk-checkbox').forEach(c=>c.checked=this.checked);
    });
    document.getElementById('bulkDeleteBtn').addEventListener('click',function(){
        let ids = Array.from(document.querySelectorAll('.bulk-checkbox:checked')).map(c=>c.value);
        if(ids.length===0){alert('No items selected');return;}
        if(!confirm('Delete selected testimonials?')) return;
        fetch('{{ route('admin.testimonials.bulk-delete') }}',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'},body:JSON.stringify({ids:ids})}).then(()=>location.reload());
    });
</script>
@endsection
