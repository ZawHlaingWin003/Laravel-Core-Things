

<!-- Crete Folder Modal -->
<div class="modal fade" id="createFolderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Create New Folder</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body text-center">
                        <p class="display-3"><i class="fa-solid fa-folder-open"></i></p>
                        <form action="{{ route('folder.store') }}" method="POST" id="add-folder-form">
                            @csrf

                            <div class="form-floating mb-3">
                                <input type="text" name="name" class="form-control folder-name-input" id="name" placeholder="Enter Folder Name">
                                <label for="name">Enter Folder Name</label>
                                <p class="text-start text-danger m-0"><small class="error-text name__err"></small></p>
                            </div>
                            <button type="submit" class="btn btn-primary" id="add-folder-btn">Add Folder</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
