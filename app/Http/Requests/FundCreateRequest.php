<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property int $start_year
 * @property string $fund_manager_id
 * @property array|null $aliases
 */
class FundCreateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'start_year' => 'required|integer|min:'. Carbon::now()->year,
            'fund_manager_id' => 'required|string|exists:App\Models\FundManager,id',
            'aliases' => 'sometimes|array',
            'aliases.*.alias' => 'required|string|max:255',
        ];
    }
}
