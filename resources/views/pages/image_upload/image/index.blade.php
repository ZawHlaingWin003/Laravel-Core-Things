@extends('layouts.app')

@section('custom_styles')
<style>
    .gallery-container{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .gallery-row{
        display: flex;
        flex-direction: column;
        width: 32.5%;
    }
    .gallery-row img{
        width: 100%;
        border-radius: 5px;
        margin: 5px 0;
        border: 2px solid black;
    }

    .gallery-item{
        position: relative;
    }
    .gallery-item:hover .delete-icon,.gallery-item:hover .download-icon{
        /* display: block; */
        /* visibility: visible; */
        opacity: 1;
    }

    .download-icon, .delete-icon{
        /* display: none; */
        /* visibility: hidden; */
        opacity: 0;
        position: absolute;
        background: black;
        transition: all .5s;
    }
    .download-icon{
        bottom: 5px;
        right: 0;
        padding: 15px 15px 12px 18px;
        border-radius: 40px 0 0 0;
    }
    .delete-icon{
        bottom: 5px;
        left: 0;
        padding: 15px 20px 10px 15px;
        border-radius: 0 40px 0 0;
    }
    .download-icon a, .delete-icon a{
        color: white
    }

    @media only screen and (max-width: 769px){
        .gallery-container{
            flex-direction: column;
        }

        .gallery-container .gallery-row{
            width: 100%;
        }

    }

</style>
@endsection

@section('content')

{{ Breadcrumbs::render('images', $folder) }}

<div class="row justify-content-center">
    <div class="col-md-8">
        <h3 class="text-center my-3">Multiple Images Upload</h3>

        <form action="{{ route('image.store') }}" method="POST" enctype="multipart/form-data" id="upload-image-form">
            @csrf

            <input type="hidden" name="folder_id" id="folder-id-input" value="{{ $folder->id }}">
            <div class="input-group">
                <input type="file" class="form-control" id="images-input" name="images[]" multiple>
                <button class="btn btn-outline-primary" type="submit" id="upload-image-button">Upload</button>
            </div>
            <p class="text-start text-danger m-0"><small class="error-text images__err"></small></p>
        </form>
    </div>
</div>

<div class="gallery-container mt-5">
    <img src="{{ asset('assets/img/loading4.gif') }}" alt="" class="mx-auto loading-gif">
</div>

@endsection

@section('custom_scripts')
    <script>

        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let folder_id = $('#folder-id-input').val();

            // Get All Images when document ready
            function getAllImages(){
                $.ajax({
                    type: "GET",
                    url: "/ajax/images/"+folder_id,
                    success: function (response) {
                        let output = '';
                        if(response.images.length){
                            output += `<div class="gallery-row">`;

                            $.each(response.images[0], function (i, value) {
                                output += `
                                    <div class="gallery-item">
                                        <a href="${value.filename}" class="lightbox" data-caption="${value.filename}">
                                            <img src="${value.filename}" class="img-fluid gallery" id="image_item" alt="${value.filename}">
                                        </a>
                                        <div class="download-icon"><a href=""><i class="fa-solid fa-download"></i></a></div>
                                        <div class="delete-icon"><a href="/image/destroy/${value.id}" id="delete-image" data-id="${value.id}"><i class="fa-solid fa-trash"></i></a></div>
                                    </div>
                                `;
                            });

                            output += `
                                </div>
                                <div class="gallery-row">
                            `;

                            $.each(response.images[1], function (i, value) {
                                output += `
                                    <div class="gallery-item">
                                        <a href="${value.filename}" class="lightbox" data-caption="${value.filename}">
                                            <img src="${value.filename}" class="img-fluid gallery" id="image_item" alt="${value.filename}">
                                        </a>
                                        <div class="download-icon"><a href=""><i class="fa-solid fa-download"></i></a></div>
                                        <div class="delete-icon"><a href="/image/destroy/${value.id}" id="delete-image" data-id="${value.id}"><i class="fa-solid fa-trash"></i></a></div>
                                    </div>
                                `;
                            });
                            output += `
                                </div>
                                <div class="gallery-row">
                            `;

                            $.each(response.images[2], function (i, value) {
                                output += `
                                    <div class="gallery-item">
                                        <a href="${value.filename}" class="lightbox" data-caption="${value.filename}">
                                            <img src="${value.filename}" class="img-fluid gallery" id="image_item" alt="${value.filename}">
                                        </a>
                                        <div class="download-icon"><a href=""><i class="fa-solid fa-download"></i></a></div>
                                        <div class="delete-icon"><a href="/image/destroy/${value.id}" id="delete-image" data-id="${value.id}"><i class="fa-solid fa-trash"></i></a></div>
                                    </div>
                                `;
                            });

                            output += `</div>`;

                        }else{
                            output += `
                            <div class="container">
                                <p class="text-center text-danger fw-bold my-5">
                                    Please Upload Your Images!
                                </p>
                            </div>
                            `;
                        }

                        $('.gallery-container').html(output);
                        baguetteBox.run('.gallery-container');

                    }
                });
            }
            getAllImages();

            // Create New Images when user submit form
            $(document).on('submit', '#upload-image-form', function(e) {
                e.preventDefault();
                $('#upload-image-button').prop('disabled', true);
                $.ajax({
                    type: "POST",
                    url: "/images/store",
                    data: new FormData(this),
                    dataType: "JSON",
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if(response.code == 200){
                            $('#upload-image-button').prop('disabled', false);
                            $('#images-input').val('').removeClass('is-invalid');
                            $('.error-text').text('');
                            getAllImages();
                            let action = 'success';
                            let alert = response.message;
                            Command: toastr[action](alert)

                            toastr.options = {
                                "closeButton": true,
                                "progressBar": true,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "500",
                                "timeOut": "2000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            }
                        }else if(response.code == 400){
                            $('#upload-image-button').prop('disabled', false);
                            $('#images-input').addClass('is-invalid');
                            printErrorMsg(response.errors);
                        }
                    }
                });
            })

            // Delete Image When user click trash can
            $(document).on('click', '#delete-image', function (e){
                e.preventDefault();
                let image_id = $(this).attr('data-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "/images/"+image_id,
                            success: function (response) {
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                )
                                getAllImages();
                            }
                        });
                    }
                })

            });


            // show validation error message
            function printErrorMsg(errors){
                $.each(errors, function( key, value ) {
                    $("."+key+"__err").text('** ' + value);
                });
            }
        });

    </script>
@endsection
