<a-assets>
    <?php $count = ((count($content['images_upload']['data']) > 3)?3:count($content['images_upload']['data'])); ?>
    @for ($i = 0; $i < $count; $i++)
        <img src="{{ $content['images_upload']['data'][$i]['image'] }}" id="img-photosphere-{{ $i+1 }}">
        <img src="{{ $content['images_upload']['data'][$i]['image-thumbnail'] }}" id="img-photosphere-{{ $i+1 }}-thumb">
    @endfor
</a-assets>

