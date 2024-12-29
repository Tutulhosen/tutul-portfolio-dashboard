@extends('layouts.app')

@section('main-content')
    <main class="main-content">
        <div class="container">
            <h1>Edit About Me</h1>

            <!-- The form to edit content -->
            <form id="about-me-form" method="POST" action="{{ route('about.update', $aboutMe->id) }}">
                @csrf
                <div class="form-group">
                    <label for="content">About Me</label>
                    <textarea name="content" id="content" class="form-control">{{ old('content', $aboutMe->content) }}</textarea>
                </div><br>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        document.getElementById('about-me-form').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission

            const form = this;
            const formData = new FormData(form);

            fetch("{{ route('about.update', $aboutMe->id) }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success(data.message);
                    
                    // Set a 2-second delay before redirecting
                    setTimeout(function () {
                        window.location.href = data.redirect;
                    }, 2000); // 2 seconds
                } else {
                    toastr.error(data.message || 'Something went wrong.');
                }
            })
            .catch(error => {
                toastr.error('An error occurred. Please try again.');
                console.error('Error:', error);
            });
        });
    </script>
@endsection
