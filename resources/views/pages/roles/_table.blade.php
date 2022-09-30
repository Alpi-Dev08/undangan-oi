<!--begin::Table-->
{{ $dataTable->table() }}
<!--end::Table-->

{{-- Inject Scripts --}}
@section('scripts')
    <script src = "http://127.0.0.1:8000/be/plugins/custom/datatables/datatables.bundle.js"></script>
    {{ $dataTable->scripts() }}
@endsection

@push('customscript')
    <script>
        $("#searchbox").on("keyup search input paste cut", function() {
            LaravelDataTables["roles-table"].search(this.value).draw();
        });

        $(function(){
            LaravelDataTables["roles-table"].on('click','.delete',function(event){
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
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            })
        })
    </script>
@endpush


@section('styles')
    <link rel="preload" href="http://127.0.0.1:8000/be/plugins/custom/datatables/datatables.bundle.css" as="style" onload="this.onload=null;this.rel='stylesheet'" type="text/css">
    <noscript><link rel="stylesheet" href="http://127.0.0.1:8000/be/plugins/custom/datatables/datatables.bundle.css"></noscript>
    <style>
        .dataTables_filter {
            display: none;
        }
    </style>
@endsection
