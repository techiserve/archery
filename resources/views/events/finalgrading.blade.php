@extends('template.default')

<style>
    .table-responsive { overflow-x: auto; }
    .sticky-col {
        position: sticky; left: 0; background-color: white; z-index: 2;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }
    .container { max-width: 800px; margin: auto; padding: 20px; }
    .card { background: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); padding: 20px; border-radius: 5px; }
    .input-field, .button, select { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px; }
    .table-container { margin-top: 20px; border-radius: 5px; border: 1px solid #ccc; }
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
    .confirm-button { background: green; color: white; padding: 10px; border: none; cursor: pointer; border-radius: 5px; }
    .confirm-button:hover { background: darkgreen; }
</style>

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<div class="card mb-6">
    <h5 class="card-header">Capture Scores</h5>
    <form class="card-body" method="POST" action="/grading/confirmscores">
        @csrf

            <div class="row g-12">
                <div class="col-md-4">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" value="{{ $name }}" class="form-control" />
                </div>
                     
                <input type="hidden" name="bowused" value="{{ $bowused }}" class="form-control" />
                <input type="hidden" name="arrow" value="{{ $arrow }}" class="form-control" />
                <input type="hidden" name="" value="{{ $figure }}" class="form-control" />
                <input type="hidden" name="gradefor" value="{{ $gradefor }}" class="form-control" />
                <input type="hidden" name="currentprof" value="{{ $currentprof }}" class="form-control" />
                <input type="hidden" name="curentgrading" value="{{ $curentgrading }}" class="form-control" />
                <input type="hidden" name="age" value="{{ $age }}" class="form-control" />
                <input type="hidden" name="eventcategory" value="{{ $eventcategory }}" class="form-control" />
                <input type="hidden" name="date" value="{{ $date }}" class="form-control" />
                <input type="hidden" name="event" value="{{ $event }}">
                <input type="hidden" name="archer" value="{{ $archer }}">
                <input type="hidden" name="figure" value="{{ $figure }}">
            </div></br>
        <div class="card">
            <h2>Scoring Table</h2>
            <select id="round-select" class="input-field" name="round" onchange="generateTable()">
           
                    <option value="{{ $currentRound }}">Round {{ $currentRound }}</option>
              
            </select>
            <div id="scoring-card" class="table-container"></div>
    
        </div>
        @if($remaining_rounds != 0)
        <button type="submit" class="btn btn-primary mt-3">Confirm Scores</button>
        @endif
    </form>
</div>
</div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        generateTable();
    });

    let latestCumTotal = @json($cumtotal ?? 0);
    let numberOfRounds = @json($noofrounds ?? 1);
    let requiredTotal = @json($figure ?? 0);
    let curPR = @json($currentPR ?? 0);
    let requiredPr = @json($requiredPR ?? 0);
  //  console.log(curPR);
    let remainingRounds = @json($remaining_rounds ?? ($category->rounds - 1));
    let eventCategory = @json($eventcategory ?? '');
    let now = new Date();
let hours = String(now.getHours()).padStart(2, '0');
let minutes = String(now.getMinutes()).padStart(2, '0');
let currentTime = `${hours}:${minutes}`;

    function generateTable() {
        let arrows = @json($category->arrows);
        let scoringCard = document.getElementById('scoring-card');
        let selectedRound = document.getElementById('round-select').value;
        let possibleScores = @json($scores);

        let html = `<table>
                        <thead>
                            <tr>
                                <th>Arrow</th>
                                <th>Score</th>
                            </tr>
                        </thead>
                        <tbody>`;

        for (let j = 1; j <= arrows; j++) {
            html += `<tr>
                <td>Arrow ${j}</td>
                <td>
                    <select class='input-field arrow-score' name='scores[${selectedRound}][${j}]' data-round="${selectedRound}" required>
                        <option value="0">M</option>
                        ${possibleScores.map(score => `<option value='${score}'>${score}</option>`).join('')}
                    </select>
                </td>
            </tr>`;
        }


        html += `<tr><td><strong>Round Total</strong></td>
                    <td><input type='number' class='input-field' id='round_total' name='round_total' readonly /></td></tr>`;
        html += `<tr><td><strong></strong></td>
                    <td><input type='hidden' class='input-field' id='cum_total' name='cum_total' readonly /></td></tr>`;
        html += `<tr><td><strong>Time</strong></td>
                    <td><input type='text' class='input-field' name='time'  required /></td></tr>`;
        html += `<tr><td><strong>Total</strong></td>
                    <td><input type='number' class='input-field' id='total' name='total' readonly /></td></tr>`;
        html += `<tr><td><strong>Current P/R</strong></td>
                    <td><input type='number' class='input-field'  name='current_pr'  value='${curPR}'  readonly /></td></tr>`;

        // Only show Required P/R if event category is 'Grading A'
        if (eventCategory === 'Grading A') {
            html += `<tr><td><strong>Required P/R</strong></td>
                        <td><input type='number' class='input-field'  name='required_pr'  value='${requiredPr}' readonly /></td></tr>`;
        }

        html += `</tbody></table>`;

        scoringCard.innerHTML = html;

        document.querySelectorAll(".arrow-score").forEach(select => {
            select.addEventListener("change", updateRoundTotal);
        });

        updateRoundTotal();
    }

    function updateRoundTotal() {
        let total = 0;
        document.querySelectorAll(".arrow-score").forEach(select => {
            total += parseInt(select.value) || 0;
        });

        document.getElementById("round_total").value = total;
        let cumTotal = total + latestCumTotal;
        document.getElementById("cum_total").value = cumTotal;
        document.getElementById("total").value = cumTotal;

       
    }

    document.querySelector("form").addEventListener("submit", function() {
        updateRoundTotal();
    });
</script>
