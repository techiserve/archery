@props(['eventScore'])

@php
  $status = $eventScore->certificate_email_status;
  $recipient = $eventScore->certificate_email_address;
  $sentAt = $eventScore->certificate_email_sent_at;
@endphp

@if($status === 'sent')
  <span
    class="badge bg-label-success ms-1"
    title="Accepted by the mail server{{ $recipient ? ' for ' . $recipient : '' }}{{ $sentAt ? ' on ' . $sentAt->format('d M Y H:i') : '' }}">
    <span class="fa fa-check-circle"></span>
    Email sent
  </span>
@elseif($status === 'failed')
  <span class="badge bg-label-danger ms-1" title="{{ $eventScore->certificate_email_error }}">
    <span class="fa fa-exclamation-circle"></span>
    Failed to send
  </span>
@elseif($status === 'queued')
  <span class="badge bg-label-info ms-1" title="Queued for sending">
    <span class="fa fa-clock"></span>
    Not Sent (Queued)
  </span>
@elseif($status === 'processing')
  <span class="badge bg-label-info ms-1" title="Sending certificate email">
    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
    Not Sent (Sending)
  </span>
@else
  <span class="badge bg-label-secondary ms-1">
    <span class="fa fa-envelope-open"></span>
    Not Sent
  </span>
@endif
