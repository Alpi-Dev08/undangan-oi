<div class="tab-pane fade" id="hakkewajiban" role="tabpanel">
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-light-success">
            <h3 class="d-flex align-items-center">Bukti Penyampaian Hak dan Kewajiban</h3>
        </div>
        <div class="card-body p-4">
            <form method="post" action="{{ route('suket.hakkewajiban', $examination->id) }}" class="form">
                @csrf
                <div class="row mb-4">
                    <div class="col-12">
                        <div id="signature_bukti_penyampaian" class="row text-center mb-4" style="display: none">
                            {!! $qr !!}
                            <em class="text-center">Scan untuk melakukan Tanda Tangan</em>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button id="button_bukti_penyampaian" type="submit" class="btn btn-primary px-6" style="display:none">
                        <i class="fas fa-file-pdf me-2"></i>Download PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
