'use strict';

(function () {
  const form = document.getElementById('archer-registration-form');
  if (!form) return;

  const fields = Array.from(form.querySelectorAll('input:not([type="hidden"]), select'));
  const summary = document.getElementById('registration-validation-summary');

  function trimValue(field) {
    if (field.tagName === 'INPUT' && ['text', 'email'].includes(field.type)) {
      field.value = field.value.trim();
    }
  }

  function validate(field) {
    field.setCustomValidity('');
    const label = field.dataset.fieldLabel.toLowerCase();

    if (field.required && field.value.trim() === '') {
      field.setCustomValidity(`Please ${field.tagName === 'SELECT' ? 'select' : 'enter'} your ${label}.`);
    } else if (field.type === 'email' && (field.validity.typeMismatch || field.validity.patternMismatch)) {
      field.setCustomValidity('Please enter a valid email address, for example name@example.com.');
    }

    const valid = field.validity.valid;
    field.classList.toggle('is-invalid', !valid);
    field.setAttribute('aria-invalid', String(!valid));
    document.getElementById(`${field.id}-error`).textContent = valid ? '' : field.validationMessage;

    return valid;
  }

  fields.forEach(field => {
    field.addEventListener('blur', () => {
      trimValue(field);
      validate(field);
    });
    field.addEventListener(field.tagName === 'SELECT' ? 'change' : 'input', () => {
      if (field.classList.contains('is-invalid')) validate(field);
    });
  });

  form.addEventListener('submit', event => {
    let firstInvalid = null;
    fields.forEach(field => {
      trimValue(field);
      if (!validate(field) && !firstInvalid) firstInvalid = field;
    });

    if (firstInvalid) {
      event.preventDefault();
      summary.textContent = 'Please complete all fields and enter a valid email address.';
      summary.hidden = false;
      firstInvalid.focus();
    } else {
      summary.hidden = true;
    }
  });

  // Keep native required/email validation as the fallback when JavaScript is unavailable.
  form.noValidate = true;
})();
