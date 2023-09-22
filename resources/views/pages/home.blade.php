@extends('layouts.app')

@section('content')

@php
    $colors = ['primary', 'warning', 'danger', 'success', 'info', 'dark'];
    $carousel_items = [
        [
            'icon_class' => 'fa-solid fa-folder',
            'title' => 'Laravel Authorization',
            'color' => $colors[rand(0,5)],
            'route' => 'posts.index'
        ],
        [
            'icon_class' => 'fa-solid fa-image',
            'title' => 'Laravel Image Upload',
            'color' => $colors[rand(0,5)],
            'route' => 'folder.index'
        ],
        [
            'icon_class' => 'fa-solid fa-link',
            'title' => 'Laravel Relationship',
            'color' => $colors[rand(0,5)],
            'route' => 'folder.index'
        ],
        [
            'icon_class' => 'fa-solid fa-envelope',
            'title' => 'Laravel Mail & Notification',
            'color' => $colors[rand(0,5)],
            'route' => 'folder.index'
        ],
    ];
@endphp
<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        @foreach ($carousel_items as $item)
            <div class="carousel-item @if($loop->first) active @endif">
                <div class="card w-50 mx-auto text-center">
                    <div class="card-body">
                        <p class="display-3 text-{{ $item['color'] }}">
                            <i class="{{ $item['icon_class'] }}"></i>
                        </p>
                    </div>
                    <div class="card-footer">
                        <h3>
                            <a href="{{ route($item['route']) }}" class="text-decoration-none">{{ $item['title'] }}</a>
                        </h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <button class="carousel-control-prev bg-danger" type="button" data-bs-target="#carouselExampleControls"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next bg-danger" type="button" data-bs-target="#carouselExampleControls"
        data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

@endsection
