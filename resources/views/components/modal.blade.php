<div class="modal fade" id="crudModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="crudForm" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="crudModalTitle">Loading...</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="crudModalBody">
                <p class="text-center">Memuat...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" id="crudSaveBtn">Simpan</button>
            </div>
        </form>
    </div>
</div>
