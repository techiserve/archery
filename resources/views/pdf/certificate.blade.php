<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .logo { height: 80px; }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table th, .details-table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logo">
        <h2>Archer Event Certificate</h2>
    </div>

    <table class="details-table">
        <tr>
            <th>Name</th>
            <td>{{ $archer->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Event</th>
            <td>{{ $archer->event ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Score</th>
            <td>{{ $archer->score ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Position</th>
            <td>{{ $archer->position ?? 'N/A' }}</td>
        </tr>
    </table>
</body>
</html>
