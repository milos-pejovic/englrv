@extends('layouts.app')

@section('content')

<?php

// dd($ex);

foreach($ex as $e) {
  echo $e->title . '<br />';
}

?>

{{ $ex->links() }}

@endsection