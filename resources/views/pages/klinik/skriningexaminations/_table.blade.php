<!--begin::Table-->
{{ $dataTable->table() }}
<!--end::Table-->

{{-- Inject Scripts --}}
@section('scripts')
    {{ $dataTable->scripts() }}
@endsection

@push('customscript')
<script>
$(document).ready(function() {
    // DataTable instance
    var table = LaravelDataTables["skriningexaminations-table"];

    // Set default tanggal hari ini
    var today = new Date().toISOString().split('T')[0];
    $('#tanggalExamination').val(today);

    // Tombol filter
    $('#filterExamination').on('click', function() {
        let location = $('#locationSelect').val();
        let date = $('#tanggalExamination').val();
        if (!location || !date) {
            toastr.error('Pilih lokasi dan tanggal terlebih dahulu.');
            return;
        }
        table.ajax.url(table.ajax.url().split('?')[0] + '?location=' + encodeURIComponent(location) + '&date=' + encodeURIComponent(date)).load();
    });

    // Reset form
    $('#resetForm').on('click', function() {
        $('#locationSelect').val('');
        $('#tanggalExamination').val(today);
        table.ajax.url(table.ajax.url().split('?')[0]).load();
    });

    // Tombol export
    $('#exportBtn').on('click', function(e) {
        e.preventDefault();
        let location = $('#locationSelect').val() || '';
        let date = $('#tanggalExamination').val() || '';
        let url = '{{ route("skriningexaminations.export") }}';
        url += '?location=' + encodeURIComponent(location) + '&date=' + encodeURIComponent(date);
        window.location.href = url;
    });

    // Search box manual
    $('#searchbox').on('keyup search input paste cut', function() {
        table.search(this.value).draw();
    });

    // Hapus row
    table.on('click', '.delete', function(event) {
        var form = $(this).closest("form");
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
                Swal.fire('Deleted!', 'Skrining Examination has been deleted.', 'success')
            }
        });
    });
});
</script>
@endpush

@section('styles')
<style>
.dataTables_filter {
    display: none; /* sembunyikan filter bawaan DataTables */
}
</style>
@endsection
