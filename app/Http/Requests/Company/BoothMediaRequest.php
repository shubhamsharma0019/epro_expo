<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class BoothMediaRequest extends FormRequest
{
    public function authorize(): bool { return session()->has('company_id'); }

    public function rules(): array
    {
        return [
            'title' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'in:image,video,document,360'],
            'file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,mp4,mov,pdf', 'max:40960'],
            'files' => ['nullable', 'array'],
            'files.*' => ['file', 'mimes:jpg,jpeg,png,webp,mp4,mov,pdf', 'max:40960'],
            'video_url' => ['nullable', 'url', 'max:255'],
            'thumbnail' => ['nullable', 'image', 'max:8192'],
            'description' => ['nullable', 'string', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->isMethod('post') && ! $this->filled('video_url') && ! $this->hasFile('file') && ! $this->hasFile('files')) {
                $validator->errors()->add('file', 'Please upload at least one media file or provide a video URL.');
            }

            if (! $this->hasFile('file') && ! $this->hasFile('files') && $this->filled('video_url') && ! $this->filled('title')) {
                $validator->errors()->add('title', 'Please enter a title for this media item.');
            }
        });
    }
}
