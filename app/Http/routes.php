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
	if (config('app.disable_login') === false) {
  		Route::auth();
	}

  /**
   * Auth middleware protected
   */
  Route::get('admin', ['as' => 'dashboard', 'uses' => 'Admin\DashboardController@index']);
  Route::post('admin/dashboard/news', ['as' => 'dashboard_news', 'uses' => 'Admin\DashboardController@submit_dashboard_news']);

  Route::get('admin/user/{user_id}/edit', ['as' => 'edit_user_profile', 'uses' => 'Admin\UserProfileController@edit']);
  Route::post('admin/user/{user_id}/save', ['as' => 'save_user_profile', 'uses' => 'Admin\UserProfileController@save']);

  Route::get('admin/space/add/select-theme', ['as' => 'space_add_select_theme', 'uses' => 'Admin\SpaceAddController@select_theme']);
  Route::post('admin/space/add/select-theme', ['as' => 'space_add_select_theme_submit', 'uses' => 'Admin\SpaceAddController@select_theme_submit']);

  /* space add */
  Route::get('admin/space/add', ['as' => 'space_add', 'uses' => 'Admin\SpaceAddController@space_add']);
  Route::post('admin/space/add', ['as' => 'space_add_submit', 'uses' => 'Admin\SpaceAddController@space_add_submit']);
  Route::post('admin/space/add/{contenttype}/add', ['as' => 'space_add_content_add_submit', 'uses' => 'Admin\SpaceAddController@space_add_content_add_submit']);

  /* space edit */
  Route::get('admin/space/{id}/edit', ['as' => 'space_edit', 'uses' => 'Admin\SpaceEditController@space_edit']);
  Route::post('admin/space/{id}/edit', ['as' => 'space_edit_submit', 'uses' => 'Admin\SpaceEditController@space_edit_submit']);
  Route::post('admin/space/{id}/edit/{contenttype}/add', ['as' => 'space_edit_content_add_submit', 'uses' => 'Admin\SpaceEditController@space_edit_content_add_submit']);

  /* space content weight order */
  Route::post('admin/space/{space_id}/weight-order', ['as' => 'content_weight_order', 'uses' => 'Admin\SpaceContentEditController@content_weight_order_submit']);

  /* space content add */
  Route::get('admin/space/{id}/edit/{contenttype}/add', ['as' => 'content_add', 'uses' => 'Admin\SpaceContentAddController@content_add']);
  Route::post('admin/space/{id}/edit/{contenttype}/add', ['as' => 'content_add_submit', 'uses' => 'Admin\SpaceContentAddController@content_add_submit']);

  /* space content edit */
  Route::get('admin/space/{space_id}/edit/{contenttype}/{content_id}/edit', ['as' => 'content_edit', 'uses' => 'Admin\SpaceContentEditController@content_edit']);
  Route::post('admin/space/{space_id}/edit/{contenttype}/{content_id}/edit', ['as' => 'content_edit_submit', 'uses' => 'Admin\SpaceContentEditController@content_edit_submit']);

  /* space content delete */
  Route::get('admin/space/{space_id}/edit/{contenttype}/{content_id}/delete', ['as' => 'content_delete', 'uses' => 'Admin\SpaceContentEditController@content_delete']);
  Route::post('admin/space/{space_id}/edit/{contenttype}/{content_id}/delete', ['as' => 'content_delete_submit', 'uses' => 'Admin\SpaceContentEditController@content_delete_submit']);


  /* space content field type specific routes */
  Route::get('admin/space/{space_id}/edit/{contenttype}/positions/subject/{subject_type}/{subject_id?}', ['as' => 'fieldtype_position', 'uses' => 'Admin\FieldTypePositionController@positions_subject']); 
  Route::get('admin/space/{space_id}/edit/{contenttype}/rotation/subject/{subject_type}/{subject_id?}', ['as' => 'fieldtype_rotation', 'uses' => 'Admin\FieldTypeRotationController@rotation_subject']); 


  Route::get('admin/space/{id}/trash', ['as' => 'space_trash', 'uses' => 'Admin\SpacesController@space_trash']);
  Route::get('admin/space/{id}/delete', ['as' => 'space_delete', 'uses' => 'Admin\SpacesController@space_delete']);
  Route::get('admin/space/{id}/restore', ['as' => 'space_restore', 'uses' => 'Admin\SpacesController@space_restore']);


  /**
   * Themes
   */  
  Route::get('admin/themes', ['as' => 'themes', 'uses' => 'Admin\ThemesController@index']);
  Route::post('admin/themes', ['as' => 'themes', 'uses' => 'Admin\ThemesController@submit']);
  Route::get('admin/themes/all', ['as' => 'themes_all_json', 'uses' => 'Admin\ThemesController@themes_all_json']);


  /**
   * Asset library
   */  
  Route::get('admin/assets', ['as' => 'assets', 'uses' => 'Admin\AssetLibraryController@index']);

  Route::get('admin/assets/images', ['as' => 'asset_library_images', 'uses' => 'Admin\AssetLibraryImagesController@index']);
  Route::post('admin/assets/images/add', ['as' => 'asset_library_add_images', 'uses' => 'Admin\AssetLibraryImagesController@add_images']);
  Route::get('admin/assets/images/get-localization-strings', ['as' => 'asset_library_get_localization_strings', 'uses' => 'Admin\AssetLibraryImagesController@get_localization_strings']);
  Route::get('admin/assets/image/{image_id}/edit', ['as' => 'asset_library_image_edit', 'uses' => 'Admin\AssetLibraryImagesController@image_edit']);
  Route::post('admin/assets/image/{image_id}/save', ['as' => 'asset_library_image_save', 'uses' => 'Admin\AssetLibraryImagesController@image_edit_save']);
  Route::post('admin/assets/image/{image_id}/delete', ['as' => 'asset_library_image_delete', 'uses' => 'Admin\AssetLibraryImagesController@image_edit_delete']);
  Route::get('admin/assets/image/{image_id}/vr-view', ['as' => 'asset_library_image_vr_view', 'uses' => 'Admin\AssetLibraryImagesController@image_vr_view']);

  Route::get('admin/assets/photospheres', ['as' => 'asset_library_photospheres', 'uses' => 'Admin\AssetLibraryPhotospheresController@index']);
  Route::post('admin/assets/photospheres/add', ['as' => 'asset_library_add_photospheres', 'uses' => 'Admin\AssetLibraryPhotospheresController@add_photospheres']);
  Route::get('admin/assets/photospheres/get-localization-strings', ['as' => 'asset_library_get_localization_strings', 'uses' => 'Admin\AssetLibraryPhotospheresController@get_localization_strings']);
  Route::get('admin/assets/photosphere/{photosphere_id}/edit', ['as' => 'asset_library_photosphere_edit', 'uses' => 'Admin\AssetLibraryPhotospheresController@photosphere_edit']);
  Route::post('admin/assets/photosphere/{photosphere_id}/save', ['as' => 'asset_library_photosphere_save', 'uses' => 'Admin\AssetLibraryPhotospheresController@photosphere_edit_save']);
  Route::post('admin/assets/photosphere/{photosphere_id}/delete', ['as' => 'asset_library_photosphere_delete', 'uses' => 'Admin\AssetLibraryPhotospheresController@photosphere_edit_delete']);
  Route::get('admin/assets/photosphere/{photosphere_id}/vr-view', ['as' => 'asset_library_photosphere_vr_view', 'uses' => 'Admin\AssetLibraryPhotospheresController@photosphere_vr_view']);

  Route::get('admin/assets/videos', ['as' => 'asset_library_videos', 'uses' => 'Admin\AssetLibraryVideosController@index']);
  Route::post('admin/assets/videos/add', ['as' => 'asset_library_add_videos', 'uses' => 'Admin\AssetLibraryVideosController@add_videos']);
  Route::get('admin/assets/videos/get-localization-strings', ['as' => 'asset_library_get_localization_strings', 'uses' => 'Admin\AssetLibraryVideosController@get_localization_strings']);
  Route::get('admin/assets/video/{video_id}/edit', ['as' => 'asset_library_video_edit', 'uses' => 'Admin\AssetLibraryVideosController@video_edit']);
  Route::post('admin/assets/video/{video_id}/save', ['as' => 'asset_library_video_save', 'uses' => 'Admin\AssetLibraryVideosController@video_edit_save']);
  Route::post('admin/assets/video/{video_id}/delete', ['as' => 'asset_library_video_delete', 'uses' => 'Admin\AssetLibraryVideosController@video_edit_delete']);
  Route::get('admin/assets/video/{video_id}/vr-view', ['as' => 'asset_library_video_vr_view', 'uses' => 'Admin\AssetLibraryVideosController@video_vr_view']);

  Route::get('admin/assets/videospheres', ['as' => 'asset_library_videospheres', 'uses' => 'Admin\AssetLibraryVideospheresController@index']);
  Route::post('admin/assets/videospheres/add', ['as' => 'asset_library_add_videospheres', 'uses' => 'Admin\AssetLibraryVideospheresController@add_videospheres']);
  Route::get('admin/assets/videospheres/get-localization-strings', ['as' => 'asset_library_get_localization_strings', 'uses' => 'Admin\AssetLibraryVideospheresController@get_localization_strings']);
  Route::get('admin/assets/videosphere/{videosphere_id}/edit', ['as' => 'asset_library_videosphere_edit', 'uses' => 'Admin\AssetLibraryVideospheresController@videosphere_edit']);
  Route::post('admin/assets/videosphere/{videosphere_id}/save', ['as' => 'asset_library_videosphere_save', 'uses' => 'Admin\AssetLibraryVideospheresController@videosphere_edit_save']);
  Route::post('admin/assets/videosphere/{videosphere_id}/delete', ['as' => 'asset_library_videosphere_delete', 'uses' => 'Admin\AssetLibraryVideospheresController@videosphere_edit_delete']);
  Route::get('admin/assets/videosphere/{videosphere_id}/vr-view', ['as' => 'asset_library_videosphere_vr_view', 'uses' => 'Admin\AssetLibraryVideospheresController@videosphere_vr_view']);

  Route::get('admin/assets/audio', ['as' => 'asset_library_audio', 'uses' => 'Admin\AssetLibraryAudioController@index']);
  Route::post('admin/assets/audio/add', ['as' => 'asset_library_add_audio', 'uses' => 'Admin\AssetLibraryAudioController@add_audio']);
  Route::get('admin/assets/audio/get-localization-strings', ['as' => 'asset_library_get_localization_strings', 'uses' => 'Admin\AssetLibraryAudioController@get_localization_strings']);
  Route::get('admin/assets/audio/{audio_id}/edit', ['as' => 'asset_library_audio_edit', 'uses' => 'Admin\AssetLibraryAudioController@audio_edit']);
  Route::post('admin/assets/audio/{audio_id}/save', ['as' => 'asset_library_audio_save', 'uses' => 'Admin\AssetLibraryAudioController@audio_edit_save']);
  Route::post('admin/assets/audio/{audio_id}/delete', ['as' => 'asset_library_audio_delete', 'uses' => 'Admin\AssetLibraryAudioController@audio_edit_delete']);

  Route::get('admin/assets/models', ['as' => 'asset_library_models', 'uses' => 'Admin\AssetLibraryModelsController@index']);
  Route::post('admin/assets/models/add', ['as' => 'asset_library_add_model', 'uses' => 'Admin\AssetLibraryModelsController@add_models']);
  Route::get('admin/assets/models/get-localization-strings', ['as' => 'asset_library_get_localization_strings', 'uses' => 'Admin\AssetLibraryModelsController@get_localization_strings']);
  Route::get('admin/assets/model/{model_id}/get-model-preview-code', ['as' => 'asset_library_model_get_model_preview_code', 'uses' => 'Admin\AssetLibraryModelsController@get_model_preview_code']);

  /* both routes are needed */
  Route::get('admin/assets/model/{model_id}/edit', ['as' => 'asset_library_model_edit', 'uses' => 'Admin\AssetLibraryModelsController@model_edit']);
  Route::get('admin/assets/model/{field_key}/{content_id}/{model_id}/edit', ['as' => 'asset_library_model_edit', 'uses' => 'Admin\AssetLibraryModelsController@model_edit']);

  Route::post('admin/assets/model/{model_id}/save', ['as' => 'asset_library_model_save', 'uses' => 'Admin\AssetLibraryModelsController@model_edit_save']);
  Route::post('admin/assets/model/{model_id}/delete', ['as' => 'asset_library_model_delete', 'uses' => 'Admin\AssetLibraryModelsController@model_edit_delete']);
  Route::get('admin/assets/model/{model_id}/vr-view', ['as' => 'asset_library_model_vr_view', 'uses' => 'Admin\AssetLibraryModelsController@model_vr_view']);
  Route::post('admin/assets/model/save-image', ['as' => 'asset_library_model_save_image', 'uses' => 'Admin\AssetLibraryModelsController@save_image']);


  /**
   * Spaces
   */
  Route::get('admin/spaces/all', ['as' => 'spaces_all', 'uses' => 'Admin\SpacesController@spaces_all']);
  Route::get('admin/spaces/published', ['as' => 'spaces_published', 'uses' => 'Admin\SpacesController@spaces_published']);
  Route::get('admin/spaces/deleted', ['as' => 'spaces_deleted', 'uses' => 'Admin\SpacesController@spaces_deleted']);


  /**
   * Settings
   */
  Route::get('admin/settings/general', ['as' => 'general_settings', 'uses' => 'Admin\Settings\GeneralSettingsController@index']);
  Route::post('admin/settings/general', ['as' => 'general_settings', 'uses' => 'Admin\Settings\GeneralSettingsController@save']);
  Route::get('admin/settings/space', ['as' => 'space_settings', 'uses' => 'Admin\Settings\SpaceSettingsController@index']);
  Route::post('admin/settings/space', ['as' => 'space_settings', 'uses' => 'Admin\Settings\SpaceSettingsController@save']);


  /**
   * Installation
   */
  Route::get('install', ['as' => 'server_requirements', 'uses' => 'InstallationController@server_requirements']);
  Route::post('install', ['as' => 'server_requirements_submit', 'uses' => 'InstallationController@server_requirements_submit']);
  Route::get('install-db', ['as' => 'install_db', 'uses' => 'InstallationController@install_db']);
  Route::post('install-db', ['as' => 'install_db_submit', 'uses' => 'InstallationController@install_db_submit']);
  Route::get('install-user-config', ['as' => 'install_user_config', 'uses' => 'InstallationController@install_user_config']);
  Route::post('install-user-config', ['as' => 'install_user_config_submit', 'uses' => 'InstallationController@install_user_config_submit']);


  /**
   * Preview Space and JSON GET endpoint.
   *
   * Not auth middleware protected.
   */
  Route::get('{space_uri}/preview/content/{contenttype_key}', ['as' => 'preview_content_json', 'uses' => 'ViewSpaceController@preview_content_json']);
  Route::get('{space_uri}/preview/content-id/{content_id}', ['as' => 'preview_content_id_json', 'uses' => 'ViewSpaceController@preview_content_id_json']);
  Route::get('{space_uri}/preview', ['as' => 'preview_space', 'uses' => 'ViewSpaceController@preview_space']);
  Route::get('{space_uri}/{content_uri}/preview', ['as' => 'view_space_content', 'uses' => 'ViewSpaceController@preview_space_content']);

});


/**
 * View Published Space and JSON GET endpoint.
 *
 * Not auth middleware protected.
 */
Route::get('{space_uri}/content/{contenttype_key}', ['as' => 'content_json', 'uses' => 'ViewSpaceController@content_json']);
Route::get('{space_uri}/content-id/{content_id}', ['as' => 'content_id_json', 'uses' => 'ViewSpaceController@content_id_json']);
Route::get('{space_uri}', ['as' => 'view_space', 'uses' => 'ViewSpaceController@view_space']);
Route::get('{space_uri}/{content_uri}', ['as' => 'view_space_content', 'uses' => 'ViewSpaceController@view_space_content']);


