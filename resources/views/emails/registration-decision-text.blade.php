{{-- This view is the text/plain email alternative, so retain literal text rather than HTML entities. --}}
Qurtuba Furusiyyah

Registration {!! $registrationStatus !!}

Good day {!! $archerName !!},

@if($registrationStatus === 'approved')
Your archer registration has been approved. You have been added to the Qurtuba Furusiyyah archers list.
@if($archerNumber)

Archer number: {!! $archerNumber !!}
@endif
@else
Your archer registration has been rejected.

Reason:
{!! $rejectionReason !!}
@endif

Registration reference: {!! $reference !!}

Kind regards,
Qurtuba Furusiyyah
