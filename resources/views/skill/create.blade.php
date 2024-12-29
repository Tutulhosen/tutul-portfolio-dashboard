@extends('layouts.app')

@section('main-content')
<main class="main-content p-3">
    <div class="d-flex justify-content-between align-items-center mt-5">
        <h2>Add New Skill</h2>
        <a href="{{ route('skill.show') }}" class="btn btn-secondary">Back to Skills</a>
    </div>
    <br>

    <div class="card">
        <div class="card-body">
            <form id="skill-form" action="{{ route('skill.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Skill Title -->
                <div class="form-group mb-3">
                    <label for="title" class="form-label">Skill Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter skill title">
                </div>
                
                <!-- Skill Icon -->
                <div class="form-group mb-3">
                    <label for="icon" class="form-label">Bootstrap Icon (e.g., fas fa-html5)</label>
                    <input type="text" name="icon" id="icon" class="form-control" placeholder="Enter bootstrap icon name">
                </div>
                
                <!-- Custom Skill Image (optional) -->
                <div class="form-group mb-3">
                    <label for="image" class="form-label">Custom Skill Image (If Bootstrap Icon isn't avaiable)</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    <div class="mt-3" id="image-preview" style="display: none;">
                        <img src="#" alt="Image Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                    </div>
                </div>
                
                <!-- Submit Button -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save Skill</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $('#image').on('change', function (event) {
            const preview = $('#image-preview img');
            const file = event.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function (e) {
                    preview.attr('src', e.target.result);
                    $('#image-preview').show();
                };
                
                reader.readAsDataURL(file);
            } else {
                preview.attr('src', '#');
                $('#image-preview').hide();
            }
        });

        $('#skill-form').on('submit', function (e) {
            e.preventDefault();

            let isValid = true;
            const requiredFields = [
                { field: '#title', name: 'Skill Title' },
            
            ];

            requiredFields.forEach((item) => {
                if (!$(item.field).val().trim()) {
                    isValid = false;
                    toastr.error(`${item.name} is required.`, 'Validation Error');
                }
            });

            if (!isValid) {
                return; 
            }

            let formData = new FormData(this);

            $.ajax({
                url: '{{ route('skill.store') }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message, 'Success');
                        setTimeout(() => {
                            window.location.href = "{{ route('skill.show') }}";
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
                        toastr.error('Failed to save skill. Please try again.', 'Error');
                    }
                }
            });
        });
    });
</script>
@endsection
