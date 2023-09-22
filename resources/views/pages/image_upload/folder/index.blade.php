@extends('layouts.app')

@section('custom_styles')
<style>
    a{
        text-decoration: none;
    }
    .folder-card{
        position: relative;
    }
    .folder-card:hover .setting{
        display: block;
    }

    .setting{
        position: absolute;
        right: 10px;
        top: 10px;
    }

    .setting-icon{
        border: 1px solid #ddd;
        padding-left: 5px;
        padding-right: 5px;
        border-radius: 50%;
        cursor: pointer;
        display: inline-block;
        margin-bottom: 3px;
        float: right;
        transition: all .5s;
    }
    .setting-icon:hover, .setting-icon.active{
        border-color: blue;
    }
    .setting-icon:hover i, .setting-icon.active i{
        color: blue;
    }

    .setting-actions{
        display: none;
        clear: both;
    }
    .setting-actions a, .setting-actions button{
        display: block;
        user-select: none;
        font-size: .8rem;
        padding: .5rem 1rem;
        margin-bottom: 3px;
        border: 1px solid #ddd;
        border-radius: 3px;
        background: #eee;
    }
    .setting-actions a:hover, .setting-actions button:hover{
        background: #ddd;
    }

    .edit-input{
        font-weight: bold;
    }

</style>
@endsection

@section('content')

{{ Breadcrumbs::render('folders') }}

<div class="folders">
    <div class="loading d-flex justify-content-center align-items-center" style="width: 100%;">
        <img src="{{ asset('assets/img/loading2.gif') }}" alt="Loading GIF">
    </div>
</div>

@endsection


@section('custom_scripts')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Fetch All Folders from database When Document Ready
        function getAllFolders(){
            $.ajax({
                type: "GET",
                url: "/ajax/folders",
                success: function (response) {
                    let output = '';
                    if(response.length){
                        output += `
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createFolderModal" id="open-folder-modal">
                                Create New Folder
                            </button>
                            <div class="row my-5">
                        `;

                        $.each(response, function (i, value) {
                            output += `
                                <div class="col-md-3 my-3">
                                    <div class="card folder-card">
                                        <div class="setting">
                                            <p class="setting-icon">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </p>
                                            <div class="setting-actions">
                                                <a class="text-success" id="edit-folder" data-id="${value.id}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                                <form action="folders/${value.id}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="text-danger" type="submit" id="delete-folder" data-id="${value.id}"><i class="fa-solid fa-trash"></i> Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="card-body text-center">
                                            <p class="display-3"><i class="fa-solid fa-folder-open"></i></p>
                                            <a href="folders/${value.id}" class="d-block" id="folder-name-${value.id}">
                                                <p class="fw-bold" id="folder-${value.id}">${value.name}</p>
                                            </a>
                                            <form action="folders/${value.id}" method="POST" class="d-none" id="edit-form-${value.id}" data-id="${value.id}">
                                                @csrf
                                                @method('PUT')

                                                <input type="text" class="form-control edit-input" name="name" id="edit-input-${value.id}" value="${value.name}">
                                                <p class="text-start text-danger m-0"><small class="error-text name__err"></small></p>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        output += `
                            </div>
                        `;

                        $(".folders").html(output);
                    }else{
                        output += `
                            <div class="w-75 mx-auto my-5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ route('folder.create') }}" class="text-decoration-none">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <p class="display-3">
                                                        <i class="fa-solid fa-folder-plus"></i>
                                                    </p>
                                                    <p>Create New Folder</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="" class="text-decoration-none">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <p class="display-3">
                                                        <i class="fa-solid fa-folder-plus"></i>
                                                    </p>
                                                    <p>Create New Folder</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                    }

                    $('.folders').html(output)
                }
            });
        }
        getAllFolders();

        // clear input value and remove class when user click button to open modal
        $(document).on('click', '#open-folder-modal', function () {
            $('.folder-name-input').removeClass('is-invalid').val('');
            $('.error-text').text('');
        })

        // Create new folder when user submit the form
        $(document).on('submit', '#add-folder-form', function (e) {
            e.preventDefault();
            $('#add-folder-btn').prop('disabled', true);
            let folder_name = $('.folder-name-input').val();

            $.ajax({
                type: "POST",
                url: "/folders/store",
                data: {
                    name : folder_name
                },
                dataType: "JSON",
                success: function (response) {
                    $('#add-folder-btn').prop('disabled', false);
                    getAllFolders();
                    $('#createFolderModal').modal('hide');
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
                },
                error: function (response) {
                    $('#add-folder-btn').prop('disabled', false);
                    $('.folder-name-input').addClass('is-invalid');
                    printErrorMsg(response.responseJSON.errors);
                }
            });
        });

        // When User Click setting, action buttons will fade in and fade out
        $(document).on('click', '.setting-icon', function(){
            $(this).toggleClass('active');
            $(this).next().fadeToggle(100)
        })

        // When User Click body (except setting), action buttons will also toggle
        $(document).click(function(event) {
            if (!$(event.target).closest(".setting").length) {
                $("body").find(".setting-icon").removeClass("active");
                $("body").find(".setting-icon").next().hide();
            }
        });

        // Delete Folder when user click delete button and confirm to delete
        $(document).on('click', '#delete-folder', function(e){
            e.preventDefault();
            var folder_id = $(this).attr('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "Your images which is inside this folder will also be deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "/folders/"+folder_id,
                        success: function (response) {
                            getAllFolders();
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            )
                        }
                    });
                }
            })
        })

        // When user click edit button from setting, Toggle input box and text
        $(document).on('click', '#edit-folder', function(e){
            e.preventDefault();
            $('.error-text').text('');
            var folder_id = $(this).attr('data-id');
            $('#edit-input-'+folder_id).removeClass('is-invalid');
            $('#folder-name-'+folder_id).toggleClass('d-block').toggleClass('d-none');
            $('#edit-form-'+folder_id).toggleClass('d-none').toggleClass('d-block');
        })

        // When user enter(submit) the edit form, Run this function
        $(document).on('submit', 'form[id*="edit-form-"]', function (e) {
            e.preventDefault();
            let folder_id = $(this).attr('data-id');
            let name = $('#edit-input-'+folder_id).val();
            $.ajax({
                type: "PUT",
                url: "/folders/"+folder_id,
                data: {
                    name
                },
                dataType: 'JSON',
                beforeSend: function (){
                    $('.error-text').text('');
                },
                success: function (response) {
                    console.log(response)
                    if(response.code == 200){
                        $('#folder-name-'+folder_id).toggleClass('d-none').toggleClass('d-block');
                        $('#edit-form-'+folder_id).toggleClass('d-block').toggleClass('d-none');
                        $('#folder-'+folder_id).html(name);

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
                        $('.edit-input').addClass('is-invalid');
                        printErrorMsg(response.errors);
                    }
                }
            });

        })

        // show validation error message
        function printErrorMsg(errors){
            $.each(errors, function( key, value ) {
                $("."+key+"__err").text('** ' + value);
            });
        }

    });
</script>
@endsection
