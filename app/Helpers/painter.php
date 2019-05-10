<?php

function painter_head() {

		/* important for asset paths in build.js */
		echo '<script>window.ideaspace_site_path = "' . url('/') . '";</script>';

		echo '<script src="' . url('public/a-painter/vendor/aframe-input-mapping-component.js') . '"></script>';
    echo '<script src="' . url('public/a-painter/build.js') . '"></script>';
    echo '<script src="' . url('public/a-painter/vendor/aframe-teleport-controls.min.js') . '"></script>';
    echo '<script src="' . url('public/a-painter/vendor/aframe-tooltip-component.min.js') . '"></script>';
    echo '<link rel="stylesheet" href="' . url('public/a-painter/css/main.css') . '">';
    echo '<link rel="manifest" href="' . url('public/a-painter/manifest.webmanifest') . '">';
}


function painter_assets() {

		echo '<img id="uinormal" src="' . url('public/a-painter/assets/images/ui-normal.png') . '" crossorigin="anonymous">';
		echo '<img id="floor" src="' . url('public/a-painter/assets/images/floor.jpg') . '" crossorigin="anonymous">';
		echo '<a-asset-item id="logoobj" src="' . url('public/a-painter/assets/models/logo.obj') . '"></a-asset-item>';
		echo '<a-asset-item id="logomtl" src="' . url('public/a-painter/assets/models/logo.mtl') . '"></a-asset-item>';
		echo '<a-asset-item id="uiobj" src="' . url('public/a-painter/assets/models/ui.obj') . '"></a-asset-item>';
		echo '<a-asset-item id="hitEntityObj" src="' . url('public/a-painter/assets/models/teleportHitEntity.obj') . '"></a-asset-item>';
		echo '<audio id="ui_click0" src="' . url('public/a-painter/assetsr/sounds/ui_click0.ogg') . '" crossorigin="anonymous"></audio>';
		echo '<audio id="ui_click1" src="' . url('public/a-painter/assets/sounds/ui_click1.ogg') . '" crossorigin="anonymous"></audio>';
		echo '<audio id="ui_menu" src="' . url('public/a-painter/assets/sounds/ui_menu.ogg') . '" crossorigin="anonymous"></audio>';
		echo '<audio id="ui_undo" src="' . url('public/a-painter/assets/sounds/ui_undo.ogg') . '" crossorigin="anonymous"></audio>';
		echo '<audio id="ui_tick" src="' . url('public/a-painter/assets/sounds/ui_tick.ogg') . '" crossorigin="anonymous"></audio>';
		echo '<audio id="ui_paint" src="' . url('public/a-painter/assets/sounds/ui_paint.ogg') . '" crossorigin="anonymous"></audio>';
}


function painter_entities() {

		echo '<a-entity id="hitEntityLeft" material="shader:flat; color: #ff3468" obj-model="obj: #hitEntityObj"></a-entity>
      <a-entity id="hitEntityRight" material="shader:flat; color: #ff3468" obj-model="obj: #hitEntityObj"></a-entity>
      <a-entity id="cameraRig">
        <!-- camera -->
        <a-entity id="acamera" camera wasd-controls look-controls></a-entity>
        <!-- hand controls -->
        <a-entity id="left-hand"
                  brush
                  if-no-vr-headset="visible: false"
                  paint-controls="hand: left"
                  teleport-controls="cameraRig: #cameraRig; button: trackpad; @php /*ground: #ground;*/ @endphp hitCylinderColor: #ff3468; curveHitColor: #ff3468; curveMissColor: #333333; curveLineWidth: 0.01; hitEntity: #hitEntityLeft"
                  ui>
                    <a-entity class="vive-tooltips" visible="false">
                      <a-entity tooltip="text: Brush size\n(slide up/down); width: 0.1; height: 0.04; targetPosition: 0 0.016 0.0073; src: /public/a-painter/assets/images/tooltip.png"
                                position="0.1 0.025 0.048"
                                rotation="-90 0 0">
                      </a-entity>
                      <a-entity tooltip="text: Main menu; width: 0.07; height: 0.03; targetPosition: 0 -0.07 -0.062; lineHorizontalAlign: center; lineVerticalAlign: bottom; src: /public/a-painter/assets/images/tooltip.png"
                                position="0 0.015 -0.05"
                                rotation="-90 0 0">
                      </a-entity>
                      <a-entity tooltip="text: Press to paint\n(pressure sensitive); width: 0.11; height: 0.04; targetPosition: 0 -0.06 0.067; lineHorizontalAlign: right; src: /public/a-painter/assets/images/tooltip.png"
                                position="-0.11 -0.055 0.04"
                                rotation="-90 0 0">
                      </a-entity>
                      <a-entity tooltip="text: Undo; width: 0.06; height: 0.03; targetPosition: -0.003 0.046 0.106; src: /public/a-painter/assets/images/tooltip.png"
                                position="0.1 -0.005 0.12"
                                rotation="-90 0 0">
                      </a-entity>
                    </a-entity>
										<a-entity class="oculus-tooltips" visible="false">
                      <a-entity tooltip="text: Main Menu; width: 0.07; height: 0.03; targetPosition: -0.009 0.0 -0.002; rotation: -90 0 0; src: /public/a-painter/assets/images/tooltip.png"
                              position="0.066 0.013 0.013">
                      </a-entity>
                      <a-entity tooltip="text: Teleport; width: 0.06; height: 0.03; targetPosition: 0.008 0 -0.001; rotation: -90 0 0; src: /public/a-painter/assets/images/tooltip.png"
                          position="0.059 0.015 -0.028">
                      </a-entity>
                      <a-entity tooltip="text: Brush size\n(slide up/down); width: 0.09; height: 0.04; targetPosition: -0.009 0.01 -0.01; lineHorizontalAlign: center; lineVerticalAlign: top; rotation: -90 0 0; src: /public/a-painter/assets/images/tooltip.png"
                          position="-0.07 0.01 0.06">
                      </a-entity>
                      <a-entity tooltip="text: Press to paint!\n(pressure sensitive); width: 0.11; height: 0.04; targetPosition: 0.002 -0.023 -0.02; lineHorizontalAlign: right; rotation: -90 0 0; src: /public/a-painter/assets/images/tooltip.png"
                          position="-0.09 0.020 -0.067">
                      </a-entity>
                      <a-entity tooltip="text: Undo; width: 0.05; height: 0.03; targetPosition: 0.005 -0.022 0.027; rotation: -90 0 0; src: /public/a-painter/assets/images/tooltip.png"
                          position="0.058 -0.01 0.055">
                      </a-entity>
                    </a-entity>
                    <a-entity class="windows-motion-samsung-tooltips" visible="false">
                      <a-entity tooltip="text: Trigger to paint!; width: 0.1; height: 0.04; targetPosition: 0 -.3 -.1; lineHorizontalAlign: center; lineVerticalAlign: bottom; src: /public/a-painter/assets/images/tooltip.png"
                                position="0 -.1 -.2"
                                rotation="-90 0 0">
                      </a-entity>
                      <a-entity tooltip="text: Main menu; width: 0.07; height: 0.03; targetPosition: 0.005 -0.002 -.06; lineHorizontalAlign: right; src: /public/a-painter/assets/images/tooltip.png"
                                position="-0.1 0.02 -.05"
                                rotation="-90 0 0">
                      </a-entity>
                      <a-entity tooltip="text: Brush size\n(up/down); width: 0.11; height: 0.04; targetPosition: 0 -.09 -.1; lineHorizontalAlign: left; src: /public/a-painter/assets/images/tooltip.png"
                                position="0.2 0 -.11"
                                rotation="-90 0 0">
                      </a-entity>
                      <a-entity tooltip="text: Press to undo; width: 0.11; height: 0.03; targetPosition: 0 0 0; lineHorizontalAlign: left; src: /public/a-painter/assets/images/tooltip.png"
                                position="0.11 0 0"
                                rotation="-90 0 0">
                      </a-entity>
                    </a-entity>
										<a-entity class="windows-motion-tooltips" visible="false">
                      <a-entity tooltip="text: Trigger to paint!; width: 0.1; height: 0.04; targetPosition: 0 -.3 -.1; lineHorizontalAlign: center; lineVerticalAlign: bottom; src: /public/a-painter/assets/images/tooltip.png"
                                position="0 -.1 -.2"
                                rotation="-90 0 0">
                      </a-entity>
                      <a-entity tooltip="text: Main menu; width: 0.07; height: 0.03; targetPosition: 0.01 0.0025 -.06; lineHorizontalAlign: right; src: /public/a-painter/assets/images/tooltip.png"
                                position="-0.1 0.02 -.05"
                                rotation="-90 0 0">
                      </a-entity>
                      <a-entity tooltip="text: Brush size\n(up/down); width: 0.11; height: 0.04; targetPosition: 0 -.09 -.1; lineHorizontalAlign: left; src: /public/a-painter/assets/images/tooltip.png"
                                position="0.14 0 -.1"
                                rotation="-90 0 0">
                      </a-entity>
                      <a-entity tooltip="text: Press to undo; width: 0.11; height: 0.03; targetPosition: 0 0 0; lineHorizontalAlign: left; src: /public/a-painter/assets/images/tooltip.png"
                                position="0.11 0 0"
                                rotation="-90 0 0">
                      </a-entity>
                  </a-entity>
        </a-entity>

        <a-entity id="right-hand"
                  brush
                  if-no-vr-headset="visible: false"
                  paint-controls="hand: right"
                  teleport-controls="cameraRig: #cameraRig; button: trackpad; @php /*ground: #ground;*/ @endphp hitCylinderColor: #ff3468; curveHitColor: #ff3468; curveMissColor: #333333; curveLineWidth: 0.01; hitEntity: #hitEntityRight"
                  ui>
                    <a-entity class="vive-tooltips" visible="false">
                      <a-entity tooltip="text: Brush size\n(slide up/down); width: 0.1; height: 0.04; targetPosition: 0 0.016 0.0073; src: /public/a-painter/assets/images/tooltip.png"
                                position="0.1 0.025 0.048"
                                rotation="-90 0 0">
                      </a-entity>
											<a-entity tooltip="text: Main menu; width: 0.07; height: 0.03; targetPosition: 0 -0.07 -0.062; lineHorizontalAlign: center; lineVerticalAlign: bottom; src: /public/a-painter/assets/images/tooltip.png"
                                position="0 0.015 -0.05"
                                rotation="-90 0 0">
                      </a-entity>
                      <a-entity tooltip="text: Press to paint\n(pressure sensitive); width: 0.11; height: 0.04; targetPosition: 0 -0.06 0.067; lineHorizontalAlign: right; src: /public/a-painter/assets/images/tooltip.png"
                                position="-0.11 -0.055 0.04"
                                rotation="-90 0 0">
                      </a-entity>
                      <a-entity tooltip="text: Undo; width: 0.06; height: 0.03; targetPosition: -0.003 0.046 0.106; src: /public/a-painter/assets/images/tooltip.png"
                                position="0.1 -0.005 0.12"
                                rotation="-90 0 0">
                      </a-entity>
                    </a-entity>
                    <a-entity class="oculus-tooltips" visible="false">
                      <a-entity tooltip="text: Main Menu; width: 0.07; height: 0.03; targetPosition: 0.009 0.0 -0.002; rotation: -90 0 0; lineHorizontalAlign: right; src: /public/a-painter/assets/images/tooltip.png"
                          position="-0.066 0.013 0.013">
                      </a-entity>
                      <a-entity tooltip="text: Teleport; width: 0.06; height: 0.03; targetPosition: -0.008 0 -0.001; rotation: -90 0 0; lineHorizontalAlign: right; src: /public/a-painter/assets/images/tooltip.png"
                          position="-0.059 0.015 -0.028">
                      </a-entity>
                      <a-entity tooltip="text: Brush size\n(slide up/down); width: 0.09; height: 0.04; targetPosition: 0.009 0.01 -0.01; lineHorizontalAlign: center; lineVerticalAlign: top; rotation: -90 0 0; src: /public/a-painter/assets/images/tooltip.png"
                          position="0.07 0.01 0.06">
                      </a-entity>
                      <a-entity tooltip="text: Press to paint!\n(pressure sensitive); width: 0.11; height: 0.04; targetPosition: -0.002 -0.023 -0.02; lineHorizontalAlign: left; rotation: -90 0 0; src: /public/a-painter/assets/images/tooltip.png"
                          position="0.09 0.020 -0.067">
                      </a-entity>
                      <a-entity tooltip="text: Undo; width: 0.05; height: 0.03; targetPosition: -0.005 -0.022 0.027; rotation: -90 0 0; lineHorizontalAlign: right; src: /public/a-painter/assets/images/tooltip.png"
                          position="-0.058 -0.01 0.055">
                      </a-entity>
                    </a-entity>
										<a-entity class="windows-motion-samsung-tooltips" visible="false">
                      <a-entity tooltip="text: Trigger to paint!; width: 0.1; height: 0.04; targetPosition: 0 -.3 -.1; lineHorizontalAlign: center; lineVerticalAlign: bottom; src: /public/a-painter/assets/images/tooltip.png"
                                position="0 -.1 -.2"
                                rotation="-90 0 0">
                      </a-entity>
                      <a-entity tooltip="text: Main menu; width: 0.07; height: 0.03; targetPosition: -.01 -0.004 -.06; lineHorizontalAlign: left; src: /public/a-painter/assets/images/tooltip.png"
                                position="0.1 0.02 -.05"
                                rotation="-90 0 0">
                      </a-entity>
                      <a-entity tooltip="text: Brush size\n(up/down); width: 0.11; height: 0.04; targetPosition: 0 -.09 -.1; lineHorizontalAlign: right; src: /public/a-painter/assets/images/tooltip.png"
                                position="-0.19 -0.003 -.11"
                                rotation="-90 0 0">
                      </a-entity>
                      <a-entity tooltip="text: Press to undo; width: 0.11; height: 0.03; targetPosition: 0 0 0; lineHorizontalAlign: right; src: /public/a-painter/assets/images/tooltip.png"
                                position="-0.11 0 0"
                                rotation="-90 0 0">
                      </a-entity>
                    </a-entity>
                    <a-entity class="windows-motion-tooltips" visible="false">
                      <a-entity tooltip="text: Trigger to paint!; width: 0.1; height: 0.04; targetPosition: 0 -.3 -.1; lineHorizontalAlign: center; lineVerticalAlign: bottom; src: /public/a-painter/assets/images/tooltip.png"
                                position="0 -.1 -.2"
                                rotation="-90 0 0">
                      </a-entity>
                      <a-entity tooltip="text: Main menu; width: 0.07; height: 0.03; targetPosition: -.015 0.0025 -.06; lineHorizontalAlign: left; src: /public/a-painter/assets/images/tooltip.png"
                                position="0.1 0.02 -.05"
                                rotation="-90 0 0">
                      </a-entity>
                      <a-entity tooltip="text: Brush size\n(up/down); width: 0.11; height: 0.04; targetPosition: 0 -.09 -.1; lineHorizontalAlign: right; src: /public/a-painter/assets/images/tooltip.png"
                                position="-0.14 0 -.1"
                                rotation="-90 0 0">
                      </a-entity>
                      <a-entity tooltip="text: Press to undo; width: 0.11; height: 0.03; targetPosition: 0 0 0; lineHorizontalAlign: right; src: /public/a-painter/assets/images/tooltip.png"
                                position="-0.11 0 0"
                                rotation="-90 0 0">
                      </a-entity>
                    </a-entity>
        </a-entity>
      </a-entity>';
}


