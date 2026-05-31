<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class BoothDocumentRequest extends FormRequest
{
    public function authorize(): bool { return session()->has('company_id'); }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'document_type' => ['nullable', 'in:Brochure,Certificate,Catalogue,Datasheet,Other'],
            'file' => [$this->isMethod('post') ? 'required' : 'nullable', 'file', 'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,jpg,jpeg,png,webp', 'max:20480'],
            'description' => ['nullable', 'string', 'max:1000'],
            'visibility' => ['required', 'in:public,private'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }
}
