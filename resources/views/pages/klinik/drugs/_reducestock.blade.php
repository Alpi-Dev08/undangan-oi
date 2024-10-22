<form id="kt_modal_add_drugs_form" method="POST" class="form" action="{{ route('drugs.update1', ['drug' => $drug->id]) }}">
    @csrf
    @method('PUT')
    
    <!--begin::Scroll-->
    <div class="d-flex flex-column flex-row-fluid">
        <div class="row mb-7">
            <!-- Tanggal Obat Digunakan -->
            <div class="col-md-6">
                <div class="fv-row">
                    <label class="required fw-bold fs-6 mb-2">Tanggal Obat Digunakan</label>
                    <div class="input-group input-group-solid has-validation mb-3">
                        <input type="date" name="date" 
                               class="form-control form-control-solid form-control-lg fw-bold" 
                               value="{{ old('date') }}" 
                               aria-label="{{ __('Select a Date') }}">
                    </div>
                    @error('date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Nama Pengguna Obat -->
            <div class="col-md-6">
                <div class="fv-row">
                    <label class="required fw-bold fs-6 mb-2">Nama Pengguna Obat</label>
                    <div class="input-group input-group-solid has-validation mb-3">
                        <input type="text" name="user_name" 
                               class="form-control form-control-solid border border-gray-300 @error('user_name') is-invalid @enderror" 
                               placeholder="Nama Pengguna Obat" 
                               value="{{ old('user_name') }}"/>
                    </div>
                    @error('user_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row mb-7">
            <!-- Jumlah Pengurangan Stok -->
            <div class="col-md-6">
                <div class="fv-row">
                    <label class="required fw-bold fs-6 mb-2">Jumlah Pengurangan Stok</label>
                    <div class="input-group input-group-solid has-validation mb-3">
                        <input type="number" name="quantity" 
                               class="form-control form-control-solid border border-gray-300 @error('quantity') is-invalid @enderror" 
                               placeholder="Pengurangan Stok" 
                               value="{{ old('quantity', 0) }}"/>
                    </div>
                    @error('quantity')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Keterangan -->
            <div class="col-md-6">
                <div class="fv-row">
                    <label class="required fw-bold fs-6 mb-2">Keterangan</label>
                    <div class="input-group input-group-solid has-validation mb-3">
                        <input type="text" name="description" class="form-control form-control-solid border border-gray-300 @error('description') is-invalid @enderror" placeholder="Keterangan" value="{{ old('description') }}"/>
                    </div>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <!--end::Scroll-->

    <!--begin::Actions-->
    <div class="text-center pt-15">
        <button type="reset" class="btn btn-light me-3" data-kt-drugs-modal-action="cancel">Discard</button>
        <button type="submit" class="btn btn-primary" formaction="{{ route('drugs.reduceDetail', ['drug' => $drug->id]) }}">
            <span class="indicator-label">Save</span>
            <span class="indicator-progress">Please wait...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>        
    </div>
    <!--end::Actions-->

<!--begin::Tabel History-->
<div class="table-responsive mt-5">
    <h3 class="mb-4">History Pengurangan Obat</h3>
    @if($histories1 && count($histories1) > 0)
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tanggal Obat Digunakan</th>
                <th>Nama Pengguna Obat</th>
                <th>Jumlah Pengurangan Stok</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach(array_reverse($histories1) as $history)
            <tr>
                <td>{{ $history['date'] }}</td>
                <td>{{ $history['user_name'] }}</td>
                <td>{{ $history['quantity'] }}</td>
                <td>{{ $history['description'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <tr>
        <td colspan="4" class="text-center">Tidak ada data history pengurangan obat</td>
    </tr>
    @endif
</div>
<!--end::Tabel History-->

</form>
