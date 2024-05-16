<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadDocumentRequest extends FormRequest
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
            'name'=>'required|string|max_length: 255',
            'size'=>'required|bigint|max_length: 255',
            'document_path'=>'required|mimes:jpeg,jpg,png,gif,pdf,doc,docx,xls,xlsx|max:2048|mimetypes:application/pdf, application/doc, application/docx, application/txt',
            'user_id'=>'required|unsignedbigint',
            'folder_id'=>'required|unsignedbigint',
     
        ];
    }
}
