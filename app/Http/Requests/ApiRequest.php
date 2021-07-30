<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read  array  $game_ids
 * @property-read  string  $service_name
 * @property-read  array  $period
 */
class ApiRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'game_ids' => 'required_without:period|array',
            'game_ids.*' => 'required_with:game_ids|exists:followed_games,game_id|integer|distinct',
            'period' => 'required_without:game_ids|array',
            'period.from' => 'required_with:period|date',
            'period.to' => 'required_with:period|date',
            'service_name' => 'required|in:twitch',
        ];
    }
}
