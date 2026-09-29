@extends('layouts.app')

@section('title', 'Blog List')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="row mb-3">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('admin.blog.index') }}">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Blog Title" value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">Search</button>
                            <button class="btn btn-primary" style="margin-left: 10px;" type="reset">Reset</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">Add New</a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <button class="btn btn-danger mb-2" id="bulkDelete">Bulk Delete</button>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th>Blog Title</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blogs as $blog)
                                <tr>
                                    <td><input type="checkbox" class="recordCheckbox" value="{{ $blog->iBlogId }}"></td>
                                    <td>{{ $blog->strBlogTitle }}</td>
                                    <td>
                                        <img src="{{ $blog->strBlogImage && file_exists(base_path('../public_html/orchid_hospital/uploads/blog/'. $blog->strBlogImage)) 
                                                    ? asset('uploads/blog/' . $blog->strBlogImage) 
                                                    : asset('assets/images/noimage.png') }}" width="50">
                                    </td>
                                    <td>{!! $blog->iStatus ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' !!}</td>
                                    <td>
                                        <a href="{{ route('admin.blog.edit', $blog->iBlogId) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                        <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $blog->iBlogId }}"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $blogs->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.getElementById('selectAll').addEventListener('click', function() {
        document.querySelectorAll('.recordCheckbox').forEach(checkbox => checkbox.checked = this.checked);
    });

    document.getElementById('bulkDelete').addEventListener('click', function() {
        const ids = Array.from(document.querySelectorAll('.recordCheckbox:checked')).map(cb => cb.value);
        if(ids.length && confirm('Are you sure you want to delete selected records?')) {
            fetch("{{ route('admin.blog.bulk-delete') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ ids })
            }).then(response => location.reload());
        }
    });

    document.querySelectorAll('.deleteBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            if(confirm('Are you sure you want to delete this record?')) {
                const id = this.getAttribute('data-id');
                fetch(`/orchid_hospital/admin/blog/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }
                }).then(response => location.reload());
            }
        });
    });
</script>
@endsection
