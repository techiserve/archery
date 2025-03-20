@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-6">
        <h5 class="card-header">Create Event Category</h5>
        <form class="card-body" method="POST" action="/event/storeCategory">
            @csrf
            <h6>1. Event Category Details</h6>
            <div class="row g-6">
                <div class="col-md-6">
                    <label class="form-label" for="multicol-username">Name</label>
                    <input type="text" id="multicol-username" name="name" class="form-control" placeholder="Grading" />
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="multicol-email">Description</label>
                    <div class="input-group input-group-merge">
                        <input type="text" id="multicol-username" name="desc" class="form-control" placeholder="John Doe" />
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="multicol-first-name">Rounds</label>
                    <input type="number" id="multicol-username" name="rounds" class="form-control" placeholder="9" />
                </div>

                <div class="col-md-6">
                    <label class="form-label" for="multicol-first-name">Arrows</label>
                    <input type="number" id="multicol-username" name="arrows" class="form-control" placeholder="6" />
                </div>

                <!-- Score Section -->
                <div class="col-md-12">
                    <label class="form-label">Scores</label>
                    <div id="score-container">
                        <!-- Default score input field -->
                        <div class="input-group mb-2 score-input">
                            <input type="number" name="score[]" class="form-control" placeholder="0-10" />
                            <button type="button" class="btn btn-success add-score">+</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="btn btn-primary me-3">Submit</button>
                <button type="reset" class="btn btn-label-secondary">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const scoreContainer = document.getElementById("score-container");

        // Function to add a new score input field
        function addScoreField() {
            const div = document.createElement("div");
            div.classList.add("input-group", "mb-2", "score-input");

            div.innerHTML = `
                <input type="number" name="score[]" class="form-control" placeholder="0-10" />
                <button type="button" class="btn btn-danger remove-score">-</button>
            `;

            scoreContainer.appendChild(div);
        }

        // Event Listener to Add Score Fields
        scoreContainer.addEventListener("click", function (event) {
            if (event.target.classList.contains("add-score")) {
                addScoreField();
            }
        });

        // Event Listener to Remove Score Fields
        scoreContainer.addEventListener("click", function (event) {
            if (event.target.classList.contains("remove-score")) {
                event.target.parentElement.remove();
            }
        });
    });
</script>
