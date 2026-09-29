@extends('layouts.app')

@section('title', 'FAQ List')

@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            {{-- Alert Messages --}}
            @include('common.alert')

            <div class="row mb-3">
                <div class="col-6">
                    <form id="bulkDeleteForm">
                        <button type="button" id="bulkDeleteBtn" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i> Bulk Delete
                        </button>
                    </form>
                </div>
                <div class="col-6 text-end">
                    <a href="{{ route('faqs.create') }}" class="btn btn-sm btn-primary">
                        <i class="far fa-plus"></i> Add FAQ
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">FAQ List</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th>
                                    <th>Country</th>
                                    <th>Visa</th>
                                    <th>Question</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($faqs as $faq)
                                <tr>
                                    <td><input type="checkbox" class="record-checkbox" value="{{ $faq->id }}"></td>
                                    <td>{{ $faq->country->strCountryName ?? '-' }}</td>
                                    <td>{{ $faq->visa->strVisaName ?? '-' }}</td>
                                    <td>{{ $faq->question }}</td>
                                    <td>
                                        <a href="{{ route('faqs.toggleStatus', $faq->id) }}" class="btn btn-sm {{ $faq->iStatus ? 'btn-success' : 'btn-warning' }}">
                                            {{ $faq->iStatus ? 'Active' : 'Inactive' }}
                                        </a>
                                    </td>
                                    <td>{{ $faq->created_at ? $faq->created_at->format('d-m-Y') : '-' }}</td>
                                    <td>
                                        <a href="{{ route('faqs.edit', $faq->id) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);" onclick="confirmDelete({{ $faq->id }})" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No FAQs found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $faqs->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.getElementById('selectAll').addEventListener('click', function(){
        let checkboxes = document.querySelectorAll('.record-checkbox');
        checkboxes.forEach(ch => ch.checked = this.checked);
    });

    document.getElementById('bulkDeleteBtn').addEventListener('click', function(){
        let ids = [];
        document.querySelectorAll('.record-checkbox:checked').forEach(ch => ids.push(ch.value));
        if(ids.length === 0) {
            alert('Please select at least one record.');
            return;
        }
        if(confirm('Are you sure you want to delete selected FAQs?')) {
            fetch('{{ route("faqs.bulkDelete") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ ids })
            })
            .then(response => response.json())
            .then(data => location.reload());
        }
    });

    function confirmDelete(id) {
        if(confirm('Are you sure you want to delete this FAQ?')) {
            fetch(`/admin/faqs/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            }).then(() => location.reload());
        }
    }
</script>

@endsection
