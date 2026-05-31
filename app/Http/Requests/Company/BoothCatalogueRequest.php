<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class BoothCatalogueRequest extends FormRequest
{
    public function authorize(): bool { return session()->has('company_id'); }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'cover_image' => ['nullable', 'image', 'max:8192'],
            'file' => [$this->isMethod('post') ? 'required' : 'nullable', 'file', 'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx', 'max:20480'],
            'category' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'pages' => ['nullable', 'integer', 'min:1'],
            'visibility' => ['required', 'in:public,private'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }
}
