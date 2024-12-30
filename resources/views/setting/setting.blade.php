@extends('layouts.app')

@section('main-content')
<main class="main-content p-3">
    <div class="container">
        <h2 class="mb-4">Settings</h2>
        <div class="row">

            <!-- Update Logo -->
            <div class="col-12 mb-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">Update Logo</div>
                    <div class="card-body">
                        <form id="updateLogoForm" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="logo" class="form-label">Upload Logo</label>
                                <input type="file" id="logo" name="logo" class="form-control" accept="image/*" onchange="previewLogo(event)">
                            </div>
                            <div class="mb-3">
                                <img 
                                    id="logoPreview" 
                                    src="{{ auth()->user()->profile?->logo ? asset('storage/' . auth()->user()->profile->logo) : asset('images/default-logo.png') }}" 
                                    alt="Logo Preview" 
                                    class="img-thumbnail" 
                                    style="max-height: 150px; display: {{ auth()->user()->profile?->logo ? 'block' : 'none' }};">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Logo</button>
                        </form>
                    </div>
                </div>
            </div>

           <!-- Update Profile Picture -->
            <div class="col-12 mb-4">
                <div class="card shadow">
                    <div class="card-header bg-secondary text-white">Update Profile Picture</div>
                    <div class="card-body">
                        <form id="updateProfilePicForm" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="profile_picture" class="form-label">Upload Profile Picture</label>
                                <input 
                                    type="file" 
                                    id="profile_picture" 
                                    name="profile_picture" 
                                    class="form-control" 
                                    accept="image/*" 
                                    onchange="previewImage(event, 'profilePicturePreview')">
                            </div>
                            <div class="mb-3">
                                <img 
                                    id="profilePicturePreview" 
                                    src="{{ auth()->user()->profile?->profile_picture ? asset('storage/' . auth()->user()->profile->profile_picture) : asset('images/default-profile.png') }}" 
                                    alt="Profile Picture Preview" 
                                    class="img-thumbnail" 
                                    style="max-height: 150px; display: {{ auth()->user()->profile?->profile_picture ? 'block' : 'none' }};">
                            </div>
                            <button type="submit" class="btn btn-secondary">Update Profile Picture</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Update Resume -->
            <div class="col-12 mb-4">
                <div class="card shadow">
                    <div class="card-header bg-secondary text-white">Update Resume</div>
                    <div class="card-body">
                        <form id="updateResumeForm" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="resume" class="form-label">Upload Resume (PDF only)</label>
                                <input 
                                    type="file" 
                                    id="resume" 
                                    name="resume" 
                                    class="form-control" 
                                    accept="application/pdf" 
                                    onchange="previewPDF(event, 'resumePreview')">
                            </div>
                            <div class="mb-3">
                                <iframe 
                                    id="resumePreview" 
                                    src="{{ auth()->user()->profile?->resume ? asset('storage/' . auth()->user()->profile->resume) : '' }}" 
                                    class="w-100" 
                                    style="height: 300px; display: {{ auth()->user()->profile?->resume ? 'block' : 'none' }};">
                                </iframe>
                                <p id="noResumeText" style="display: {{ auth()->user()->profile?->resume ? 'none' : 'block' }};">No resume uploaded yet.</p>
                            </div>
                            <button type="submit" class="btn btn-secondary">Update Resume</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Update Profile Info -->
            <div class="col-12 mb-4">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">Update Profile Info</div>
                    <div class="card-body">
                        <form id="updateProfileInfoForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" id="phone" name="phone" class="form-control" value="{{ auth()->user()->profile->phone ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="whatsapp" class="form-label">WhatsApp</label>
                                    <input type="text" id="whatsapp" name="whatsapp" class="form-control" value="{{ auth()->user()->profile->whatsapp ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="designation" class="form-label">Designation</label>
                                    <input type="text" id="designation" name="designation" class="form-control" value="{{ auth()->user()->profile->designation ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="short_description" class="form-label">Short Description</label>
                                    <input type="text" id="short_description" name="short_description" class="form-control" value="{{ auth()->user()->profile->short_description ?? '' }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Update Profile Info</button>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Update Media Links -->
            <div class="col-12 mb-4">
                <div class="card shadow">
                    <div class="card-header bg-info text-white">Update Media Links</div>
                    <div class="card-body">
                        <form id="updateMediaLinksForm">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="github" class="form-label">GitHub</label>
                                    <input type="text" id="github" name="github" class="form-control" value="{{ auth()->user()->profile->github ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="linkedin" class="form-label">LinkedIn</label>
                                    <input type="text" id="linkedin" name="linkedin" class="form-control" value="{{ auth()->user()->profile->linkedin ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="twitter" class="form-label">Twitter</label>
                                    <input type="text" id="twitter" name="twitter" class="form-control" value="{{ auth()->user()->profile->twitter ?? '' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="facebook" class="form-label">Facebook</label>
                                    <input type="text" id="facebook" name="facebook" class="form-control" value="{{ auth()->user()->profile->facebook ?? '' }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info">Update Media Links</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Update Password -->
            <div class="col-12 mb-4">
                <div class="card shadow">
                    <div class="card-header bg-danger text-white">Update Password</div>
                    <div class="card-body">
                        <form id="updatePasswordForm">
                            <div class="mb-3">
                                <label for="password" class="form-label">Old Password</label>
                                <input type="password" id="old_password" name="old_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-danger">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    // Preview Logo Function
    function previewLogo(event) {
        const logoInput = event.target;
        const logoPreview = document.getElementById('logoPreview');

        if (logoInput.files && logoInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                logoPreview.src = e.target.result;
                logoPreview.style.display = 'block'; 
            };

            reader.readAsDataURL(logoInput.files[0]); 
        }
    }

    // Preview Image Function
    function previewImage(event, previewId) {
        const file = event.target.files[0];
        const preview = document.getElementById(previewId);

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

    // Preview PDF Function
    function previewPDF(event, previewId) {
        const file = event.target.files[0];
        const preview = document.getElementById(previewId);
        const noResumeText = document.getElementById('noResumeText');

        if (file && file.type === 'application/pdf') {
            const fileURL = URL.createObjectURL(file);
            preview.src = fileURL;
            preview.style.display = 'block';
            noResumeText.style.display = 'none';
        } else {
            preview.style.display = 'none';
            noResumeText.style.display = 'block';
            toastr.error('Please upload a valid PDF file.');
        }
    }

    // Logo Upload
    $(document).ready(function() {
        $('#updateLogoForm').submit(function(e) {
            e.preventDefault();  

            let formData = new FormData(this);

            $.ajax({
                url: '/update-logo', 
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
   
                    toastr.success('Logo updated successfully!');

                    $('#logoPreview').attr('src', response.logo_url).show();
                },
                error: function(xhr, status, error) {
          
                    toastr.error('An error occurred while updating the logo.');
                }
            });
        });
    });

    //profile photo update
    $('#updateProfilePicForm').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: '/update-profile-picture', 
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                toastr.success(response.message);
                $('#profilePicturePreview').attr('src', response.profile_picture_url).show();
            },
            error: function(xhr, status, error) {
                const response = xhr.responseJSON;
                toastr.error(response.error || 'An error occurred while updating the profile picture.');
            }
        });
    });

    // Resume  Update
    $('#updateResumeForm').submit(function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: '/update-resume',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                toastr.success(response.message);
                $('#resumePreview').attr('src', response.resume_url).show();
                $('#noResumeText').hide();
            },
            error: function (xhr, status, error) {
                const response = xhr.responseJSON;
                toastr.error(response.error || 'An error occurred while updating the resume.');
            }
        });
    });

    // Update Profile Info
    $('#updateProfileInfoForm').submit(function(e) {
        e.preventDefault();

        let formData = $(this).serialize();  // Serialize the form data

        $.ajax({
            url: '/update-profile-info',  // Endpoint to update profile info
            type: 'POST',
            data: formData,
            success: function(response) {
                toastr.success('Profile info updated successfully!');
            },
            error: function(xhr, status, error) {
                const response = xhr.responseJSON;
                toastr.error(response.error || 'An error occurred while updating profile info.');
            }
        });
    });

    // Update Media Links
    $('#updateMediaLinksForm').submit(function(e) {
        e.preventDefault();

        let formData = $(this).serialize();  

        $.ajax({
            url: '/update-media-links',  
            type: 'POST',
            data: formData,
            success: function(response) {
                toastr.success('Media links updated successfully!');
            },
            error: function(xhr, status, error) {
                const response = xhr.responseJSON;
                toastr.error(response.error || 'An error occurred while updating media links.');
            }
        });
    });

    // Update Password
    $('#updatePasswordForm').submit(function (e) {
        e.preventDefault();

        const password = $('#password').val().trim();
        const confirmPassword = $('#confirm_password').val().trim();

        // Check passwords match on the client side
        if (password !== confirmPassword) {
            toastr.error('Password and Confirm Password must match.');
            return;
        }

        // Proceed with AJAX submission
        let formData = $(this).serialize();

        $.ajax({
            url: '/update-password',
            type: 'POST',
            data: formData,
            success: function (response) {
                toastr.success(response.message || 'Password updated successfully!');
            },
            error: function (xhr) {
                const status = xhr.status;
                let response;

                try {
                    // Parse the JSON response
                    response = JSON.parse(xhr.responseText);
                } catch (e) {
                    console.error('Error parsing response:', e);
                    toastr.error('An unexpected error occurred.');
                    return;
                }

                if (status === 400 && response.error) {
                    // Handle specific error for incorrect old password
                    toastr.error(response.error);
                } else if (response.errors) {
                    // Handle validation errors
                    Object.values(response.errors).forEach((messages) => {
                        messages.forEach((message) => {
                            toastr.error(message);
                        });
                    });
                } else {
                    // Generic fallback for unexpected errors
                    toastr.error('An unexpected error occurred.');
                }
            },
        });

    });











</script>
    
@endsection



