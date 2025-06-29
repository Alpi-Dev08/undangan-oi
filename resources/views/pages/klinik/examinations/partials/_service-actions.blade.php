{{-- Service Form Actions --}}
<div class="text-center pt-15">
    <input type="hidden" name="examination_id" value="{{ $examination->id }}">
    
    {{-- Create Payment Button --}}
    <button type="submit" 
            class="btn btn-primary me-3" 
            name="payment" 
            value="1" 
            data-kt-examinations-modal-action="submit"
            x-bind:disabled="isSubmitting">
        <span class="indicator-label" x-show="!isSubmitting">
            {{ __('Create Payment') }}
        </span>
        <span class="indicator-progress" x-show="isSubmitting">
            {{ __('Please wait...') }}
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
        </span>
    </button>
    
    {{-- Continue Button --}}
    <button type="submit" 
            class="btn btn-info" 
            name="continue" 
            value="1" 
            data-kt-examinations-modal-action="submit"
            x-bind:disabled="isSubmitting">
        <span class="indicator-label" x-show="!isSubmitting">
            {{ __('Continue') }}
        </span>
        <span class="indicator-progress" x-show="isSubmitting">
            {{ __('Please wait...') }}
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
        </span>
    </button>
</div>