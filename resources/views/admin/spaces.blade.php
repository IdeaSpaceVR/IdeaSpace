@extends('layouts.app')

@section('title', 'IdeaSpaceVR')

@section('content')

    <h1 style="padding-left:35px">{{ trans('template_spaces.spaces') }} <a style="margin-left:20px;margin-bottom:6px;" class="btn btn-primary btn-sm" role="button" href="{{ route('space_add_select_theme') }}">{{ trans('template_spaces.add_new') }}</a></h1>

    {!! Form::open(array('route' => 'spaces_all', 'method' => 'POST', 'autocomplete' => 'false')) !!}

    @if (session('alert-success'))
    <div class="row" style="padding-left:35px">
        <div class="col-md-9">
            <div class="alert alert-success">
            {!! session('alert-success') !!}
            </div>
        </div>
    </div>
    @endif

    <div class="row" style="padding-left:35px">

        <div class="col-md-12">

        <div>
            <a href="{{ route('spaces_all') }}">@if (Route::currentRouteName() == 'spaces_all') <span class="spaces selected">{{ trans('template_spaces.all') }}</span> @else All @endif <span class="spaces @if (Route::currentRouteName() == 'spaces_all') selected @endif">({{ $number_spaces_all }})</span></a> | <a href="{{ route('spaces_published') }}">@if (Route::currentRouteName() == 'spaces_published') <span class="spaces selected">{{ trans('template_spaces.published') }}</span> @else Published @endif <span class="spaces @if (Route::currentRouteName() == 'spaces_published') selected @endif">({{ $number_spaces_published }})</span></a> | <a href="{{ route('spaces_deleted') }}">@if (Route::currentRouteName() == 'spaces_deleted') <span class="spaces selected">{{ trans('template_spaces.trash') }}</span> @else Trash @endif <span class="spaces @if (Route::currentRouteName() == 'spaces_deleted') selected @endif">({{ $number_spaces_deleted }})</span></a>
        </div>

        <div class="table-responsive" style="border:none">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width:3%"><!--input id="" type="checkbox" name="" value=""//--></th>
                        <th>{{ trans('template_spaces.title') }}</th>
                        <th style="width:30%">{{ trans('template_spaces.theme') }}</th>
                        <th style="width:10%">{{ trans('template_spaces.author') }}</th>
                        <th style="width:10%">{{ trans('template_spaces.date') }}</th>
                    </tr>
                </thead>
                <tbody>
                @if (count($spaces) == 0)
                  <tr>
                        <td colspan="5">{{ trans('template_spaces.no_entries_yet') }}</td>
                  </tr>
                @endif 
                @foreach ($spaces as $space)
                    <tr>
                        <td><!--input id="" type="checkbox" name="space[]" value=""//--></td>
                        <td class="space-title">
                            <!--div><a style="font-weight:bold;word-wrap:break-word;" href="#" class="title">{{ $space->title }}</a></div//-->
                            <div class="title" style="font-weight:bold;word-wrap:break-word;">{{ $space->title }}</div>
                            @if ($space->status == App\Space::STATUS_TRASH) 
                            <span class="space-actions"><a style="font-size:14px" href="{{ route('space_restore', ['id' => $space->id]) }}">{{ trans('template_spaces.restore') }}</a> <span style="font-size:14px;color:#999999">|</span> <a href="{{ route('space_delete', ['id' => $space->id]) }}" style="font-size:14px;color:#c9302c;">{{ trans('template_spaces.delete_permanently') }}</a> 
                            @else 
                            <div>
                            <span class="space-actions"><a style="font-size:14px" href="{{ route('space_edit', ['id' => $space->id]) }}">{{ trans('template_spaces.edit') }}</a> <span style="font-size:14px;color:#999999">|</span> <a href="{{ route('space_trash', ['id' => $space->id]) }}" style="font-size:14px;color:#c9302c;">{{ trans('template_spaces.trash') }}</a> <span style="font-size:14px;color:#999999;">|</span> @if ($space->status == App\Space::STATUS_PUBLISHED)<a style="font-size:14px" href="{{ url($space->uri) }}" target="_blank">{{ trans('template_spaces.view') }}</a>@elseif ($space->status == App\Space::STATUS_DRAFT)<a style="font-size:14px" href="{{ url($space->uri . '/preview') }}" target="_blank">{{ trans('template_spaces.preview') }}</a>@endif</span>
                            </div>
                            @endif
                        </td>
                        <td>{{ $space->theme_name }}</td>
                        <td>{{ $space->author }}</td>
                        <td>{{ date_format($space->updated_at, 'Y/m/d') }}<br>{{ ucfirst($space->status) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>

        <nav class="text-right">
            @if (Route::currentRouteName() == 'spaces_all')
            <span style="color:#999999;font-style:italic;margin-right:10px;">{{ $number_spaces_all }} {{ str_plural('item', $number_spaces_all) }}</span>
            <a href="{{ route('spaces_all') . '?page=1' }}" class="btn btn-default" aria-label="Previous"><span aria-hidden="true">&lt;&lt;</span></a>
            <a href="{{ $spaces->previousPageUrl() }}" class="btn btn-default" aria-label="Previous"><span aria-hidden="true">&lt;</span></a>
            <span style="margin: 0 10px 0 10px">{{ $spaces->currentPage() }} of {{ $spaces->lastPage() }}</span> 
            <a href="{{ $spaces->nextPageUrl() }}" class="btn btn-default" aria-label="Next"><span aria-hidden="true">&gt;</span></a>
            <a href="{{ route('spaces_all') . '?page=' . $spaces->lastPage() }}" class="btn btn-default" aria-label="Next"><span aria-hidden="true">&gt;&gt;</span></a>
            @elseif (Route::currentRouteName() == 'spaces_published')
            <span style="color:#999999;font-style:italic;margin-right:10px;">{{ $number_spaces_published }} {{ trans('template_spaces.items') }}</span>
            <a href="{{ route('spaces_published') . '?page=1' }}" class="btn btn-default" aria-label="Previous"><span aria-hidden="true">&lt;&lt;</span></a>
            <a href="{{ $spaces->previousPageUrl() }}" class="btn btn-default" aria-label="Previous"><span aria-hidden="true">&lt;</span></a>
            <span style="margin: 0 10px 0 10px">{{ $spaces->currentPage() }} of {{ $spaces->lastPage() }}</span> 
            <a href="{{ $spaces->nextPageUrl() }}" class="btn btn-default" aria-label="Next"><span aria-hidden="true">&gt;</span></a>
            <a href="{{ route('spaces_published') . '?page=' . $spaces->lastPage() }}" class="btn btn-default" aria-label="Next"><span aria-hidden="true">&gt;&gt;</span></a>
            @elseif (Route::currentRouteName() == 'spaces_deleted')
            <span style="color:#999999;font-style:italic;margin-right:10px;">{{ $number_spaces_deleted }} {{ trans('template_spaces.items') }}</span>
            <a href="{{ route('spaces_deleted') . '?page=1' }}" class="btn btn-default" aria-label="Previous"><span aria-hidden="true">&lt;&lt;</span></a>
            <a href="{{ $spaces->previousPageUrl() }}" class="btn btn-default" aria-label="Previous"><span aria-hidden="true">&lt;</span></a>
            <span style="margin: 0 10px 0 10px">{{ $spaces->currentPage() }} of {{ $spaces->lastPage() }}</span> 
            <a href="{{ $spaces->nextPageUrl() }}" class="btn btn-default" aria-label="Next"><span aria-hidden="true">&gt;</span></a>
            <a href="{{ route('spaces_deleted') . '?page=' . $spaces->lastPage() }}" class="btn btn-default" aria-label="Next"><span aria-hidden="true">&gt;&gt;</span></a>
            @endif
        </nav>

        </div>

    </div> <!-- end row //-->

    {!! Form::close() !!}

@endsection
