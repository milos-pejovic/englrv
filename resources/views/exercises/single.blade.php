@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-10">

      <h1>{{ $exercise->title }}</h1>

      <p class="tags">
        @foreach($exercise->tags as $tag)
          <span class="exercise-tag">{{ $tag->name }}</span>
        @endforeach
      </p>

      <p>Level: {{ $exercise->level }}</p>
      <p>Author: {{ $exercise->user->username }}</p>

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
          }
        }

      </script>

    </div><!-- .col end-->
  </div><!-- .row end -->
<div><!-- .container end -->

@endsection