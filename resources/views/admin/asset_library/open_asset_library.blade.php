@if ($form['#type'] == App\Content\ContentType::FIELD_TYPE_IMAGE)
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#assets" data-opentab="#images-tab">
    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> {{ trans('template_asset_library_images.add_image') }}
</button>
@elseif ($form['#type'] == App\Content\ContentType::FIELD_TYPE_AUDIO)
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#assets" data-opentab="#audio-tab">
    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> {{ trans('template_asset_library_audio.add_audio') }}
</button>
@elseif ($form['#type'] == App\Content\ContentType::FIELD_TYPE_VIDEO)
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#assets" data-opentab="#videos-tab">
    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> {{ trans('template_asset_library_videos.add_video') }}
</button>
@elseif ($form['#type'] == App\Content\ContentType::FIELD_TYPE_VIDEOSPHERE)
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#assets" data-opentab="#videospheres-tab">
    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> {{ trans('template_asset_library_videospheres.add_videosphere') }}
</button>
@elseif ($form['#type'] == App\Content\ContentType::FIELD_TYPE_PHOTOSPHERE)
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#assets" data-opentab="#photospheres-tab">
    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> {{ trans('template_asset_library_photospheres.add_photosphere') }}
</button>
@elseif ($form['#type'] == App\Content\ContentType::FIELD_TYPE_MODEL)
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#assets" data-opentab="#models-tab">
    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> {{ trans('template_asset_library_models.add_model') }}
</button>
@endif
