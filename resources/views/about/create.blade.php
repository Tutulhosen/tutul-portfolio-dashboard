@extends('layouts.app')

@section('main-content')
    <main class="main-content">
        <div class="container">
            <h1>Create About Me</h1>

            <form action="{{ route('about.store') }}" method="POST">
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
