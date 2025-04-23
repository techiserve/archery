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
    <form class="card-body" method="POST" action="/grading/updateScore">
        @csrf
        <div class="row g-12">
            <div class="col-md-4">
                <label class="form-label">Name</label>
                <input type="text" name="name" value="{{ $name }}" class="form-control" readonly />
            </div>
            <input type="hidden" name="round" value="{{ $round }}" class="form-control" />
            <input type="hidden" name="cat" value="{{ $cat }}" class="form-control" />
            <input type="hidden" name="archer" value="{{ $archer }}" class="form-control" />
            <input type="hidden" name="event" value="{{ $event }}" class="form-control" />
        
        </div><br>

        <div class="card">
            <h2>Scoring Table</h2>
            <select id="round-select" class="input-field" name="round">
                <option value="{{ $round }}">Round {{ $round }}</option>
            </select>

            <div id="scoring-card" class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Arrow</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($getData as $index =>$data)
                        <tr>
                            <td>Arrow {{  $loop->iteration  }}</td>
                            <td>
                                <select class='input-field arrow-score' name='scores[{{ $round }}][{{  $data->id  }}]' required>
                                    <option value="{{$data->arrow}}" >{{$data->arrow}}</option>
                                    @foreach ($possibleScores as $score)
                                        <option value="{{ $score->score }}"> {{ $score->score}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        @endforeach
                        <tr><td><strong>Round Total</strong></td>
                            <td><input type='number' class='input-field' id='round_total' name='round_total' value='{{ $getData->first()->roundtotal ?? 0 }}' /></td></tr>
                        <tr><td><strong></strong></td>
                            <td><input type='hidden' class='input-field' id='cum_total' name='cum_total' value='{{ $getData->first()->total - $getData->first()->roundtotal ?? 0 }}' /></td></tr>
                        <tr><td><strong>Time</strong></td>
                            <td><input type='text' class='input-field' name='time' value='{{ $getData->first()->time ?? "" }}' /></td></tr>
                        <tr><td><strong>Total</strong></td>
                            <td><input type='number' class='input-field' id='total' name='total' value='{{ $getData->first()->total ?? 0 }}' /></td></tr>
                        <tr><td><strong>Current P/R</strong></td>
                            <td><input type='number' class='input-field' name='current_pr' value='{{ $getData->first()->currentPR ?? 0  }}' readonly /></td></tr>
                        @if (isset($eventcategory) && $eventcategory->name === 'Grading')
                        <tr><td><strong>Required P/R</strong></td>
                            <td><input type='number' class='input-field' name='required_pr' value='{{ $requiredPR ?? 0 }}' readonly /></td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update Scores</button>
        <script>
           document.addEventListener('DOMContentLoaded', function () {
        function updateTotals() {
            let total = 0;
            document.querySelectorAll('.arrow-score').forEach(select => {
                total += parseInt(select.value) || 0;
            });

            const cum = parseInt(document.getElementById('cum_total').value) || 0;
            document.getElementById('round_total').value = total;
            document.getElementById('total').value = total + cum;
        }

        document.querySelectorAll('.arrow-score').forEach(select => {
            select.addEventListener('change', updateTotals);
        });

        updateTotals();
    });
      </script>
    </form>
</div>
</div>
@endsection
