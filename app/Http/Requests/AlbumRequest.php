<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlbumRequest extends FormRequest
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
        $id = $this->route()->album;

        $ret = [
            'album_name' => ['required'],
            'description' => 'required',
            // 'album_thumb' => 'bail|required|image',
            // 'user_id' => '',
        ];

        if($id){
            $ret['album_name'][] = Rule::unique('albums')->ignore($id);
        }
        else{
            $ret['album_thumb'] = 'required|image';
            $ret['album_name'][] = Rule::unique('albums');
        }

        return $ret;
    }

    public function messages()
    {
        $messages = [

            'album_name.required' => 'Il campo Nome Album è obbligatorio',
            'album_name.unique' => 'Il campo Nome Album esiste già',
            'description.required' => 'Il campo Descrizione è obbligatorio',
            // 'name.required' => 'Il campo Nome è obbligatorio',
            'album_thumb.required' => 'Il campo Thumbnail è obbligatorio'
        ];
        return $messages;

    }
}
