<?php

namespace App\Http\Requests;

use App\Models\ArcherRegistration;
use Illuminate\Validation\Rule;

class ReviewArcherRegistrationRequest extends StoreArcherRegistrationRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manage-archer-registrations') ?? false;
    }

    public function rules(): array
    {
        $rules = $this->personalRules($this->route('registration'));
        $rules['decision'] = ['required', Rule::in(['save', 'approve', 'reject'])];

        if ($this->input('decision') === 'reject') {
            $rules['nId'] = ['required', 'string', 'max:50'];
        }

        foreach (['ageCategory', 'agegroupProficiency'] as $field) {
            $rules[$field] = [Rule::requiredIf($this->input('decision') === 'approve'), 'nullable', Rule::in(['Cub', 'Junior', 'Adult', 'Too Young'])];
        }

        foreach (['currentGradingDominant', 'currentGradingWeak', 'currentProficiency'] as $field) {
            $rules[$field] = [Rule::requiredIf($this->input('decision') === 'approve'), 'nullable', Rule::in(array_merge(...array_values(ArcherRegistration::GRADE_GROUPS)))];
        }

        return $rules + [
            'clubMember' => ['sometimes', 'boolean'],
            'review_notes' => ['nullable', 'string', 'max:5000'],
            'rejection_reason' => ['required_if:decision,reject', 'nullable', 'string', 'max:2000'],
        ];
    }

    public function attributes(): array
    {
        return parent::attributes() + [
            'ageCategory' => 'age group',
            'agegroupProficiency' => 'age group proficiency',
            'currentGradingDominant' => 'dominant-hand grading',
            'currentGradingWeak' => 'non-dominant-hand grading',
            'currentProficiency' => 'proficiency',
        ];
    }
}
