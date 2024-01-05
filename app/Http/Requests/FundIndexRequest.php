<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $name
 * @property int $start_year
 * @property string $fund_manager_id
 * @property int|null $page
 * @property int|null $per_page
 */
class FundIndexRequest extends FormRequest
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
            'name' => 'sometimes|string|max:255',
            'start_year' => 'sometimes|int|min:'. Carbon::now()->year,
            'fund_manager_id' => 'sometimes|string|exists:App\Models\FundManager,id',
            'page' => 'sometimes|int|min:1',
            'per_page' => 'sometimes|int|min:1',
        ];
    }
}
