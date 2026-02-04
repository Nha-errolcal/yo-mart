<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $permissionId = $this->route('id') ?? $this->route('permission');

        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:permissions,code,' . $permissionId,
        ];
    }
}
