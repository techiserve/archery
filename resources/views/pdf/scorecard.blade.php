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

<style>
    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .info-col {
        flex: 0 0 32%;
    }

    .info-col label {
        font-weight: bold;
        display: inline-block;
        min-width: 100px;
    }
</style>

</head>
<body>
<!-- <div class="header-title">Score Card History</div> -->
    <div class="logo">
        <img src="{{ public_path('assets/img/avatars/achery1.jpg') }}" alt="Logo">
    </div>

  
    
<div class="info">
    <div class="info-row">
        <div class="info-col"><label>Name:</label> {{ $grading->name }}</div>
        <div class="info-col"><label>Date:</label> {{ $grading->date }}</div>
        <div class="info-col"><label>Bow Used:</label> {{ $grading->bowUsed }}</div>
    </div>
    
    <div class="info-row">
        <div class="info-col"><label>Current Grading:</label> {{ $grading->currentGrading }}</div>
        <div class="info-col"><label>Grading For:</label> {{ $grading->gradingfor }}</div>
        <div class="info-col"><label>Age Category:</label> {{ $grading->ageCategory }}</div>
    </div>
    
    <div class="info-row">
        <div class="info-col"><label>Arrows Used:</label> {{ $grading->arrowsUsed }}</div>
        <div class="info-col"></div>
        <div class="info-col"></div>
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
