<!-- Modal -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Edit Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBodyEdit">
                <form id="formEdit">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="nimBefore" id="nimBefore">
                    <div class="mb-3">
                        <label for="namaEdit" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="namaEdit" name="nama">
                      </div>
                      <div class="mb-3">
                        <label for="nimEdit" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="nimEdit" name="nim">
                      </div>
                      <div class="mb-3">
                        <label for="prodiEdit" class="form-label">Prodi</label>
                        <input type="text" class="form-control" id="prodiEdit" name="prodi">
                      </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="modalCloseEdit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="editMahasiswa" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </div>
</div>



