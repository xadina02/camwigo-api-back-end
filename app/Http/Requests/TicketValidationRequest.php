<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketValidationRequest extends FormRequest
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
            'route_schedule_id' => ['required', 'integer'],
            'vehicle_id' => ['required', 'integer'],
            'ticket_data' => ['required', 'string'],
            'date' => ['required', 'date_format:Y-m-d'],
        ];
    }
}
