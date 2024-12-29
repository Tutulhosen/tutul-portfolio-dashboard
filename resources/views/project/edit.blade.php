@extends('layouts.app')

@section('main-content')
<main class="main-content p-3">
    <div class="d-flex justify-content-between align-items-center mt-5">
        <h2>Edit Project</h2>
        <a href="{{ route('project.show') }}" class="btn btn-secondary">Back to Projects</a>
    </div>
    <br>

    <div class="card">
        <div class="card-body">
            <form id="project-form" action="{{ route('project.update', $project->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Project Title -->
                <div class="form-group mb-3">
                    <label for="title" class="form-label">Project Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $project->title) }}" placeholder="Enter project title">
                </div>
                
                <!-- Project Description -->
                <div class="form-group mb-3">
                    <label for="description" class="form-label">Project Description <span class="text-danger">*</span></label>
                    <textarea name="description" id="description" rows="5" class="form-control" placeholder="Enter project description">{{ old('description', $project->description) }}</textarea>
                </div>
                
                <!-- Project Status -->
                <div class="form-group mb-3">
                    <label for="status" class="form-label">Project Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="1" @if($project->status == 1) selected @endif>Active</option>    
                        <option value="0" @if($project->status == 0) selected @endif>Inactive</option>
                    </select>
                </div>
                
                <!-- Start Date -->
                <div class="form-group mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $project->start_date) }}">
                </div>
                
                <!-- End Date -->
                <div class="form-group mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $project->end_date) }}">
                </div>
                
                <!-- Project Image -->
                <div class="form-group mb-3">
                    <label for="image" class="form-label">Project Image</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                    @if($project->image)
                        <div class="mt-3">
                            <img id="image-preview" src="{{ asset('storage/' . $project->image) }}" alt="Image Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                        </div>
                    @endif
                </div>

                <!-- Project Link -->
                <div class="form-group mb-3">
                    <label for="link" class="form-label">Project Link</label>
                    <input type="url" name="link" id="link" class="form-control" value="{{ old('link', $project->link) }}" placeholder="Enter project link">
                </div>

                <!-- GitHub Link -->
                <div class="form-group mb-3">
                    <label for="link" class="form-label">GitHub Link</label>
                    <input type="url" name="github_link" id="github_link" class="form-control" value="{{ old('github_link', $project->github_link) }}" placeholder="Enter GitHub link">
                </div>
                
                <!-- Submit Button -->
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update Project</button>
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
</script>
@endsection
