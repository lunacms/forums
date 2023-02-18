<?php

namespace Lunacms\Forums\Http\Forums\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForumUpdateRequest extends ForumStoreRequest
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
        return array_merge(parent::rules(), [
            //
        ]);
    }
}
