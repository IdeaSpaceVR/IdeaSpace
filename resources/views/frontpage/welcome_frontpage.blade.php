@extends('layouts.frontpage_app')

@section('title', $title)

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="row" style="margin-top:80px">
                <div class="col-md-12 text-center">
                    <h1 style="font-size:72px;font-weight:300;margin-bottom:20px">IdeaSpaceVR</h1>
                    <p style="font-size:21px;font-weight:300;line-height:34px;color:rgb(82, 82, 82);margin-bottom:20px">Create interactive 3D and VR web experiences<br>for desktop, mobile & VR devices</p>
                    <p style="font-size:21px;font-weight:300;line-height:34px;color:rgb(82, 82, 82);"><a style="text-decoration:underline;color:#0080e5;" href="https://www.ideaspacevr.org">www.ideaspacevr.org</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- footer //-->
<div class="footer clearfix" style="margin:50px 0 10px 0">
    <div class="text-center">
    Made on Earth <i class="fa fa-globe" aria-hidden="true"></i>
    </div>
    <div class="pull-right" style="margin: 0 20px 0 0;font-size:12px">
    Version {{ config('app.version') }}
    </div>
</div>

@endsection
