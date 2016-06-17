@if ($form['#type'] == App\Content\ContentType::FIELD_TYPE_IMAGE)
<button type="button" class="btn btn-primary btn-lg">{{ trans('template_asset_library.add_image') }}</button>
@elseif ($form['#type'] == App\Content\ContentType::FIELD_TYPE_AUDIO)
<button type="button" class="btn btn-primary btn-lg">{{ trans('template_asset_library.add_audio') }}</button>
@elseif ($form['#type'] == App\Content\ContentType::FIELD_TYPE_VIDEO)
<button type="button" class="btn btn-primary btn-lg">{{ trans('template_asset_library.add_video') }}</button>
@endif
