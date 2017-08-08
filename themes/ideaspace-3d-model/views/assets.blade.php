<a-assets>

    @if (isset($content['model']))

        @php
            $filetype = strtolower($content['model'][0]['model']['#model'][0]['#uri']['#filetype']);
        @endphp


        @if ($filetype == \App\Model3D::FILE_EXTENSION_GLTF)

            <a-asset-item class="model-asset" id="model-gltf" src="{{ $content['model'][0]['model']['#model'][0]['#uri']['#value'] }}"></a-asset-item>

        @elseif ($filetype == \App\Model3D::FILE_EXTENSION_GLB)

            <a-asset-item class="model-asset" id="model-glb" src="{{ $content['model'][0]['model']['#model'][0]['#uri']['#value'] }}"></a-asset-item>

        @elseif ($filetype == \App\Model3D::FILE_EXTENSION_DAE)

            <a-asset-item class="model-asset" id="model-dae" src="{{ $content['model'][0]['model']['#model'][0]['#uri']['#value'] }}"></a-asset-item>

        @elseif ($filetype == \App\Model3D::FILE_EXTENSION_OBJ)

            <a-asset-item class="model-asset" id="model-obj" src="{{ $content['model'][0]['model']['#model'][0]['#uri']['#value'] }}"></a-asset-item>
            <a-asset-item class="model-asset" id="model-mtl" src="{{ $content['model'][0]['model']['#model'][1]['#uri']['#value'] }}"></a-asset-item>

        @elseif ($filetype == \App\Model3D::FILE_EXTENSION_MTL)

            <a-asset-item class="model-asset" id="model-mtl" src="{{ $content['model'][0]['model']['#model'][0]['#uri']['#value'] }}"></a-asset-item>
            <a-asset-item class="model-asset" id="model-obj" src="{{ $content['model'][0]['model']['#model'][1]['#uri']['#value'] }}"></a-asset-item>

        @elseif ($filetype == \App\Model3D::FILE_EXTENSION_PLY)

            <a-asset-item class="model-asset" id="plyModel" src="{{ $content['model'][0]['model']['#model'][0]['#uri']['#value'] }}"></a-asset-item>

        @endif

    @endif

</a-assets>

