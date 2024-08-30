<div class="modal fade" id="modal-data" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel"
	aria-modal="true" role="dialog">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-title-kategori">
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<form id="form-kategori">

					<div class="row">
                        <div class="col-auto">
                            <label class="col-form-label">TANGGAL TASK LIST</label> 
                        </div>
                        <div class="col-auto">
                            <input type="date" class="form-control me-2" id="tanggal-task">
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-success" id="btn-simpan">Simpan</button>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-warning" id="btn-caridb">Cari Database</button>
                        </div>
                        <br>
                        <br>
                        <div class="border p-2">
                            <table class="table table-bordered" id="tabel-modal">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Kode Booking</th>
                                        <th scope="col">MRN</th>
                                        <th scope="col">SEP</th>
                                        <th scope="col">No Kartu Pasien</th>
                                        <th scope="col">Kode Poli</th>
                                        <th scope="col">Task 1</th>
                                        <th scope="col">Task 2</th>
                                        <th scope="col">Task 3</th>
                                        <th scope="col">Task 4</th>
                                        <th scope="col">Task 5</th>
                                        <th scope="col">Task 65</th>
                                        <th scope="col">Task 7</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-warning" id="btn-update"></button>

			</div>
		</div>
	</div>
</div>