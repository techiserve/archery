<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Score Card History PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        .logo {
            text-align: center;
            margin-bottom: 10px;
        }
        .logo img {
            width: 120px;
        }
        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 10px;
        }
        .info {
            margin-bottom: 15px;
        }
        .info label {
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #222;
            padding: 4px;
            text-align: center;
        }
    </style>
</head>
<body>
<!-- <div class="header-title">Score Card History</div> -->
    <div class="logo">
        <img src="{{ public_path('assets/img/avatars/achery1.jpg') }}" alt="Logo">
    </div>

  
    <div class="info" style="display: flex; flex-wrap: wrap; gap: 10px;">
    <div style="flex: 0 0 48%;">
        <p><label>Name:</label> {{ $grading->name }}</p>
    </div>
    <div style="flex: 0 0 48%;">
        <p><label>Date:</label> {{ $grading->date }}</p>
    </div>
    
    <div style="flex: 0 0 48%;">
        <p><label>Bow Used:</label> {{ $grading->bowUsed }}</p>
    </div>
    <div style="flex: 0 0 48%;">
        <p><label>Current Grading:</label> {{ $grading->currentGrading }}</p>
    </div>
    
    <div style="flex: 0 0 48%;">
        <p><label>Grading For:</label> {{ $grading->gradingfor }}</p>
    </div>
    <div style="flex: 0 0 48%;">
        <p><label>Age Category:</label> {{ $grading->ageCategory }}</p>
    </div>
    
    <div style="flex: 0 0 48%;">
        <p><label>Arrows Used:</label> {{ $grading->arrowsUsed }}</p>
    </div>
</div>
    <table>
        <thead>
            <tr>
                <th>Arrow</th>
                @foreach($scorecards as $round => $entries)
                    <th>Round {{ $round }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @for($i = 0; $i < $maxArrows; $i++)
                <tr>
                    <td>Arrow {{ $i + 1 }}</td>
                    @foreach($scorecards as $round => $entries)
                        <td>{{ $entries[$i]->arrow ?? '-' }}</td>
                    @endforeach
                </tr>
            @endfor

            <tr>
                <td><strong>Round Total</strong></td>
                @foreach($roundTotals as $val)
                    <td><strong>{{ $val }}</strong></td>
                @endforeach
            </tr>

            <tr>
                <td><strong>Cum Total</strong></td>
                @foreach($cumTotals as $val)
                    <td><strong>{{ $val }}</strong></td>
                @endforeach
            </tr>

            <tr>
                <td><strong>Time</strong></td>
                @foreach($times as $val)
                    <td>{{ $val }}</td>
                @endforeach
            </tr>

            <tr>
                <td colspan="{{ count($scorecards) + 1 }}"><strong>Total Score: {{ $totalScore }}</strong></td>
            </tr>
        </tbody>
    </table>

</body>
</html>
