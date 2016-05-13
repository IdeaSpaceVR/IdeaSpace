@extends('layouts.app')

@section('title', 'IdeaSpace')

@section('content')

    <h1>Add New Space</h1> 
    <h3>Select a theme:</h3>

    {!! Form::open(array('route' => 'space_add_select_theme_submit', 'method' => 'POST', 'autocomplete' => 'false')) !!}

    @if (count($themes) === 0) 
        <div class="row">
            <div class="col-md-12" style="font-size:16px">
            There are no active themes yet. <a href="{{ route('themes') }}" style="color:#000000;text-decoration:underline">Activate some themes here</a>.
            </div>    
        </div>    
    @endif 

    <?php $i=0; ?>
    @foreach ($themes as $theme)
    <?php if ($i % 3 == 0) { ?>
      <?php if ($i != 0) { ?>
      </div> <!-- end row //-->
      <?php } ?>
    <div class="row">
    <?php } ?>
        <div class="col-md-4 text-center">
            <div class="thumbnail">
                <input type="hidden" name="id-{{ $theme['id'] }}" value="{{ $theme['id'] }}">
                <img width="400" src="{{ $theme['screenshot'] }}" class="img-responsive" alt="{{ $theme['title'] }}">
                <div class="caption">
                    <h3>{{ $theme['title'] }}</h3>
                    <p class="text-center">{{ $theme['description'] }}</p>
                </div>
            </div>
        </div>
    <?php $i++; ?>
    @endforeach
    </div> <!-- end row //-->

    {!! Form::close() !!}

@endsection
