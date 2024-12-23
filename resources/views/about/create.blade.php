@extends('layouts.app')

@section('main-content')
    <main class="main-content">
        <div class="container">
            <h1>Create About Me</h1>

            <form id="about-me-form" method="POST">
                @csrf
                <div class="form-group">
                    <label for="content">About Me</label>
                    <textarea name="content" id="content"></textarea>
                </div><br>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
            
        </div>
    </main>


@endsection

@section('scripts')
    <script>
        document.getElementById('about-me-form').addEventListener('submit', function (e) {
            e.preventDefault(); 

            const form = this;
            const formData = new FormData(form);
            const content = document.getElementById('content').value;
            
            // Validate content
            if (!content.trim()) {
                toastr.error('The About Me section cannot be empty.');
                return;
            }

            fetch("{{ route('about.store') }}", {
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
                    form.reset();

             
                    setTimeout(function () {
                      
                        if (data.redirect) {
                            window.location.href = data.redirect;  
                        }
                    }, 2000); 
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
