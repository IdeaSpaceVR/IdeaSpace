@extends('layouts.app')

@section('title', 'IdeaSpace - Settings')

@section('content')

    <h1>Space Settings</h1>

    {!! Form::open(array('route' => 'space_settings', 'method' => 'POST', 'autocomplete' => 'false')) !!}

    @if (session('alert-success'))
    <div class="row">
        <div class="col-md-9">
            <div class="alert alert-success">
            {!! session('alert-success') !!}
            </div>
        </div>
    </div>
    @endif

    <div class="row" style="margin-top:20px">

        <div class="col-md-2">
            <label for="front-page-display" class="control-label">Front Page Displays</label>
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-12">
                    <div class="radio">
                        <label>
                        {!! Form::radio('front-page-display', 'latest-spaces', $latest_spaces_checked) !!}
                        Your latest spaces
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="radio">
                        <label>
                        {!! Form::radio('front-page-display', 'one-space', $one_space_checked) !!}
                        One space (select below)
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                <?php 
                $arr = ['class' => 'form-control'];
                if ($latest_spaces_checked == true) {
                    $arr['disabled'] = true;
                }
                ?>
                {!! Form::select('space', $spaces, $space_id_selected, $arr) !!}
                </div>
            </div>
        </div> <!-- end col-md-10 //-->
    </div> <!-- end row //-->

    <div class="row" style="margin-top:20px">
        <div class="col-md-10 col-md-offset-2">
        <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </div>

    {!! Form::close() !!}

@endsection
