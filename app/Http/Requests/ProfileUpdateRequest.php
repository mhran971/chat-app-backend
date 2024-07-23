<?php

namespace App\Requests;

use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends BaseRequestFormApi
{
    // Determine the rules for the update profile process:
    public function rules(): array
    {
        $rules = [];

        // Get the authenticated user id
        $userId = auth('sanctum')->user()->id;

        // Check if the 'mobile_number' field is present in the request
        //if (array_key_exists('mobile_number', $this->request()->all())) {
        if ($this->has('mobile_number')) {
            //$rules['mobile_number'] = 'numeric|unique:users,mobile_number,' . $userId;
            $rules['mobile_number'] = [
                //'required',
                'numeric',
                //'digits_between:1,15',
                Rule::unique('users', 'mobile_number')
                    ->ignore($userId),
            ];
        }

        if ($this->has('image')) {
            $rules['image'] = [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
            
            ];
        }
        // Check if the 'address' field is present in the request
        //if (array_key_exists('address', $this->request()->all())) {
        // if ($this->has('country_id')) {
        //     $rules['country_id'] = [
        //         'required',
        //     ];
        // }

        // Check if the 'image' field is present in the request
        //if (array_key_exists('image', $this->request()->all())) {


        return $rules;
    }
}
