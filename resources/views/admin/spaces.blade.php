@extends('layouts.app')

@section('title', 'IdeaSpace')

@section('content')

    <h1>Spaces <a style="margin-left:20px;margin-bottom:6px;" class="btn btn-primary btn-sm" role="button" href="{{ route('space_add_select_theme') }}">Add New</a></h1>

    {!! Form::open(array('route' => 'spaces_all', 'method' => 'POST', 'autocomplete' => 'false')) !!}

    @if (session('alert-success'))
    <div class="row">
        <div class="col-md-9">
            <div class="alert alert-success">
            {!! session('alert-success') !!}
            </div>
        </div>
    </div>
    @endif

    <div class="row">

        <div class="col-md-12">

        <div>
            <a href="{{ route('spaces_all') }}">@if (Route::currentRouteName() == 'spaces_all') <span class="spaces selected">All</span> @else All @endif <span class="spaces @if (Route::currentRouteName() == 'spaces_all') selected @endif">({{ $number_spaces_all }})</span></a> | <a href="{{ route('spaces_published') }}">@if (Route::currentRouteName() == 'spaces_published') <span class="spaces selected">Published</span> @else Published @endif <span class="spaces @if (Route::currentRouteName() == 'spaces_published') selected @endif">({{ $number_spaces_published }})</span></a> | <a href="{{ route('spaces_deleted') }}">@if (Route::currentRouteName() == 'spaces_deleted') <span class="spaces selected">Trash</span> @else Trash @endif <span class="spaces @if (Route::currentRouteName() == 'spaces_deleted') selected @endif">({{ $number_spaces_deleted }})</span></a>
        </div>

        <div class="table-responsive">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width:3%"><input id="" type="checkbox" name="" value=""></th>
                        <th>Title</th>
                        <th style="width:30%">Theme</th>
                        <th style="width:10%">Author</th>
                        <th style="width:10%">Date</th>
                    </tr>
                </thead>
                <tbody>
                @if (count($spaces) == 0)
                  <tr>
                        <td colspan="5">There are no entries yet.</td>
                  </tr>
                @endif 
                @foreach ($spaces as $space)
                    <tr>
                        <td><input id="" type="checkbox" name="space[]" value=""></td>
                        <td class="space-title">
                            <div><a style="font-weight:bold;word-wrap:break-word;" href="{{ route('space_edit', ['id' => $space->id]) }}">{{ $space->title }}</a></div>
                            @if ($space->status == App\Space::STATUS_TRASH) 
                            <span class="space-actions"><a style="font-size:14px" href="{{ route('space_restore', ['id' => $space->id]) }}">Restore</a> <span style="font-size:14px;color:#999999">|</span> <a href="{{ route('space_delete', ['id' => $space->id]) }}" style="font-size:14px;color:#c9302c;">Delete Permanently</a> 
                            @else 
                            <div>
                            <span class="space-actions"><a style="font-size:14px" href="{{ route('space_edit', ['id' => $space->id]) }}">Edit</a> <span style="font-size:14px;color:#999999">|</span> <a href="{{ route('space_trash', ['id' => $space->id]) }}" style="font-size:14px;color:#c9302c;">Trash</a> <span style="font-size:14px;color:#999999;">|</span> @if ($space->status == App\Space::STATUS_PUBLISHED)<a style="font-size:14px" href="{{ url($space->uri) }}" target="_blank">View</a>@elseif ($space->status == App\Space::STATUS_DRAFT)<a style="font-size:14px" href="{{ url($space->uri . '/preview') }}" target="_blank">Preview</a>@endif</span>
                            </div>
                            @endif
                        </td>
                        <td>{{ $space->theme_title }}</td>
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
            <span style="color:#999999;font-style:italic;margin-right:10px;">{{ $number_spaces_published }} items</span>
            <a href="{{ route('spaces_published') . '?page=1' }}" class="btn btn-default" aria-label="Previous"><span aria-hidden="true">&lt;&lt;</span></a>
            <a href="{{ $spaces->previousPageUrl() }}" class="btn btn-default" aria-label="Previous"><span aria-hidden="true">&lt;</span></a>
            <span style="margin: 0 10px 0 10px">{{ $spaces->currentPage() }} of {{ $spaces->lastPage() }}</span> 
            <a href="{{ $spaces->nextPageUrl() }}" class="btn btn-default" aria-label="Next"><span aria-hidden="true">&gt;</span></a>
            <a href="{{ route('spaces_published') . '?page=' . $spaces->lastPage() }}" class="btn btn-default" aria-label="Next"><span aria-hidden="true">&gt;&gt;</span></a>
            @elseif (Route::currentRouteName() == 'spaces_deleted')
            <span style="color:#999999;font-style:italic;margin-right:10px;">{{ $number_spaces_deleted }} items</span>
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
