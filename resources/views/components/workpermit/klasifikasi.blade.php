<div class="col-lg-12">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0 text-center">Klasifikasi Pekerjaan, APD & Perlengkapan Darurat</h5>
        </div>
        <div class="card-body">
            <!-- Klasifikasi Pekerjaan -->
            <div class="mb-4">
                <div class="d-flex flex-wrap gap-2">
                    <h6 class="text-primary fw-bold">Klasifikasi Pekerjaan:</h6>
                    @foreach ($selectedClassifications as $classification)
                        <div class="d-flex align-items-center gap-2">
                            <input class="form-check-input" type="checkbox" checked disabled>
                            <span class="badge bg-primary px-3 py-2 shadow-sm">
                                <i class="me-1"></i> {{ $classification }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row">
                <!-- APD -->
                <div class="col-md-6">
                    <div class="card border-light shadow-sm">
                        <div class="card-header bg-light border-bottom">
                            <h6 class="mb-0 text-center fw-bold text-primary">
                                <i class="me-1"></i> Alat Pelindung Diri (APD) yang harus disediakan
                            </h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @foreach ($uniqueApd as $equipment)
                                    <li class="list-group-item d-flex align-items-center">
                                        <input class="form-check-input me-2" type="checkbox" checked disabled>
                                        <span class="fw-semibold">{{ $equipment->name }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Perlengkapan Darurat -->
                <div class="col-md-6">
                    <div class="card border-light shadow-sm">
                        <div class="card-header bg-light border-bottom">
                            <h6 class="mb-0 text-center fw-bold text-danger">
                                <i class="me-1"></i> Perlengkapan Darurat yang harus disediakan
                            </h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @foreach ($uniqueEmergencyEquipments as $equipment)
                                    <li class="list-group-item d-flex align-items-center">
                                        <input class="form-check-input me-2" type="checkbox" checked disabled>
                                        <span class="fw-semibold">{{ $equipment->name }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End row -->
        </div>
    </div>
</div>
