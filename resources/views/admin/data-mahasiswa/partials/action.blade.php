<div>
    <div class="position-relative">
        <button class="btn btn-light btn-active-light-warning btn-flex btn-center" data-action="edit" @can($globalModule['update']) @else disabled @endcan
            button-url="{{ $editRoute }}" modal-id="#data-mahasiswa-modal"><i class="bi bi-pen me-2"></i> Edit
        </button>
    </div>