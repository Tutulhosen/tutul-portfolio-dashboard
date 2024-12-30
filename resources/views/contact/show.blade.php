@extends('layouts.app')

@section('main-content')
<main class="main-content p-3">
    <div class="d-flex justify-content-between align-items-center mt-5">
        <h4>Contact Submissions</h4>
    </div><br>

    <div class="card">
        <div class="card-body">
            <h4 class="text-center">Contact Submissions</h4>
            <hr>
            
            <!-- Responsive Table -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>SL.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date</th>
                            {{-- <th>Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($contacts as $contact)
                            <tr>
                                <td>{{ $loop->iteration + ($contacts->currentPage() - 1) * $contacts->perPage() }}</td>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->subject }}</td>
                                <td>{!!Str::limit($contact->message, 50, '...')!!}</td>
                                <td>{{ $contact->created_at }}</td>
                                {{-- <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('contact.edit', $contact->id) }}" class="btn btn-warning btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                              </svg>
                                        </a>
                                        <button class="btn btn-danger btn-sm delete-btn" data-contact-id="{{ $contact->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                              </svg>
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $contact->id }}" action="{{ route('contact.destroy', $contact->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td> --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No contact submissions available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $contacts->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    $(document).on('click', '.delete-btn', function () {
        let contactId = $(this).data('contact-id');
        let deleteForm = $('#delete-form-' + contactId);

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this contact submission!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteForm.attr('action'),
                    type: 'POST',
                    data: deleteForm.serialize(),
                    success: function () {
                        Swal.fire(
                            'Deleted!',
                            'The contact submission has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    },
                    error: function () {
                        Swal.fire(
                            'Error!',
                            'An error occurred while deleting the contact submission.',
                            'error'
                        );
                    }
                });
            }
        });
    });
</script>
@endsection
