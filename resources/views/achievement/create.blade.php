@extends('layouts.app')

@section('main-content')
<main class="main-content p-3">
    <div class="d-flex justify-content-between align-items-center mt-5">
        <h2>Add New Achievement</h2>
        <a href="{{ route('achievement.show') }}" class="btn btn-secondary">Back to achievements</a>
    </div>
    <br>

    <div class="card">
        <div class="card-body">
            <form id="achievement-form" action="{{ route('achievement.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- achievement Title -->
                <div class="form-group mb-3">
                    <label for="title" class="form-label">Achievement Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter achievement title">
                </div>
                
                <!-- achievement Description -->
                <div class="form-group mb-3">
                    <label for="description" class="form-label">Achievement Description <span class="text-danger">*</span></label>
                    <textarea name="description" id="description" rows="5" class="form-control" placeholder="Enter achievement description"></textarea>
                </div>
                
                
                <!-- Awarded Date -->
                <div class="form-group mb-3">
                    <label for="achieved_at" class="form-label">Awarded Date</label>
                    <input type="date" name="achieved_at" id="achieved_at" class="form-control">
                </div>

                
                <!-- achievement Image -->
                <div class="form-group mb-3">
                    <label for="image" class="form-label">Achievement Attachment</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <div class="mt-3">
                        <img id="image-preview" src="#" alt="Image Preview" class="img-thumbnail" style="display: none; max-width: 200px; max-height: 200px;">
                    </div>
                </div>

                
                
                <!-- Submit Button -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save Achievement</button>
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
        $('#achievement-form').on('submit', function (e) {
            e.preventDefault();

     
            let isValid = true;
            const requiredFields = [
                { field: '#title', name: 'achievement Title' },
                { field: '#description', name: 'achievement Description' }
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
                url: "{{ route('achievement.store') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
               
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message, 'Success');
                        setTimeout(() => {
                            window.location.href = "{{ route('achievement.show') }}";
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
                        toastr.error('Failed to save achievement. Please try again.', 'Error');
                    }
                }
            });
        });
    });
</script>
@endsection
