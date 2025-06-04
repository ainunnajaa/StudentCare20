<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
   public function rules(): array
{
    $userId = $this->user()->id;

    return [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $userId,
        'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
        'nim' => 'nullable|string|max:255',
        'jurusan' => 'nullable|string|max:255',
        'nip' => 'nullable|string|max:255',
        'tanggal_lahir' => 'nullable|date',
        'whatsapp' => 'nullable|string|max:20',
        'profile_photo' => ['nullable', 'image', 'max:2048'],

    ];
}

}
