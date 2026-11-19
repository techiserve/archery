<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArcherRegistration extends Model
{
    public const PERSONAL_FIELDS = ['name', 'surname', 'knownAs', 'dob', 'nId', 'gender', 'hand', 'email', 'institute'];

    public const GRADING_FIELDS = ['ageCategory', 'agegroupProficiency', 'currentGradingDominant', 'currentGradingWeak', 'currentProficiency', 'clubMember'];

    public const GRADE_GROUPS = [
        'Cub' => ['CNG', 'CS1', 'CS2', 'CS3', 'CA1', 'CA2', 'CA3', 'CM1', 'CM2', 'CM3'],
        'Junior' => ['JNG', 'JS1', 'JS2', 'JS3', 'JA1', 'JA2', 'JA3', 'JM1', 'JM2', 'JM3'],
        'Adult' => ['ANG', 'AS1', 'AS2', 'AS3', 'AA1', 'AA2', 'AA3', 'AM1', 'AM2', 'AM3'],
    ];

    protected $fillable = [...self::PERSONAL_FIELDS, ...self::GRADING_FIELDS, 'review_notes'];

    protected $casts = ['dob' => 'date', 'clubMember' => 'boolean', 'reviewed_at' => 'datetime'];

    protected static function booted(): void
    {
        static::saving(function (self $registration) {
            // A rejected applicant may reapply; pending and approved identities stay reserved.
            $registration->active_identity = $registration->status === 'rejected'
                ? null
                : hash('sha256', strtoupper(preg_replace('/\s+/u', '', $registration->nId)));
        });
    }

    public function archer(): BelongsTo
    {
        return $this->belongsTo(Archer::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function suggestedAgeGroups(): array
    {
        $age = $this->dob->age;
        $yearOfLiving = now()->year - $this->dob->year + 1;
        $group = fn ($years) => $years < 5 ? 'Too Young' : ($years <= 12 ? 'Cub' : ($years <= 16 ? 'Junior' : 'Adult'));

        return ['ageCategory' => $group($age), 'agegroupProficiency' => $group($yearOfLiving)];
    }
}
