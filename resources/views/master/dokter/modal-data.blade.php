<div class="modal fade" id="modal-data" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel"
	aria-modal="true" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-title-kategori">
                    FORM INPUT MASTER DOKTER
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<form id="form-hd">
                    <div class="input-group mb-3">
                        <label><b>Kode Dokter:</b></label>
                        &nbsp;&nbsp;
                        <input type="text" class="form-control" id="kode-dokter" placeholder="Kode Dokter HINAI" readonly>
                    </div>
                    
                    <div class="input-group mb-3">
                        <label><b>Nama Dokter: </b></label>
                        &nbsp;&nbsp;
                        <input type="text" class="form-control" id="nama-dokter" placeholder="Nama Dokter">
                    </div>

                    <div class="input-group mb-3">
                        <label><b>Email Dokter: </b></label>
                        &nbsp;&nbsp;
                        <input type="text" class="form-control" id="email-dokter" placeholder="Email Pribadi Dokter">
                    </div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-success" id="btn-simpan"></button>
				<button type="button" class="btn btn-warning" id="btn-update"></button>
			</div>
		</div>
	</div>
</div>