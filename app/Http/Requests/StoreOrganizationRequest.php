<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'           => 'required|string|max:255',
            'email'          => 'nullable|string|email|max:255|unique:organizations,email,' . $this->organization->id,
            'phone'          => 'nullable|string|max:255',
            'fax'            => 'nullable|string|max:255',
            'address'        => 'nullable|string|max:255',
            'country_id'     => 'nullable|integer',
            'province_id'    => 'nullable|integer',
            'city_id'        => 'nullable|integer',
            'district_id'    => 'nullable|integer',
            'subdistrict_id' => 'nullable|integer',
            'postal_code'    => 'nullable|string|max:255',
            'logo'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];
    }
}
