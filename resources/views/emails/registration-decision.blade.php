<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration {{ $registrationStatus }}</title>
</head>
<body style="margin:0; padding:24px 16px; background:#ffffff; color:#26333e; font-family:Arial,Helvetica,sans-serif; font-size:16px; line-height:1.6;">
  <div style="max-width:600px; margin:0 auto; overflow-wrap:anywhere;">
    <p style="margin:0 0 24px; font-size:18px; font-weight:bold;">Qurtuba Furusiyyah</p>
    <h1 style="margin:0 0 20px; font-size:24px; line-height:1.3;">Registration {{ $registrationStatus }}</h1>
    <p>Good day {{ $archerName }},</p>
    @if($registrationStatus === 'approved')
      <p>Your archer registration has been approved. You have been added to the Qurtuba Furusiyyah archers list.</p>
      @if($archerNumber)<p><strong>Archer number:</strong> {{ $archerNumber }}</p>@endif
    @else
      <p>Your archer registration has been rejected.</p>
      <p><strong>Reason:</strong><br>{!! nl2br(e($rejectionReason)) !!}</p>
    @endif
    <p><strong>Registration reference:</strong> {{ $reference }}</p>
    <p style="margin-top:24px;">Kind regards,<br>Qurtuba Furusiyyah</p>
  </div>
</body>
</html>
