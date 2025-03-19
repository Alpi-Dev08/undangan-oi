<div class="tab-pane fade" id="sbar">
    <div class="card shadow-sm mt-4">
        <div class="card-header">
            <h3 class="card-title">SBAR (Situation, Background, Assessment, Recommendation)</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">No.RM</th>
                            <th class="text-center">Nama Pasien</th>
                            <th class="text-center">Tanggal SBAR</th>
                            <th class="text-center">Jam SBAR</th>
                            <th class="text-center">Situation (S)</th>
                            <th class="text-center">Background (B)</th>
                            <th class="text-center">Assessment (A)</th>
                            <th class="text-center">Recommendation (R)</th>
                            <th class="text-center">Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="sbarRow">
                            <td class="text-center">{{ Carbon\Carbon::now()->format('Y-m-d') }}</td>
                            <td class="text-center">{{ $user->mr->medical_record_code }}</td>
                            <td class="text-center">{{ $user->name }}</td>
                            <td class="text-center">{{ Carbon\Carbon::now()->format('Y-m-d') }}</td>
                            <td class="text-center">{{ Carbon\Carbon::now()->format('H:i') }}</td>
                            <td>
                                <textarea id="situation" class="form-control" placeholder="Deskripsi Situation" rows="3" readonly>{{ $sbar->situation ?? '' }}</textarea>
                            </td>
                            <td>
                                <textarea id="background" class="form-control" placeholder="Deskripsi Background" rows="3" readonly>{{ $sbar->background ?? '' }}</textarea>
                            </td>
                            <td>
                                <textarea id="assessment" class="form-control" placeholder="Deskripsi Assessment" rows="3" readonly>{{ $sbar->assessment ?? '' }}</textarea>
                            </td>
                            <td>
                                <textarea id="recommendation" class="form-control" placeholder="Deskripsi Recommendation" rows="3" readonly>{{ $sbar->recommendation ?? '' }}</textarea>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-switch d-flex justify-content-center align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="checklistVerification">
                                    <button class="btn btn-sm btn-primary" id="verifySbar">Verifikasi</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('customscript')
    <script>
        $(function () {
           $("#verifySbar").on('click', function () {
                var isChecked = $("#checklistVerification").is(":checked");
                if (isChecked) {
                    // Disable fields and change the entire row's background to green
                    $("#sbarRow textarea").prop("disabled", true);
                    $("#sbarRow").css("background-color", "lightgreen");

                    // Disable the checkbox
                    $("#checklistVerification").prop("disabled", true);

                    // Change the Checklist Verification cell to "VERIFIKASI"
                    $("#checklistVerification").closest("td").html("<strong>SUDAH DIVERIFIKASI</strong>");

                    // Remove the verification button
                    $("#verifySbar").hide(); // Hide the button

                    alert("SBAR telah diverifikasi dan tidak dapat diubah lagi.");
                } else {
                    alert("Checklist Verification harus dicentang untuk menyimpan data.");
                }
            });
        });
    </script>
@endpush
