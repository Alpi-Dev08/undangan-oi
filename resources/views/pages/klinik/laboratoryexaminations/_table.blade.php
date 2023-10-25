<!--begin::Table-->
{{ $dataTable->table() }}
<!--end::Table-->

{{-- Inject Scripts --}}
@section('scripts')
    {{ $dataTable->scripts() }}
@endsection

@push('customscript')
    <script>
        $("#searchbox").on("keyup search input paste cut", function() {
            LaravelDataTables["laboratoryexaminations-table"].search(this.value).draw();
        });

        $(function(){
            LaravelDataTables["laboratoryexaminations-table"].on('click','.delete',function(event){
                var form =  $(this).closest("form");
                event.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        Swal.fire(
                            'Deleted!',
                            'Laboratory Examination has been deleted.',
                            'success'
                        )
                    }
                })
            });

            LaravelDataTables["laboratoryexaminations-table"].on('click','.print',function(event){
                var form =  $(this);
                event.preventDefault();
                Swal.fire({
                    title: 'Jumlah Label yang akan dicetak',
                    input: 'number',
                    inputAttributes: {
                        autocapitalize: 'off',
                        min: 1
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Print',
                    showLoaderOnConfirm: true,
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = form.attr('href')+"?jumlah="+result.value;
                    }
                })
            })
        })
    </script>
@endpush

@section('styles')
    <style>
        .dataTables_filter {
            display: none;
        }
    </style>
@endsection
