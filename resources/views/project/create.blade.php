@extends('layouts.app')

@section('main-content')
<main class="main-content p-3">
    <div class="d-flex justify-content-between align-items-center mt-5">
        <h2>Add New Project</h2>
        <a href="{{ route('project.show') }}" class="btn btn-secondary">Back to Projects</a>
    </div>
    <br>

    <div class="card">
        <div class="card-body">
            <form id="project-form" action="{{ route('project.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Project Title -->
                <div class="form-group mb-3">
                    <label for="title" class="form-label">Project Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter project title">
                </div>
                
                <!-- Project Description -->
                <div class="form-group mb-3">
                    <label for="description" class="form-label">Project Description <span class="text-danger">*</span></label>
                    <textarea name="description" id="description" rows="5" class="form-control" placeholder="Enter project description"></textarea>
                </div>
                
                <!-- Project Status -->
                <div class="form-group mb-3">
                    <label for="status" class="form-label">Project Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="active">Active</option>
                        <option value="inactive" selected>Inactive</option>
                    </select>
                </div>
                
                <!-- Start Date -->
                <div class="form-group mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control">
                </div>
                
                <!-- End Date -->
                <div class="form-group mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control">
                </div>
                
                <!-- Project Image -->
                <div class="form-group mb-3">
                    <label for="image" class="form-label">Project Image</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <div class="mt-3">
                        <img id="image-preview" src="#" alt="Image Preview" class="img-thumbnail" style="display: none; max-width: 200px; max-height: 200px;">
                    </div>
                </div>

                <!-- Project Link -->
                <div class="form-group mb-3">
                    <label for="link" class="form-label">Project Link</label>
                    <input type="url" name="link" id="link" class="form-control" placeholder="Enter project link (optional)">
                </div>
                
                <!-- Submit Button -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save Project</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@section('scripts')
{{-- Image Preview --}}
<script>
    function previewImage(event) {
        const preview = document.getElementById('image-preview');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            
            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }
</script>

<script>
    $(document).ready(function () {
        $('#project-form').on('submit', function (e) {
            e.preventDefault();

     
            let isValid = true;
            const requiredFields = [
                { field: '#title', name: 'Project Title' },
                { field: '#description', name: 'Project Description' }
            ];

            requiredFields.forEach((item) => {
                if (!$(item.field).val().trim()) {
                    isValid = false;
                    toastr.error(`${item.name} is required.`, 'Validation Error');
                }
            });

            if (!isValid) {
                return; // Stop the form from being submitted
            }

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('project.store') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
               
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message, 'Success');
                        setTimeout(() => {
                            window.location.href = "{{ route('project.show') }}";
                        }, 2000);
                    } else {
                        toastr.error('An unexpected error occurred.', 'Error');
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        for (let error in errors) {
                            toastr.error(errors[error][0], 'Validation Error');
                        }
                    } else {
                        toastr.error('Failed to save project. Please try again.', 'Error');
                    }
                }
            });
        });
    });
</script>
@endsection
