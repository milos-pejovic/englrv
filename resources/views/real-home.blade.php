@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

          <form class="exercise-search">

            {{ csrf_field() }}

            <div class="form-group">
              <label for="exercise-author">Exercise author</label>
              <input type="text" class="form-control" id="exercise-author" name="exercise_author" placeholder="Exercise author">
            </div>

            <div class="form-group">
              <label for="tags">Tags</label>
              <input type="text" class="form-control" id="tags" name="tags" placeholder="tags">
            </div>

            <div class="form-check">

              <div class="level-label-wrap" style="display:inline-block; margin-right: 40px">
                <label class="form-check-label level-label">
                  <input type="checkbox" name="levels[]" class="form-check-input" id="a1" value="a1"><span>A1</span>
                </label>
              </div>
              
              <div class="level-label-wrap" style="display:inline-block; margin-right: 40px">
                <label class="form-check-label level-label">
                  <input type="checkbox" name="levels[]" class="form-check-input" id="a2" value="a2">A2
                </label>
              </div>

              <div class="level-label-wrap" style="display:inline-block; margin-right: 40px">
                <label class="form-check-label level-label">
                  <input type="checkbox" name="levels[]" class="form-check-input" id="b1" value="b1"><span>B1</span>
                </label>
              </div>
              
              <div class="level-label-wrap" style="display:inline-block; margin-right: 40px">
                <label class="form-check-label level-label">
                  <input type="checkbox" name="levels[]" class="form-check-input" id="b2" value="b2">B2
                </label>
              </div>

              <div class="level-label-wrap" style="display:inline-block; margin-right: 40px">
                <label class="form-check-label level-label">
                  <input type="checkbox" name="levels[]" class="form-check-input" id="c1" value="c1"><span>C1</span>
                </label>
              </div>
              
              <div class="level-label-wrap" style="display:inline-block; margin-right: 40px">
                <label class="form-check-label level-label">
                  <input type="checkbox" name="levels[]" class="form-check-input" id="c2" value="c2">C2
                </label>
              </div>

            </div>

            <button type="submit" class="btn btn-primary">Search</button>
          </form>

          <table class="table table-sm exercises">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Level</th>
                <th scope="col">Author</th>
                <th scope="col">Tags</th>
              </tr>
            </thead>
            <tbody class="exercise-results">
            </tbody>
          </table>

        </div>
    </div>
</div>

<script>

/**
 * ======================================================================================== 
 * Usernames autocomplete
 * ========================================================================================
 */
$(function() {
  var availableUsernames = [<?php echo '"' . implode('", "', $userNames) . '"' ?>];
  $("#exercise-author").autocomplete({
    source: availableUsernames
  });
});

/**
 * ======================================================================================== 
 * Input field input event handler
 * ========================================================================================
 */
var timer;
$('.form-control').on('input', function() {
  if (timer) {
    clearTimeout(timer);
  }
  timer = setTimeout('searchForExercises()', 700);
});


/**
 * ======================================================================================== 
 * Render found exercises
 * ========================================================================================
 */
function renderExercises(exercises) {
  var exercises = JSON.parse(exercises);
  var exercisesWrap = $('.exercise-results');
  var newHtml = '';

  exercisesWrap.html('');

  var numberOfExercises = exercises.length;

  for (var i = 0; i < numberOfExercises; i++) {
    newHtml += '<tr>';
    newHtml += '<th scope="row">' + (i + 1) + '</th>';
    newHtml += '<td>' + exercises[i].title + '</td>';
    newHtml += '<td>' + exercises[i].level + '</td>';
    newHtml += '<td>' + exercises[i].user.username + '</td>';

    newHtml += '<td>';
    var numberOfTags = exercises[i].tags.length;
    
    for (var j = 0; j < numberOfTags; j++){
      newHtml += '<span style="display: inline-block; background:lightgray; margin-right: 5px; padding: 0 3px">' + exercises[i].tags[j].name + '</span>';
    }
    newHtml += '</td>';

    newHtml += '</tr>';
  }

  exercisesWrap.html(newHtml);
}

/**
 * ======================================================================================== 
 * Call ajax for exercise search
 * ========================================================================================
 */
function searchForExercises() {
  console.log('Before ajax');
  $.ajax({
    type: 'POST',
    url: '/search-exercise',
    data: $('.exercise-search').serialize(),
    success: function (result) {
      console.warn('SUCCESS');
      renderExercises(result);
    },
    error: function() {
      console.log('ERROR');
    }
  });
}

$('.exercise-search').on('submit', function(e) {
  e.preventDefault();
  searchForExercises();
});

</script>

@endsection
