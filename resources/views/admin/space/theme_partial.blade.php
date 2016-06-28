<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">{{ trans('template_space_add_edit.theme') }}</h3>
    </div>
    <div class="panel-body text-center">
        <img src="{{ $theme['theme-screenshot'] }}" class="img-responsive" alt="{{ $theme['theme-name'] }}">
        <h3 style="margin-top:20px">{{ $theme['theme-name'] }}</h3>
        <h5><strong>{{ trans('template_space_add_edit.version') }}</strong> {{ $theme['theme-version'] }}</h5>
        <h5><strong>{{ trans('template_space_add_edit.author') }}</strong> {{ $theme['theme-author-name'] }}</h5>
    </div>
</div>
