@extends('layouts.app')

<!-- Check answers modal -->

<div class="my-modal-wrap check-answers">
  <div class="screen-cover"></div>
    <div class="my-modal-inner-wrap">

     <div class="my-modal">
      <h2 class="title">Check answers</h2>
      <hr />
      <p class="text">Are you certain you want to check the answers?</p>
      <hr />
      <button class="btn btn-primary ok-button">Continue</button>
      <button class="btn btn-primary cancel-button">Cancel</button>
    </div>
  </div>
</div>

<!-- Show answers modal -->

<div class="my-modal-wrap show-answers">
  <div class="screen-cover"></div>
    <div class="my-modal-inner-wrap">

     <div class="my-modal">
      <h2 class="title">Show answers</h2>
      <hr />
      <p class="text">This will delete your aswers. Continue?</p>
      <hr />
      <button class="btn btn-primary ok-button">Yes</button>
      <button class="btn btn-primary cancel-button">Cancel</button>
    </div>
  </div>
</div>

<!-- Clear answers modal -->

<div class="my-modal-wrap clear-answers">
  <div class="screen-cover"></div>
    <div class="my-modal-inner-wrap">

     <div class="my-modal">
      <h2 class="title">Clear answers</h2>
      <hr />
      <p class="text">This will delete your aswers. Continue?</p>
      <hr />
      <button class="btn btn-primary ok-button">Yes</button>
      <button class="btn btn-primary cancel-button">Cancel</button>
    </div>
  </div>
</div>

@section('content')

<div class="container">
  <div class="row">
    <div class="col-10">

      <h1>{{ $exercise->title }}</h1>

<!--
      <p class="tags">
        @foreach($exercise->tags as $tag)
          <span class="exercise-tag">{{ $tag->name }}</span>
        @endforeach
      </p>
-->
      <!-- <p>Level: {{ $exercise->level }}</p> -->
      <!-- <p>Author: {{ $exercise->user->username }}</p> -->

      <hr />

      <div class="exercise-data-wrapper">

      </div>

      <script src="/js/renderer.js"></script>

      <script>
        var exJson = <?php echo $exercise->json ?>;
        var segments = exJson.segments.length; 
        console.log(exJson);

        for (var i = 0; i < exJson.segments.length; i++) {
          switch(exJson.segments[i].type) {
            
            case "hero-image" :
              renderer.heroImage(exJson.segments[i])
              break;

            case "text" :
              renderer.text(exJson.segments[i]);
              break;

            case "text-questions" :
              renderer.textQuestions(exJson.segments[i]);
              break; 
              
            case "given-words" :
              renderer.givenWords(exJson.segments[i]);
              break; 
          }
        }

      </script>

    </div><!-- .col end-->
  </div><!-- .row end -->
<div><!-- .container end -->

@endsection