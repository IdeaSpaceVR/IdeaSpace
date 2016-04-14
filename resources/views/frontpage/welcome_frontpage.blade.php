@extends('layouts.frontpage_app')

@section('title', 'IdeaSpace')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="row" style="margin-top:20px">
                <div class="col-md-12 text-center">
                    <h1 style="font-size:72px;font-weight:300;margin-bottom:20px">IdeaSpace</h1>
                    <p style="font-size:21px;font-weight:300;line-height:34px;color:rgb(82, 82, 82);margin-bottom:20px">Open source content management system<br> for the virtual reality web.</p>
                    <p style="font-size:21px;font-weight:300;line-height:34px;color:rgb(82, 82, 82);"><a style="text-decoration:underline;color:#0080e5;" href="https://www.ideaspacevr.org">www.ideaspacevr.org</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- footer //-->
<div class="footer clearfix" style="margin:50px 0 10px 0">
    <div class="text-center">
    Made with <span class="glyphicon glyphicon-heart" aria-hidden="true" style="color:red"></span> and <span class="glyphicon glyphicon-fire" aria-hidden="true" style="color:red"></span>
    </div>
    <div class="pull-right" style="margin: 0 20px 0 0;font-size:12px">
    Version {{ env('VERSION') }}
    </div>
</div>

@endsection
