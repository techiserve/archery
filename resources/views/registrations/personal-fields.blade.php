@php
  $personalFields = [
    ['name' => 'name', 'label' => 'First name(s)', 'type' => 'text', 'autocomplete' => 'given-name', 'required' => true],
    ['name' => 'surname', 'label' => 'Surname', 'type' => 'text', 'autocomplete' => 'family-name', 'required' => true],
    ['name' => 'knownAs', 'label' => 'Preferred name', 'type' => 'text', 'autocomplete' => 'nickname', 'required' => true],
    ['name' => 'dob', 'label' => 'Date of birth', 'type' => 'date', 'autocomplete' => 'bday', 'required' => true],
    ['name' => 'nId', 'label' => 'ID / passport number', 'type' => 'text', 'autocomplete' => 'off', 'required' => true],
    ['name' => 'email', 'label' => 'Email address', 'type' => 'email', 'autocomplete' => 'email', 'required' => true],
    ['name' => 'institute', 'label' => 'Institute / school', 'type' => 'text', 'autocomplete' => 'organization', 'required' => true],
  ];
@endphp
<div class="row g-4">
  @foreach($personalFields as $field)
    @php
      $fieldName = $field['name'];
      $value = $fieldName === 'dob' ? ($registration?->dob?->format('Y-m-d') ?? '') : ($registration->{$fieldName} ?? '');
    @endphp
    <div class="col-md-6">
      <label class="form-label" for="{{ $fieldName }}">{{ $field['label'] }}</label>
      <input id="{{ $fieldName }}" name="{{ $fieldName }}" type="{{ $field['type'] }}"
        class="form-control @error($fieldName) is-invalid @enderror"
        value="{{ old($fieldName, $value) }}" autocomplete="{{ $field['autocomplete'] }}"
        data-field-label="{{ $field['label'] }}" aria-describedby="{{ $fieldName }}-error"
        @required($field['required'])
        @if($fieldName === 'email') inputmode="email" autocapitalize="none" spellcheck="false" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" @endif
        @if($fieldName === 'dob') max="{{ now()->toDateString() }}" min="1900-01-02" @else maxlength="{{ $fieldName === 'nId' ? 50 : 255 }}" @endif
        @error($fieldName) aria-invalid="true" @enderror>
      <div id="{{ $fieldName }}-error" class="invalid-feedback" aria-live="polite">@error($fieldName){{ $message }}@enderror</div>
    </div>
  @endforeach
  @foreach(['gender' => ['label' => 'Gender', 'options' => ['Male' => 'Male', 'Female' => 'Female']], 'hand' => ['label' => 'Dominant hand', 'options' => ['Right' => 'Right-handed', 'Left' => 'Left-handed']]] as $fieldName => $field)
    <div class="col-md-6">
      <label class="form-label" for="{{ $fieldName }}">{{ $field['label'] }}</label>
      <select id="{{ $fieldName }}" name="{{ $fieldName }}" required class="form-select @error($fieldName) is-invalid @enderror"
        data-field-label="{{ $field['label'] }}" aria-describedby="{{ $fieldName }}-error"
        @error($fieldName) aria-invalid="true" @enderror>
        <option value="">Select {{ strtolower($field['label']) }}</option>
        @foreach($field['options'] as $value => $label)
          <option value="{{ $value }}" @selected(old($fieldName, $registration->{$fieldName} ?? '') === $value)>{{ $label }}</option>
        @endforeach
      </select>
      <div id="{{ $fieldName }}-error" class="invalid-feedback" aria-live="polite">@error($fieldName){{ $message }}@enderror</div>
    </div>
  @endforeach
</div>
