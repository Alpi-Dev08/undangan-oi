<!--begin::Table-->
{{ $dataTable->table() }}
<!--end::Table-->

{{-- Inject Scripts --}}
@section('scripts')
    <script src = {{ env('APP_URL')."/backend/plugins/custom/datatables/datatables.bundle.js" }}></script>
    {{ $dataTable->scripts() }}
@endsection

@push('customscript')
    <script>
        $("#searchbox").on("keyup search input paste cut", function() {
            LaravelDataTables["users-table"].search(this.value).draw();
        });

        $(function(){
            LaravelDataTables["users-table"].on('click','.delete',function(event){
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
                            'User has been deleted.',
                            'success'
                        )
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
