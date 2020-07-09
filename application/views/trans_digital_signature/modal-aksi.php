
<!-- Modal tambah bahan_ajar-->
<div class="modal fade" id="modal-aksi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form-upload-file">
      <div class="modal-body">
          <div class="form-group">
              <label for="">Nama Dokumen*:</label>
              <input type="hidden" name="aksi" id="aksi">
              
              <input type="hidden" name="id_trans" id="id_trans">
              <input type="text" name="nama_dokumen" id="nama_dokumen" class="form-control">
          </div>
          <div class="form-group">
              <label for="">No Sertifikat:</label>
              <input type="text" name="no_sertifikat" id="no_sertifikat" class="form-control">
          </div>
          <div class="form-group">
              <label for="">File: (PDF)</label>
              <input type="file" name="file_upload" id="file_upload" class="form-control" required/>
          </div>
          <!-- <div class="form-group">
              <label for="">Tanggal Dokumen:</label>
              <input type="text" name="tanggal_kegiatan" id="tanggal_kegiatan" class="form-control">
          </div> -->
          <small>*wajib isi</small>
          <div class="notif"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
