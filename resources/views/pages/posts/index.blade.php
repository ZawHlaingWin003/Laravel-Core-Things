@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between">
            <a href="" class="btn btn-primary mb-3">Create Post</a>
            <p>Total Posts - {{ count($posts) }}</p>
        </div>
        <div class="row">
            @forelse ($posts as $post)
                <div class="col-md-4 my-2">
                    <div class="card">
                        <img src="{{ asset('assets/img/img10.jpeg') }}" class="card-img-top img-fluid w-100" alt="...">
                        <div class="card-body">
                            <h4>
                                {{ $post->title }}
                            </h4>
                            <p class="card-text">
                                {{ $post->excerpt }}
                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-primary">Edit</a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            <a href="#" class="btn btn-info float-end">Detail</a>
                        </div>
                    </div>
                </div>
            @empty
        </div>
    </div>
    <h1 class="text-center">
        There's no Posts.
    </h1>
    @endforelse
@endsection
