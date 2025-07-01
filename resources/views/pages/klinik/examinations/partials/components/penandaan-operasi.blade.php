 <div class="tab-pane fade" id="penandaanoperasi" role="tabpanel">
     @if ($info->gender->name == 'Pria')
         <img id="penandaan_operasi" src="{{ asset('assets/media/penandaan_operasi_pria.png') }}">
     @else
         <img id="penandaan_operasi" src="{{ asset('assets/media/penandaan_operasi_wanita.png') }}">
     @endif
     <div id="point"></div>
     <form method="post" action="{{ route('suket.operasi', $examination->id) }}">
         @csrf
         <input type="hidden" name="coordinate_x" id="coordinate_x">
         <input type="hidden" name="coordinate_y" id="coordinate_y">

         <table class="table" style="width:100%">
             <tbody>
                 <tr>
                     <td>Ruangan</td>
                     <td class="d-flex">:&nbsp;<input type="text" name="ruangan"
                             class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                             placeholder="Ruangan">
                     </td>
                 </tr>
                 <tr>
                     <td>Jenis Operasi</td>
                     <td class="d-flex">:&nbsp;<input type="text" name="operasi"
                             class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                             placeholder="Jenis Operasi">
                     </td>
                 </tr>
                 <tr>
                     <td>Tanggal</td>
                     <td class="d-flex">:&nbsp;<input type="date" name="tanggal"
                             class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                             placeholder="Tanggal">
                     </td>
                 </tr>
                 <tr>
                     <td>Waktu</td>
                     <td class="d-flex">:&nbsp;<input type="time" name="jam"
                             class="form-control form-control-solid border border-gray-300 mb-3 mb-lg-0"
                             placeholder="Waktu">
                     </td>
                 </tr>

             </tbody>
         </table>
         <button type="submit" class="btn btn-bg-dark text-white">Download PDF</button>
     </form>
 </div>

 @section('styles')
     <style>
         .timeline-label .timeline-label {
             width: 200px !important
         }

         .timeline-label:before {
             left: 201px !important;
         }

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
                 var imageOffset = $("#image").offset();

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
