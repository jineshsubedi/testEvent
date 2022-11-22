<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
        $rules = [
            'title' => ['required','string','max:100'],
            'description' => ['required','string','max:2000'],
            'start_date' => ['required', 'date', 'date_format:Y-m-d'],
            'end_date' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:start_date'],
            'banner' => ['sometimes', 'nullable', 'file', 'mimes:jpg,png,jpeg,gif,webp', 'max:2048']
        ];

        if($this->getMethod() =='POST') {
            $rules += [
                'slug' => ['required','alpha_dash','unique:events'],
            ];
        }

        if($this->getMethod() == 'PUT') {
            $rules += [
                'slug' => ['required','alpha_dash', Rule::unique('events')->ignore($this->event->id)],
            ];
        }
        return $rules;
    }
}
