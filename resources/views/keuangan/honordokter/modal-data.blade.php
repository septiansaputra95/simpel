<div class="modal fade" id="modal-data" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel"
	aria-modal="true" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-title-kategori">
                    FORM INPUT HONOR DOKTER
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<form id="form-hd">
                    <div class="input-group mb-3">
                        <label><b>Tanggal Awal: </b></label>
                        &nbsp;&nbsp;
                        <input type="date" class="form-control" id="form-tanggal-awal">
                    </div>
                    
                    <div class="input-group mb-3">
                        <label><b>Tanggal Akhir: </b></label>
                        &nbsp;&nbsp;
                        <input type="date" class="form-control" id="form-tanggal-akhir">
                    </div>

                    {{-- <div class="input-group mb-3">
                        <label><b>Dokter: </b></label>
                        &nbsp;&nbsp;
                        <select class="form-control" name="dokter_filed" id="dokter-field">
                        </select>
                    </div> --}}
                    
                    {{-- <div id="file-inputs-container">
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="file_1">
                            <button type="button" class="btn btn-outline-primary" id="add-file-button">+</button>
                            <button type="button" class="btn btn-outline-danger" id="remove-file-button">-</button>
                        </div>
                    </div> --}}
                    <input type="file" class="filepond" name="files[]" id="filepond-input" multiple accept="application/pdf">

                    <div id="file-inputs-container">
                        <div class="input-group mb-3">
                        </div>
                    </div>
                    
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-success" id="btn-simpan"></button>
			</div>
		</div>
	</div>
</div>