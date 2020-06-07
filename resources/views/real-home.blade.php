@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-8 col-lg-6 col-xl-6 search-form-div">

          <h1>Exercise search</h1>

          <form class="exercise-search" method="POST">

            {{ csrf_field() }}

            <div class="form-group">
              <input type="text" class="form-control" id="exercise-title" name="exercise_title" placeholder="Exercise title">
            </div>

            <div class="form-group">
              <input type="text" class="form-control" id="exercise-author" name="exercise_author" placeholder="Exercise author">
            </div>

            <div class="form-group">
              <input type="text" class="form-control" id="tags" name="tags" placeholder="Tags (tag1, tag2, ...)">
            </div>

            <label>Levels</label>

            <div class="form-group">

              <div class="level-label-wrap">
                <label class="form-check-label level-label">
                  <input type="checkbox" name="levels[]" class="form-check-input" id="a1" value="a1">
                  <span class="level-label">A1</span>
                </label>
              </div>
              
              <div class="level-label-wrap">
                <label class="form-check-label level-label">
                  <input type="checkbox" name="levels[]" class="form-check-input" id="a2" value="a2">
                  <span class="level-label">A2</span>
                </label>
              </div>

              <div class="level-label-wrap">
                <label class="form-check-label level-label">
                  <input type="checkbox" name="levels[]" class="form-check-input" id="b1" value="b1">
                  <span class="level-label">B1</span>
                </label>
              </div>
              
              <div class="level-label-wrap">
                <label class="form-check-label level-label">
                  <input type="checkbox" name="levels[]" class="form-check-input" id="b2" value="b2">
                  <span class="level-label">B2</span>
                </label>
              </div>

              <div class="level-label-wrap">
                <label class="form-check-label level-label">
                  <input type="checkbox" name="levels[]" class="form-check-input" id="c1" value="c1">
                  <span class="level-label">C1</span>
                </label>
              </div>
              
              <div class="level-label-wrap">
                <label class="form-check-label level-label">
                  <input type="checkbox" name="levels[]" class="form-check-input" id="c2" value="c2">
                  <span class="level-label">C2</span>
                </label>
              </div>

            </div>
            <div class="form-group result-formating-controls">

              <div class="row">

                <div class="form-group col-4">
                  <label for="exampleFormControlSelect1">Results per page</label>
                  <select class="form-control" id="results_per_page" name="results_per_page" class="results_per_page">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20" selected="selected">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                  </select>
                </div>

                <div class="form-group col-4">
                  <label for="exampleFormControlSelect1">Sort by column</label>
                  <select class="form-control" id="order_by" name="order_by" class="order_by">
                    <option value="id">Id</option>
                    <option value="title" selected="selected">Title</option>
                    <option value="level">Level</option>
                    <option value="author">Author</option>
                  </select>
                </div>

                <div class="form-group col-4">
                  <label for="exampleFormControlSelect1">Sorting direction</label>
                  <select class="form-control" id="sorting_direction" name="sorting_direction" class="sorting_direction">
                    <option value="ASC" selected="selected">Ascending</option>
                    <option value="DESC">Descending</option>
                  </select>
                </div>

              </div><!-- Row end -->

              <input type="hidden" name="page" class="page" value="1" />
            </div>

              <button type="submit" class="btn btn-primary search-button">Search</button>

              <div class="spinner-wrap">
                <img class="spinner" src="/images/spinner8.gif" />
                <p class="searching-for-exercises">Searching for exercises...</p>
              </div>
              

          </form>

          </div>
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-10">

          <h2 class="search-results-header">Search results: <span class="number-of-results">0</span></h2>

          <div class="pagination-wrapper"></div>

          <table class="table table-sm table-hover exercises-search-results">
            <thead class="thead-light">
              <tr>
                <!-- <th scope="col" style="border-bottom: none;">#</th> -->
                <th scope="col" style="border-bottom: none;">Id</th>
                <th scope="col" style="border-bottom: none;">Title</th>
                <!-- <th scope="col" style="border-bottom: none;">Id</th> -->
                <th scope="col" style="border-bottom: none;">Level</th>
                <!-- <th scope="col" style="border-bottom: none;">Language</th> -->
                <th scope="col" style="border-bottom: none;">Author</th>
                <th scope="col" class="d-none d-md-block no-bottom-border" style="border-bottom: none;">Tags</th>
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
$('.form-control, .form-check-input').on('input', function() {
  if (timer) {
    clearTimeout(timer);
  }
  timer = setTimeout('searchForExercises("form")', 1200);
});

/**
 * ======================================================================================== 
 * Render found exercises
 * ========================================================================================
 */
function renderExercises(exercises) {
  var exercisesWrap = $('.exercise-results');
  var newHtml = '';

  exercisesWrap.html('');
  var numberOfExercises = exercises.length;

  for (var i = 0; i < numberOfExercises; i++) {
    newHtml += '<tr>';
    // newHtml += '<th>' + (i + 1) + '</th>';
    newHtml += '<td>' + exercises[i].public_id + '</td>';
 
    newHtml += '<td width="25%"><p><a href="/ex/' + exercises[i].public_id + '" target="_blank"><b>' + exercises[i].title + '</b></a></p></td>';
    newHtml += '<td>' + exercises[i].level + '</td>';
    // newHtml += '<td>' + capitalize(exercises[i].language) + '</td>';
    // newHtml += '<td>' + exercises[i].user.username + '</td>';
    newHtml += '<td>' + exercises[i].author + '</td>';
    newHtml += '<td class="d-none d-md-block">';
    var numberOfTags = exercises[i].tags.length;
    for (var j = 0; j < numberOfTags; j++) {
      newHtml += '<span class="exercise-tag">' + exercises[i].tags[j].name + '</span>';
    }
    newHtml += '</td>';
    newHtml += '</tr>';

    // Render tags for mobile view

    newHtml += '<tr class="d-md-none">';
    newHtml += '<th></th>';
 
    newHtml += '<td colspan="5">';
    var numberOfTags = exercises[i].tags.length;
    for (var j = 0; j < numberOfTags; j++) {
      newHtml += '<span class="exercise-tag">' + exercises[i].tags[j].name + '</span>';
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
function searchForExercises(source) {

  if (source == 'form') {
    $('.exercise-search .page').val('1');
  }

  console.log('Before ajax');

  $('.spinner-wrap').css('display', 'inline-block');

  $.ajax({
    type: 'POST',
    url: '/search-exercise',
    data: $('.exercise-search').serialize(),
    success: function (result) {
      console.warn('SUCCESS');
      $('.spinner-wrap').hide();
      renderResults(result);
    },
    error: function() {
      console.log('ERROR');
    }
  });
}

/**
 * ======================================================================================== 
 * Render search results
 * ========================================================================================
 */
function renderResults(rawData) {
  var data = JSON.parse(rawData);

  console.log(data);

  $('.number-of-results').text(data.exercises.total);

  renderExercises(data.exercises.data);
  renderPagination(
    data.links,
    data.exercises.current_page,
    data.exercises.last_page,
  );
}

/**
 * ======================================================================================== 
 * Render pagination
 * ========================================================================================
 */
function renderPagination(paginationLinksData, current_page, last_page) {

  console.log(paginationLinksData);

  var paginationWrapper = $('.pagination-wrapper');
  var paginationHtml = '';
  paginationHtml += '<nav aria-label="...">';
  paginationHtml += '<ul class="pagination">';
  paginationHtml += '<li class="page-item ' + (current_page == 1 ? 'disabled' : '') + '"><a class="page-link" href="#" data-page-number="' + (current_page - 1) + '" rel="prev" aria-label="« Previous"><</a></li>';

  // If Pagination Links Data is an Array

  if (paginationLinksData.constructor === Array) {
    var rawDataLength = paginationLinksData.length;

    for(var i = 0; i < rawDataLength; i++) {
      if (paginationLinksData[i].constructor === Object) {
        for (let key in paginationLinksData[i]) {

          paginationHtml += '<li class="page-item ' + (key == current_page ? 'active' : '') + '"><a class="page-link" data-page-number="' + key + '" href="#">' + key + '</a></li>';
        }
      } else if (paginationLinksData[i].constructor === String && paginationLinksData[i] == '...') {
        paginationHtml += '<li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>';
      }
    }

  } else if (paginationLinksData.constructor === Object) {

    // If Pagination Links Data is an Object

    for (let linksKey in paginationLinksData) { 
      if (paginationLinksData[linksKey].constructor === Object) {
        for (let key in paginationLinksData[linksKey]) {

          paginationHtml += '<li class="page-item ' + (key == current_page ? 'active' : '') + '"><a class="page-link" data-page-number="' + key + '" href="#">' + key + '</a></li>';
        }
      } else if (paginationLinksData[linksKey].constructor === String && paginationLinksData[linksKey] == '...') {
        paginationHtml += '<li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>';
      }
    }
  }

  paginationHtml += '<li class="page-item ' + (current_page == last_page ? 'disabled' : '') + '"><a class="page-link" href="#" rel="next" data-page-number="' + (current_page + 1) + '" aria-label="Next »">></a></li>';
  paginationHtml += '</ul>';
  paginationHtml += '</nav>';
  
  paginationWrapper.html(paginationHtml);
}

/**
 * ======================================================================================== 
 * Capitalize the first letter
 * ========================================================================================
 */
function capitalize(string) {
  return string[0].toUpperCase() + string.slice(1);
}

$( "body" ).delegate(".page-link", "click", function(e) {
  e.preventDefault();
  $('.exercise-search .page').val($(this).data('page-number'));
  searchForExercises();
});

$('.exercise-search').on('submit', function(e) {
  e.preventDefault();
  $('.exercise-search .page').val('1');
  searchForExercises();
});

$('.level-label-wrap').on('click', function() {
  $(this).toggleClass('selected-level');
});

// TODO: Is this needed? 
$('.level-label-wrap input').on('click', function(e){
  e.stopPropagation();
});

// Trim the value of these fields

$('#tags, #exercise-title, #exercise-author').on('input', function() {
  var value = $(this).val();
  $(this).val(value.trim());
});

</script>

@endsection
