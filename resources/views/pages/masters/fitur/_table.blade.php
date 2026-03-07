<!--begin::Table-->
{{ $dataTable->table() }}
<!--end::Table-->

@section('scripts')
    {{ $dataTable->scripts() }}
@endsection

@push('customscript')
<script>
    // Search custom
    $("#searchbox").on("keyup search input paste cut", function () {
        LaravelDataTables["fitur-table"]
            .search(this.value)
            .draw();
    });

    // SweetAlert delete confirmation
    $(document).on('click', '.delete', function (event) {
        event.preventDefault();

        let form = $(this).closest("form");

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data kategori akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
@endpush

@section('styles')
<style>
    .dataTables_filter {
        display: none;
    }
</style>
@endsection
