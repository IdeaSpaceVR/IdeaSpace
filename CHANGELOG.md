# 1.1.5

- Added support for PostgreSQL databases
- Added page to edit user profile
- Added german translation files by Senuros (https://github.com/Senuros)
- Updated to A-Frame 0.8.2
- Added setting in conf/app.php: enable / disable lost password functionality 

# 1.1.4

- Small layout changes on the dashboard
- IdeaSpace 360 Photo Tour: removed number of photo sphere limitation; added logo

## 1.1.3

- IdeaSpace 3D model theme improvements: new teleportation allows to teleport onto 3D models; link to scene from within VR

## 1.1.2

- IdeaSpace Welcome theme bug fix: if Google Fonts are used and they need longer to load, the material HTML shader must be updated

## 1.1.1

- If content is referenced within a space, and if the referenced content is deleted, a warning is shown. If user decides to delete the content the reference is deleted as well (preventing internal server error in a space). 
- Theme: IdeaSpace 360: hotspots, all text characters are now working
- Theme: IdeaSpace 360 Photo Tour: hotspots, all text characters are now working; bug fix: image loading timeout if DOM not ready; hide controller models if not in VR mode
- Use Tinymce for rich text editor (field types: textinput and textarea); Medium editor deprecated
- Added support for animated GIF images 
- Configurable preview thumbnail images for content list
- Dynamically configure GD or Imagick image driver depending on PHP configuration
- Removed settings option for showing latest spaces on front page
- Upload photo spheres: added checkbox to decide if original image dimension should be kept 
- Upgraded to A-Frame 0.8.2
- New theme added: Welcome theme

## 1.1.0

- Introduced rotation field type 
- Introduced space reference field type 
- Corrected mandatory theme config fields
- Updated themes to reflect mandatory field type changes
- Updated IdeaSpace 360 Photo Tour theme in order to support precise positioning of info hotspots
- Added a REST endpoint to request space content by specifying the content id
- Settings: added fields to settings page for Origin Trial Token for Chrome to enable WebVR
- Added config/app.php parameter to disable user authentication
- Support tif / tiff texture files (3D models)
- Updated IdeaSpace 3D Model theme to better support Oculus Rift touch controllers
- Bug fix: language switch in Settings works now
- Upgraded to A-Frame 0.7.1
- Support for glTF 2.0 models added

## 1.0.4

- Small visual and text changes to general user interface
- IdeaSpace 360 theme: controller responsiveness improved on navigation and info hotspots
- IdeaSpace 360 theme: uses now A-Frame v0.7.0
- IdeaSpace 360 Photo Tour theme: controller responsiveness improved on navigation and info hotspots
- IdeaSpace 360 Photo Tour theme: uses now A-Frame v0.7.0
- Removed #theme-compatibility from theme config.php files
- Front page, latest spaces: show only one space at a time, due to performance implications of WebVR
- Bug fixes for IdeaSpace 360 and IdeaSpace 360 photo tour themes, see respective CHANGELOGS

## 1.0.3

- Bug fix IdeaSpace 3D Model theme: ply model hotspot annotations do not need rotation
- IdeaSpace 360 theme: better support for mouse on desktop / touch on mobile, better looking hotspots 
- IdeaSpace 3D Model theme: better support for mouse on desktop / touch on mobile, better looking hotspots
- Added new theme: IdeaSpace 360 Photo Tour
- Annoyance fix: do not reset camera position when selecting placeholder in field type position

## 1.0.2

- Bug fix: featured space on front page for anonymous user caused error 
- Updated IdeaSpace 360 theme: better looking annotations, Gear VR / Daydream controller support added
- Added new IdeaSpace 3D Model theme supporting Gear VR / Daydream with controller 
- Field type position: #content array uses now field keys
- Field type color: default color is black
- Allow *.tga textures for 3D models
- Texture image files are not renamed anymore after uploading, because it can break texture file reference in *.mtl files (and others)
- Stay on spaces deleted page after deleting a space
- Added #default_value for field type color (theme config.php)
- Updated to A-Frame v0.6.1
- glTF 3D models support added (types: embedded and binary, *.gltf and *.glb)
- Bugfix: prevent *.obj and *.mtl files from renaming after uploading
- Google Blocks 3D model support added

## 1.0.1

- Set x:0 y:-90 z:0 as default photo sphere rotation.
- New default themes: VR View 360 Image, VR View 360 Video, VR View 360 Image Gallery, VR View 360 Video Gallery.
- Bug fix: after uploading video, videosphere or audio files, insert link was not shown.
- Changed license to MIT license.

## 1.0.0

- Field types.
- Asset library.
- Complete rewrite of the system.
- field type textarea: #rows is of type number

## 0.3.2

- Major improvement of default photo sphere viewer theme.
- New default photo sphere theme: photo sphere diver.
- Fixed some bugs related to space URIs and existing / system URIs.

## 0.3.1

- Fixes a critical bug which prevented the installation of IdeaSpace in a sub-directory: eg. https://mydomain.com/sub
- The DB_PREFIX parameter in .env is working. It enables to have multiple IdeaSpace installations sharing the same database using different table prefixes.
- Added a temporary page for Media menu.

## 0.3.0  

- This is the initial public release of IdeaSpace.
- The focus of the initial release is on managing images and providing a basic photo sphere theme.
- Images which are uploaded are resized to fit the "power of two rule" for textures and thumbnail images are created for the navigation menu.
- The theme API is kept to a minimum at this release. The only implemented controls are images and text.
- There are two example themes shipped with this release: a photo sphere viewer and a hello world theme. 
- Published spaces can be embedded on external websites by using the embed code provided on the space edit page. IdeaSpace implements CORS (cross-origin resource sharing) in order to allow loading of assets from a different domain name.
- The front page features a list of latest published spaces or a single space (configure in "Settings").
