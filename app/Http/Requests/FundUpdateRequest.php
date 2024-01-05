<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $fund_id
 * @property string $name
 * @property int $start_year
 * @property string $fund_manager_id
 * @property array|null $aliases
 */
class FundUpdateRequest extends FormRequest
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
            'fund_id' => 'required|string|exists:App\Models\Fund,id',
            'name' => 'sometimes|string|max:255',
            'start_year' => 'sometimes|int|min:'. Carbon::now()->year,
            'fund_manager_id' => 'sometimes|string|exists:App\Models\FundManager,id',
            'aliases' => 'sometimes|array',
            'aliases.*.alias' => 'sometimes|string|exists:App\Models\Alias,id',
            'aliases.*.alias' => 'required|string|max:255',
        ];
    }
}
