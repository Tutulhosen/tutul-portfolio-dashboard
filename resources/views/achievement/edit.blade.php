@extends('layouts.app')

@section('main-content')
<main class="main-content p-3">
    <div class="d-flex justify-content-between align-items-center mt-5">
        <h2>Edit Achievement</h2>
        <a href="{{ route('achievement.show') }}" class="btn btn-secondary">Back to Achievement</a>
    </div>
    <br>

    <div class="card">
        <div class="card-body">
            <form id="achievement-form" action="{{ route('achievement.update', $achievement->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
            
                <!-- Achievement Title -->
                <div class="form-group mb-3">
                    <label for="title" class="form-label">Achievement Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $achievement->title) }}" placeholder="Enter achievement title">
                </div>
                
                <!-- Achievement Description -->
                <div class="form-group mb-3">
                    <label for="description" class="form-label">Achievement Description <span class="text-danger">*</span></label>
                    <textarea name="description" id="description" rows="5" class="form-control" placeholder="Enter achievement description">{{ old('description', $achievement->description) }}</textarea>
                </div>
                
                <!-- Awarded Date -->
                <div class="form-group mb-3">
                    <label for="achieved_at" class="form-label">Awarded Date</label>
                    <input type="date" name="achieved_at" id="achieved_at" class="form-control" value="{{ old('achieved_at', $achievement->achieved_at) }}">
                </div>
                
                <!-- Achievement Image -->
                <div class="form-group mb-3">
                    <label for="image" class="form-label">Achievement Attachment</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                    @if($achievement->attached_file)
                        <div class="mt-3">
                            <img id="image-preview" src="{{ asset('storage/' . $achievement->attached_file) }}" alt="Image Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                        </div>
                    @endif
                </div>
            
                <!-- Submit Button -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" id="update-achievement">Update Achievement</button>

                </div>
            </form>
            
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    // Image Preview Script
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

    $(document).ready(function () {
        $('#achievement-form').on('submit', function (e) {
            e.preventDefault();

            let isValid = true;
            const requiredFields = [
                { field: '#title', name: 'Achievement Title' },
                { field: '#description', name: 'Achievement Description' }
            ];

            // Validate required fields
            requiredFields.forEach((item) => {
                if (!$(item.field).val().trim()) {
                    isValid = false;
                    toastr.error(`${item.name} is required.`, 'Validation Error');
                }
            });

            if (!isValid) {
                return; // Stop if validation fails
            }

            let formData = new FormData(this);

            // Get the form action URL dynamically
            let actionUrl = $(this).attr('action');

            $.ajax({
                url: actionUrl, // Use the dynamic URL
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
                        toastr.error('Failed to update achievement. Please try again.', 'Error');
                    }
                }
            });
        });
    });

</script>


@endsection
