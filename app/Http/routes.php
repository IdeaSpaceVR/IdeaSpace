<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {

  Route::get('/', 'FrontpageController@index'); 

  /* handles login, lost password */
  Route::auth();

  /**
   * Auth middleware protected
   */
  Route::get('admin', ['as' => 'dashboard', 'uses' => 'Admin\DashboardController@index']);

  Route::get('admin/space/add/select-theme', ['as' => 'space_add_select_theme', 'uses' => 'Admin\SpaceController@select_theme']);
  Route::post('admin/space/add/select-theme', ['as' => 'space_add_select_theme_submit', 'uses' => 'Admin\SpaceController@select_theme_submit']);

  Route::get('admin/space/add', ['as' => 'space_add', 'uses' => 'Admin\SpaceController@space_add']);
  Route::post('admin/space/add', ['as' => 'space_add_submit', 'uses' => 'Admin\SpaceController@space_add_submit']);

  Route::get('admin/space/{id}/edit', ['as' => 'space_edit', 'uses' => 'Admin\SpaceController@space_edit']);
  Route::post('admin/space/{id}/edit', ['as' => 'space_edit_submit', 'uses' => 'Admin\SpaceController@space_edit_submit']);

  Route::get('admin/space/{id}/trash', ['as' => 'space_trash', 'uses' => 'Admin\SpaceController@space_trash']);
  Route::get('admin/space/{id}/delete', ['as' => 'space_delete', 'uses' => 'Admin\SpaceController@space_delete']);
  Route::get('admin/space/{id}/restore', ['as' => 'space_restore', 'uses' => 'Admin\SpaceController@space_restore']);

  /* make sure paths work on new spaces and space edits */
  Route::post('admin/space/{id}/media/images/add', ['as' => 'space_media_images_add', 'uses' => 'Admin\SpaceController@space_media_images_add']);
  Route::post('admin/space/media/images/add', ['as' => 'space_media_images_add', 'uses' => 'Admin\SpaceController@space_media_images_add']);
  Route::post('admin/space/{id}/media/images/delete', ['as' => 'space_media_images_delete', 'uses' => 'Admin\SpaceController@space_media_images_delete']);
  Route::post('admin/space/media/images/delete', ['as' => 'space_media_images_delete', 'uses' => 'Admin\SpaceController@space_media_images_delete']);

  /* one media ajax endpoint per control type */
  //Route::post('admin/space/add/config/media/image', ['as' => 'space_add_config_media_image_submit', 'uses' => 'Admin\SpaceController@config_media_image_submit']);
  //Route::post('admin/space/add/config/media/models', ['as' => 'space_add_config_media_models_submit', 'uses' => 'Admin\SpaceController@config_media_models_submit']);
  //Route::post('admin/space/add/config/media/model', ['as' => 'space_add_config_media_model_submit', 'uses' => 'Admin\SpaceController@config_media_model_submit']);
  //Route::post('admin/space/add/config/media/audio', ['as' => 'space_add_config_media_audio_submit', 'uses' => 'Admin\SpaceController@config_media_audio_submit']);
  //Route::post('admin/space/add/config/media/video', ['as' => 'space_add_config_media_video_submit', 'uses' => 'Admin\SpaceController@config_media_video_submit']);


  /**
   * Themes
   */  
  Route::get('admin/themes', ['as' => 'themes', 'uses' => 'Admin\ThemesController@index']);
  Route::post('admin/themes', ['as' => 'themes', 'uses' => 'Admin\ThemesController@submit']);


  /**
   * Media / Assets
   */  
  Route::get('admin/media', ['as' => 'media', 'uses' => function() {
    return view('admin.assets.assets');
  }]);


  /**
   * Spaces
   */
  Route::get('admin/spaces/all', ['as' => 'spaces_all', 'uses' => 'Admin\SpacesController@spaces_all']);
  Route::get('admin/spaces/published', ['as' => 'spaces_published', 'uses' => 'Admin\SpacesController@spaces_published']);
  Route::get('admin/spaces/deleted', ['as' => 'spaces_deleted', 'uses' => 'Admin\SpacesController@spaces_deleted']);

  /**
   * Preview Space and JSON GET endpoint.
   *
   * Not auth middleware protected.
   */
  Route::get('{uri}/preview/field-data', ['as' => 'preview_field_data_json', 'uses' => 'ViewSpaceController@preview_field_data_json']);
  Route::get('{uri}/preview', ['as' => 'view_space', 'uses' => 'ViewSpaceController@preview_space']);


  /**
   * Settings
   */
  Route::get('admin/settings/space', ['as' => 'space_settings', 'uses' => 'Admin\SpaceSettingsController@index']);
  Route::post('admin/settings/space', ['as' => 'space_settings', 'uses' => 'Admin\SpaceSettingsController@save']);



  /**
   * Installation
   */
  Route::get('install', ['as' => 'install', 'uses' => 'InstallationController@install']);
  Route::post('install', ['as' => 'install', 'uses' => 'InstallationController@install_submit']);

});


/**
 * View Published Space and JSON GET endpoint.
 *
 * Not auth middleware protected.
 */
Route::get('{uri}/field-data', ['as' => 'field_data_json', 'uses' => 'ViewSpaceController@field_data_json']);
Route::get('{uri}', ['as' => 'view_space', 'uses' => 'ViewSpaceController@view_space']);






