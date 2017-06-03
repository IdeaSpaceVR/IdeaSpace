## 1.0.2

- Bug fix: featured space on front page for anonymous user caused error 
- Updated IdeaSpace 360 theme: better looking annotations, improved desktop and mobile mode
- Added new IdeaSpace 3D Model theme
- Field type position: #content array uses now field keys
- Field type color: default color is black
- Allow *.tga textures for 3D models
- Texture image files are not renamed anymore after uploading, because it can break texture file reference in *.mtl files (and others)
- Stay on spaces deleted page after deleting a space

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
