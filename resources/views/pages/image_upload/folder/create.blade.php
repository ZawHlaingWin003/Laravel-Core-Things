@extends('layouts.app')

@section('content')

{{ Breadcrumbs::render('folder_create') }}

    <div class="w-25 mx-auto">
        <div class="card">
            <div class="card-body text-center">
                <p class="display-3"><i class="fa-solid fa-folder-open"></i></p>
                <form action="{{ route('folder.store') }}" method="POST">
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter Folder Name">
                        <label for="name">Enter Folder Name</label>
                        @error('name')
                            <p class="text-danger text-start"><small>**{{ $message }}</small></p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Add Folder</button>

                </form>
            </div>
        </div>
    </div>
@endsection
