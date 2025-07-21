<div class="col-12">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Purchase Order</h5>
        </div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Nama Pekerjaan</label>
                <input class="form-control bg-dark" type="text" value="{{ $purchaseOrder->nama_pekerjaan }}" readonly />
            </div>

            <div class="col-md-6">
                <label class="form-label">Vendor</label>
                <input class="form-control bg-dark" type="text" value="{{ $purchaseOrder->vendor->vendor_name ?? '-' }}" readonly />
            </div>

            <div class="col-md-6">
                <label class="form-label">No PO</label>
                <input class="form-control bg-dark" type="text" value="{{ $purchaseOrder->no_po ?? '-' }}" readonly />
            </div>

            <div class="col-md-6">
                <label class="form-label">Jenis Pekerjaan</label>
                <input class="form-control bg-dark" type="text" value="{{ $purchaseOrder->jenis_pekerjaan == 'jasa_perorangan' ? 'Jasa Perorangan' : 'Jasa Non Perorangan' }}" readonly />
            </div>

            <div class="col-md-6">
                <label class="form-label">Area Pekerjaan</label>
                <input class="form-control bg-dark" type="text" value="{{ $purchaseOrder->area_pekerjaan }}" readonly />
            </div>

            <div class="col-md-6">
                <label class="form-label">Lokasi Pekerjaan</label>
                <input class="form-control bg-dark" type="text" value="{{ $purchaseOrder->lokasi_pekerjaan }}" readonly />
            </div>

            <div class="col-md-6">
                <label class="form-label">Tanggal Mulai</label>
                <input class="form-control bg-dark" type="text" value="{{ \Carbon\Carbon::parse($purchaseOrder->tanggal_mulai)->format('d M Y') }}" readonly />
            </div>

            <div class="col-md-6">
                <label class="form-label">Tanggal Akhir</label>
                <input class="form-control bg-dark" type="text" value="{{ \Carbon\Carbon::parse($purchaseOrder->tanggal_akhir)->format('d M Y') }}" readonly />
            </div>
        </div>
    </div>
</div>
