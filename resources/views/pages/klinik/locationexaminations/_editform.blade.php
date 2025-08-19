<x-base-layout>
    <div class="card card-xxl-stretch mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title fw-bolder fs-3 mb-1">Edit Location Examination</h3>
            <div class="card-toolbar">
                <a href="{{ route('locationexaminations.index') }}" class="btn btn-sm btn-light-primary">Cancel</a>
            </div>
        </div>

        <form method="POST" action="{{ route('locationexaminations.update', $location->id) }}" class="card-body pt-6">
            @csrf
            @method('PUT')
 
            <div class="fv-row mb-7">
                <label for="name" class="required fw-bold fs-6 mb-2">Location</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $location->name) }}"
                    class="form-control form-control-solid border border-gray-300 @error('name') is-invalid @enderror"
                    placeholder="Location Examination"
                    required
                />
                @error('name')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-center pt-15">
                <button type="reset" class="btn btn-light me-3">Discard</button>
                <button type="submit" class="btn btn-primary">
                    <span class="indicator-label">Submit</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </form>
    </div>
</x-base-layout>
