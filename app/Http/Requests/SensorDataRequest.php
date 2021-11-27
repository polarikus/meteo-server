<?php

namespace App\Http\Requests;

use App\Rules\SerialNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SensorDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!$this->hasHeader('X-serial-number')){
            return false;
        }
        return $this->user()->tokenCan('device:auth');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'temperature' => [Rule::requiredIf(function (){
                return !$this->exists('errors');
            }), 'int'],
            'humidity' => [Rule::requiredIf(function (){
                return !$this->exists('errors');
            }), 'int'],
            'serial_number' => ['required','string', new SerialNumber($this->user())]
        ];
    }
}
