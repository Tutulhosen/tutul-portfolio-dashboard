@extends('layouts.app')

@section('main-content')
<main class="main-content p-3">
    <div class="d-flex justify-content-between align-items-center mt-5">
        <h2>Edit Skill</h2>
        <a href="{{ route('skill.show') }}" class="btn btn-secondary">Back to Skills</a>
    </div>
    <br>

    <div class="card">
        <div class="card-body">
            <form id="skill-form" action="{{ route('skill.update', $skill->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Skill Title -->
                <div class="form-group mb-3">
                    <label for="title" class="form-label">Skill Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ $skill->title }}" placeholder="Enter skill title">
                </div>

                <!-- Skill Icon -->
                <div class="form-group mb-3">
                    <label for="icon" class="form-label">Bootstrap Icon (e.g., fas fa-html5)</label>
                    <input type="text" name="icon" id="icon" class="form-control" value="{{ $skill->icon }}" placeholder="Enter bootstrap icon name">
                </div>

                <!-- Custom Skill Image (optional) -->
                <div class="form-group mb-3">
                    <label for="image" class="form-label">Custom Skill Image (If Bootstrap Icon isn't available)</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    @if ($skill->image && $skill->image !='default_skill_image.jpg')
                        <div class="mt-3" id="image-preview">
                            <img src="{{ asset('storage/' . $skill->image) }}" alt="Image Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                        </div>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update Skill</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#image').on('change', function (event) {
            const preview = $('#image-preview img');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    if (!preview.length) {
                        $('#image-preview').append('<img src="#" alt="Image Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">');
                    }
                    preview.attr('src', e.target.result);
                    $('#image-preview').show();
                };

                reader.readAsDataURL(file);
            } else {
                preview.attr('src', '#');
                $('#image-preview').hide();
            }
        });
    });
</script>
@endsection
