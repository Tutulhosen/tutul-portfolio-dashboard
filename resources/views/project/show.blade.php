@extends('layouts.app')

@section('main-content')
<main class="main-content p-3">
    <div class="d-flex justify-content-between align-items-center mt-5">

    </div><br>

    <div class="card">
        <div class="card-body">
            <a href="{{route('project.create')}}" class="btn btn-primary">Create new ++</a>
            <h4 class="text-center">Project </h4>

            <hr>
            
            <!-- Responsive Table -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>SL.</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($projects as $project)
                            <tr>
                                <td>{{ $loop->iteration + ($projects->currentPage() - 1) * $projects->perPage() }}</td>
                                <td>{!! $project->title !!}</td>
                                @if ($project->status == 1)
                                    <td><button class="btn btn-primary status_btn" value="{{ $project->id }}">{{ status_convert($project->status) }}</button></td>
                                @else
                                    <td><button class="btn btn-danger status_btn" value="{{ $project->id }}">{{ status_convert($project->status) }}</button></td>
                                @endif
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('project.edit', $project->id) }}" class="btn btn-warning btn-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                              </svg>
                                        </a>
                                        <button class="btn btn-danger btn-sm delete-btn" data-project-id="{{ $project->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                              </svg>
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $project->id }}" action="{{ route('project.destroy', $project->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No Data available.</td>
                            </tr>
                        @endforelse

                    </tbody>
                    
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $projects->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')

<script>
    //status update
    $(document).on('click', '.status_btn', function () {
        let button = $(this); 
        let projectId = button.val(); 
      
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to change the status!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
           
                $.ajax({
                    url: `/project/status/${projectId}`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function (response) {

                        if (response.status === 1) {
                            button.removeClass('btn-danger').addClass('btn-primary').text(response.status);
                        } else {
                            button.removeClass('btn-primary').addClass('btn-danger').text(response.status);
                        }

                        Swal.fire(
                            'Changed!',
                            'The status has been updated.',
                            'success'
                        ).then((result) => {
                   
                            if (result.isConfirmed) {
                            
                                location.reload();
                            }
                        });
                    },
                    error: function (xhr) {
                        Swal.fire(
                            'Error!',
                            'There was a problem updating the status.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    //delete
    $(document).on('click', '.delete-btn', function () {
        let projectId = $(this).data('project-id'); 
        let deleteForm = $('#delete-form-' + projectId); 

    
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this project!",
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
                            'The project has been deleted.',
                            'success'
                        ).then(() => {
                            toastr.success('Successfully Delete Data.');
                            setTimeout(() => {
                                window.location.href = "{{ route('project.show') }}";
                            }, 1000);
                        });
                    },
                    error: function () {
                        Swal.fire(
                            'Error!',
                            'An error occurred while deleting the project.',
                            'error'
                        );
                    }
                });
            }
        });
    });


</script>
@endsection

