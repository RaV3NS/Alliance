<?php

namespace App\Http\Requests\API\Transaction;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class Create extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $currencies = array_merge(config('currencies.fiat'), config('currencies.crypto'));

        return [
            'amount' => ['required', 'numeric', 'min:0', 'not_in:0'],
            'pair1' => ['required', Rule::in($currencies)],
            'pair2' => ['required', Rule::in($currencies)],
            'wallet' => ['required']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'amount.required' => 'Поле сумма обязательно для заполнения',
            'amount.numeric' => 'Поле сумма должно быть числовым значением',
            'amount.min' => 'Неверно указана сумма',
            'amount.not_in' => 'Неверно указана сумма',
            'pair1.required' => 'Поле "Отдаете" обязательно для запонения',
            'pair2.required' => 'Поле "Получаете" обязательно для запонения',
            'pair1.in' => 'Неверное указана изначальная валюта',
            'pair2.in' => 'Неверно указана валюта для конвертации',
            'wallet.required' => 'Кошелек\Карта обязательное поле для заполнения'
        ];
    }
}
