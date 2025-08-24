@if($examination->is_lab)
    @if($laboratoryexamination->hasil)
        <div class="tab-pane" id="lab" role="tabpanel" aria-labelledby="all-tab" data-kt-timeline-widget-4-blockui="true">
            <div class="card card-custom gutter-b shadow-sm mb-5">
                <div class="card-header bg-light">
                    <h3 class="card-title">
                        <i class="fas fa-flask text-primary me-2"></i>
                        Hasil Pemeriksaan Laboratorium
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold"><i class="fas fa-hospital text-info me-2"></i>Nama Pemeriksa</div>
                        <div class="col-md-9">: {{ $laboratoryexamination->laboratory_name }}</div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-3 fw-bold"><i class="fas fa-calendar-alt text-warning me-2"></i>Tanggal Pemeriksaan</div>
                        <div class="col-md-9">: {{ $laboratoryexamination->updated_at->format('d M Y H:i:s') }}</div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr class="bg-primary text-white">
                                    <th class="text-center" width="50">No</th>
                                    <th>Jenis Pemeriksaan</th>
                                    <th class="text-center">Hasil</th>
                                    <th>Nilai Rujukan</th>
                                    <th>Satuan</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no=1; @endphp
                                @foreach(json_decode($laboratoryexamination->hasil) as $row)
                                    @if($row->ItemName != 'Hematologi')
                                        <tr>
                                            <td class="text-center">{{ $no }}</td>
                                            <td><i class="fas fa-vial text-muted me-2"></i>{{ $row->ItemName }}</td>
                                            <td class="text-center">{{ $row->hasil }}</td>
                                            <td>{{ $row->nilai_rujukan }}</td>
                                            <td>{{ $row->satuan ?? '-' }}</td>
                                            <td>{{ $row->keterangan ?? '-' }}</td>
                                        </tr>
                                        @php $no++; @endphp
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
