<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RouteScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'route_destination_id' => ['required', 'integer'],
            'label' => ['required', 'string'],
            'departure_time' => ['required', 'date_format:H:i']
        ];
    }
}
