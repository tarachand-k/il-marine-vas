<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        $rules = [
            "created_by_id" => ["nullable", "exists:users,id"],
            "customer_id" => ["nullable", "exists:customers,id"],
            'name' => ['required', 'string', 'max:254'],
            'email' => [
                'required', 'email', 'max:254',
                Rule::unique("users")
            ],
            'mobile_no' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', "confirmed"],
            'role' => ['required', Rule::enum(UserRole::class)],
            'about' => ['nullable', 'string'],
            'status' => ['required', Rule::enum(UserStatus::class)],
            'photo' => $this->validateFile("photo")
        ];

        if ($this->routeIs("users.update")) {
            $userId = $this->route("user");

            $rules["name"][0] = "sometimes";
            $rules["email"][0] = "sometimes";
            $rules["email"][3] = Rule::unique("users")->ignore($userId);
            $rules["password"][0] = "nullable";
            $rules["role"][0] = "sometimes";
            $rules["status"][0] = "sometimes";
        }

        return $rules;
    }

    private function validateFile(string $field): array {
        return $this->hasFile($field)
            ? ['file', 'mimes:jpg,jpeg,png,pdf', 'max:2048']
            : ['nullable', 'string', 'max:100'];
    }

    /**
     * Override the validated method to exclude the password on update requests.
     * @param  null  $key
     * @param  null  $default
     */
    public function validated($key = null, $default = null) {
        $validatedData = parent::validated();

        // If it's an update request, exclude the password field if it's present
        if ($this->routeIs("users.update")) {
            unset($validatedData['password']);
        }

        return $validatedData;
    }
}
