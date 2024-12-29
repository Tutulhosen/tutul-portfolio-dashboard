@extends('layouts.app')

@section('main-content')
<main class="main-content p-3">
    <div class="d-flex justify-content-between align-items-center mt-5">
        <h4>Edit Contact Submission</h4>
    </div><br>

    <div class="card">
        <div class="card-body">
            <form id="contact-form" action="{{ route('contact.update', $contact->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $contact->name }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ $contact->email }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" class="form-control" value="{{ $contact->subject }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" class="form-control" rows="5" required>{{ $contact->message }}</textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success" id="update-contact-btn">Update</button>
                    <a href="{{ route('contact.show') }}" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('scripts')
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function () {
        $('#contact-form').on('submit', function (e) {
            e.preventDefault();

            let formData = $(this).serialize();
            let actionUrl = $(this).attr('action');

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                success: function (response) {
                    toastr.success('Contact updated successfully!');
                    setTimeout(() => {
                        window.location.href = "{{ route('contact.show') }}";
                    }, 2000); // Redirect after 2 seconds
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            toastr.error(value[0]);
                        });
                    } else {
                        toastr.error('Something went wrong. Please try again.');
                    }
                }
            });
        });
    });
</script>
@endsection
