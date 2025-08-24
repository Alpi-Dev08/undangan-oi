 <div class="tab-pane fade" id="penandaanoperasi" role="tabpanel">
     @if ($info->gender->name == 'Pria')
         <img id="penandaan_operasi" src="{{ asset('assets/media/penandaan_operasi_pria.png') }}">
     @else
         <img id="penandaan_operasi" src="{{ asset('assets/media/penandaan_operasi_wanita.png') }}">
     @endif
     <div id="point"></div>
     <form method="post" action="{{ route('suket.operasi', $examination->id) }}" class="form mt-5">
         @csrf
         <input type="hidden" name="coordinate_x" id="coordinate_x">
         <input type="hidden" name="coordinate_y" id="coordinate_y">

         <div class="row g-4 mb-4">
             <div class="col-md-6 mb-3">
                 <div class="d-flex flex-column">
                     <label for="ruangan" class="form-label fw-bold mb-2">Ruangan</label>
                     <input type="text" name="ruangan" id="ruangan" class="form-control form-control-solid"
                         placeholder="Ruangan">
                 </div>
             </div>
             <div class="col-md-6 mb-3">
                 <div class="d-flex flex-column">
                     <label for="operasi" class="form-label fw-bold mb-2">Jenis Operasi</label>
                     <input type="text" name="operasi" id="operasi" class="form-control form-control-solid"
                         placeholder="Jenis Operasi">
                 </div>
             </div>
             <div class="col-md-6 mb-3">
                 <div class="d-flex flex-column">
                     <label for="tanggal" class="form-label fw-bold mb-2">Tanggal</label>
                     <input type="date" name="tanggal" id="tanggal" class="form-control form-control-solid">
                 </div>
             </div>
             <div class="col-md-6 mb-3">
                 <div class="d-flex flex-column">
                     <label for="jam" class="form-label fw-bold mb-2">Waktu</label>
                     <input type="time" name="jam" id="jam" class="form-control form-control-solid">
                 </div>
             </div>
         </div>

         <div class="d-flex justify-content-end">
             <button type="submit" class="btn btn-primary px-6">
                 <i class="fas fa-file-pdf me-2"></i>Download PDF
             </button>
         </div>
     </form>
 </div>

 @section('styles')
     <style>
         #penandaanoperasi {
             position: relative;
         }

         #penandaan_operasi {
             position: relative;
             /* Needed for absolute positioning of the point */
         }

         #point {
             position: absolute;
             width: 15px;
             height: 15px;
             background-color: red;
             border-radius: 50%;
         }
     </style>
 @endsection


 @push('customscript')
     <script>
         $(function() {
             $("#penandaanoperasi").click(function(e) {
                 e.preventDefault();
                 var containerOffset = $(".container").offset();
                 var imageOffset = $("#penandaan_operasi").offset();

                 // Calculate click position relative to container, not image
                 var x = e.clientX - containerOffset.left;
                 var y = e.clientY - containerOffset.top;

                 // Subtract container padding to position point accurately
                 var pointLeft = x - $(".container").css("padding-left").replace("px", "");
                 var pointTop = y - $(".container").css("padding-top").replace("px", "");
                 $("#coordinate_x").val(pointLeft);
                 $("#coordinate_y").val(pointTop);
                 $("#point").css({
                     left: pointLeft + "px",
                     top: pointTop + "px"
                 });
             });
         })
     </script>
 @endpush
