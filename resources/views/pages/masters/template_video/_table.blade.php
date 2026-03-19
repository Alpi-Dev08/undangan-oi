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
        LaravelDataTables["template_video-table"]
            .search(this.value)
            .draw();
    });

    // SweetAlert delete
    $(document).on('click', '.delete', function (event) {
        event.preventDefault();

        let form = $(this).closest("form");

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data template akan dihapus!",
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

    // TOGGLE STATUS (BARU)
    $(document).on('click', '.toggle-status', function () {

        let button = $(this);
        let id = button.data('id');

        Swal.fire({
            title: 'Ubah Status?',
            text: "Status template akan diubah",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if (!result.isConfirmed) return;

            $.ajax({
                url: '{{ route("template_video.toggle_status", ":id") }}'.replace(':id', id),
                type: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    button.prop('disabled', true).text('...');
                },
                success: function (res) {

                    if (res.status === 'aktif') {
                        button.removeClass('btn-light-danger').addClass('btn-light-success');
                        button.text('Aktif');
                    } else {
                        button.removeClass('btn-light-success').addClass('btn-light-danger');
                        button.text('Nonaktif');
                    }

                    button.prop('disabled', false);

                    // Optional refresh datatable
                    LaravelDataTables["template_video-table"].ajax.reload(null, false);

                    // Notif
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Status berhasil diubah',
                        timer: 1500,
                        showConfirmButton: false
                    });
                },
                error: function () {
                    button.prop('disabled', false);

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan'
                    });
                }
            });

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
