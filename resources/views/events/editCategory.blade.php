@extends('template.default')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-6">
        <h5 class="card-header">Edit Event Category</h5>

        <form class="card-body" method="POST" action="{{ route('event.updateCategory', ['id' => $category->id]) }}">
            @csrf
            @method('PUT')

            <h6>Event Category Details</h6>

            <div class="row g-6">
                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input 
                        type="text" 
                        name="name" 
                        value="{{ $category->name }}" 
                        class="form-control" 
                        placeholder="Enter Name" 
                    />
                </div>

                <div class="col-md-6">
                    <label class="form-label">Description</label>
                    <input 
                        type="text" 
                        name="desc" 
                        value="{{ $category->desc }}" 
                        class="form-control" 
                        placeholder="Enter Description" 
                    />
                </div>

                <div class="col-md-6">
                    <label class="form-label">Rounds</label>
                    <input 
                        type="number" 
                        name="rounds" 
                        value="{{ $category->rounds }}" 
                        class="form-control" 
                    />
                </div>

                <div class="col-md-6">
                    <label class="form-label">Arrows</label>
                    <input 
                        type="number" 
                        name="arrows" 
                        value="{{ $category->arrows }}" 
                        class="form-control" 
                    />
                </div>


                <div class="col-md-12">
                    <label class="form-label">Scores</label>

                    
                    <div id="score-container">
                        @forelse($scores as $score)
                            <div class="input-group mb-2 score-input">
                                <input 
                                    type="number" 
                                    name="score[]" 
                                    value="{{ $score->score }}" 
                                    class="form-control" 
                                    placeholder="0-100" 
                                />

                                @if($loop->first)
                                    <button type="button" class="btn btn-success add-score ms-2">+</button>
                                @else
                                    <button type="button" class="btn btn-danger remove-score ms-2">-</button>
                                @endif
                            </div>
                        @empty
                            <div class="input-group mb-2 score-input">
                                <input 
                                    type="number" 
                                    name="score[]" 
                                    class="form-control" 
                                    placeholder="0-100" 
                                />
                                <button type="button" class="btn btn-success add-score ms-2">+</button>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-3">
                        <input type="hidden" name="include_x" value="0">

                        <div class="form-check">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                id="includeX" 
                                name="include_x" 
                                value="1"
                                {{ $scores->contains('isX', 1) ? 'checked' : '' }}
                            >

                            <label class="form-check-label" for="includeX">
                                Include X
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="btn btn-primary me-3">Update</button>
                <a href="/event/categories" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

<script>
document.addEventListener("DOMContentLoaded", function () {
    const scoreContainer = document.getElementById("score-container");

    function addScoreField() {
        const div = document.createElement("div");
        div.classList.add("input-group", "mb-2", "score-input");

        div.innerHTML = `
            <input type="number" name="score[]" class="form-control" placeholder="0-100" />
            <button type="button" class="btn btn-danger remove-score ms-2">-</button>
        `;

        scoreContainer.appendChild(div);
    }

    scoreContainer.addEventListener("click", function (event) {
        if (event.target.classList.contains("add-score")) {
            addScoreField();
        }

        if (event.target.classList.contains("remove-score")) {
            event.target.parentElement.remove();
        }
    });
});
</script>