@extends('layouts.install_app')

@section('title', 'IdeaSpaceVR')

@section('content')

    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <h1>IdeaSpaceVR</h1>
        </div>
    </div>

    {!! Form::open(array('route' => 'server_requirements', 'method' => 'POST', 'autocomplete' => 'false', 'class' => 'form-horizontal')) !!}

		<input type="hidden" name="gd_imagick_code" value="{{ $gd_imagick_code }}">

    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <div class="panel panel-default">

                <div class="panel-body">

                    <div class="form-group">
                        <label class="col-sm-3 col-sm-offset-2 control-label"></label>
                        <div class="col-sm-4">
                        <h4>Checking System Requirements</h4>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-sm-offset-2 control-label">PHP Version</label>
                        <div class="col-sm-4">
                            {!! !in_array('phpversion', $errors)?'<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> PHP Version ' . $phpversion . ' installed</div>':'' !!}
                            {!! in_array('phpversion', $errors)?'<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Wrong PHP Version installed (' . $phpversion . '). PHP version >= ' . \App\Http\Controllers\InstallationController::REQUIRED_PHP_VERSION . ' is required.</div>':'' !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-sm-offset-2 control-label">OpenSSL PHP Extension</label>
                        <div class="col-sm-4">
                            {!! !in_array('openssl', $errors)?'<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> OpenSSL PHP Extension installed</div>':'' !!}
                            {!! in_array('openssl', $errors)?'<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> OpenSSL PHP Extension not installed</div>':'' !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-sm-offset-2 control-label">PDO PHP Extension</label>
                        <div class="col-sm-4">
                            {!! !in_array('pdo', $errors)?'<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> PDO PHP Extension installed</div>':'' !!}
                            {!! in_array('pdo', $errors)?'<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> PDO PHP Extension not installed</div>':'' !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-sm-offset-2 control-label">Fileinfo PHP Extension</label>
                        <div class="col-sm-4">
                            {!! !in_array('fileinfo', $errors)?'<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Fileinfo PHP Extension installed</div>':'' !!}
                            {!! in_array('fileinfo', $errors)?'<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Fileinfo PHP Extension not installed</div>':'' !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-sm-offset-2 control-label">Mbstring PHP Extension</label>
                        <div class="col-sm-4">
                            {!! !in_array('mbstring', $errors)?'<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Mbstring PHP Extension installed</div>':'' !!}
                            {!! in_array('mbstring', $errors)?'<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Mbstring PHP Extension not installed</div>':'' !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-sm-offset-2 control-label">Tokenizer PHP Extension</label>
                        <div class="col-sm-4">
                            {!! !in_array('tokenizer', $errors)?'<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Tokenizer PHP Extension installed</div>':'' !!}
                            {!! in_array('tokenizer', $errors)?'<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Tokenizer PHP Extension not installed</div>':'' !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-sm-offset-2 control-label">Storage Directory (./storage)</label>
                        <div class="col-sm-4">
                            {!! !in_array('storage_directory', $errors)?'<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Storage directory is writable by web server</div>':'' !!}
                            {!! in_array('storage_directory', $errors)?'<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Storage directory is not writable by web server. Please check your directory settings.</div>':'' !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-sm-offset-2 control-label">Cache Directory (./bootstrap/cache)</label>
                        <div class="col-sm-4">
                            {!! !in_array('bootstrap_cache_directory', $errors)?'<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Cache directory is writable by web server</div>':'' !!}
                            {!! in_array('bootstrap_cache_directory', $errors)?'<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cache directory is not writable by web server. Please check your directory settings.</div>':'' !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-sm-offset-2 control-label">Assets Directory (./public/assets/user)</label>
                        <div class="col-sm-4">
                            {!! !in_array('user_assets_directory', $errors)?'<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Assets directory is writable by web server</div>':'' !!}
                            {!! in_array('user_assets_directory', $errors)?'<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Assets directory and sub-directories are not writable by web server. Please check your directory settings.</div>':'' !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-sm-offset-2 control-label">Database Configuration (./config/database.php)</label>
                        <div class="col-sm-4">
                            {!! !in_array('config_database_file', $errors)?'<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Database configuration file is writable by web server</div>':'' !!}
                            {!! in_array('config_database_file', $errors)?'<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Database configuration file is not writable by web server. Please check your directory settings.</div>':'' !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-sm-offset-2 control-label">Application Configuration (./config/app.php)</label>
                        <div class="col-sm-4">
                            {!! !in_array('config_app_file', $errors)?'<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Application configuration file is writable by web server</div>':'' !!}
                            {!! in_array('config_app_file', $errors)?'<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Application configuration file is not writable by web server. Please check your directory settings.</div>':'' !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-sm-offset-2 control-label">Image Configuration (./config/image.php)</label>
                        <div class="col-sm-4">
                            {!! !in_array('config_image_file', $errors)?'<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Image configuration file is writable by web server</div>':'' !!}
                            {!! in_array('config_image_file', $errors)?'<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Image configuration file is not writable by web server. Please check your directory settings.</div>':'' !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-sm-offset-2 control-label">GD or ImageMagick PHP Extension</label>
                        <div class="col-sm-4">
                            {!! !in_array('gd_imagick', $errors)?'<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> ' . $gd_imagick . ' PHP Extension installed</div>':'' !!}
                            {!! in_array('gd_imagick', $errors)?'<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> GD or ImageMagick PHP Extension not installed</div>':'' !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 col-sm-offset-2 control-label"></label>
                        <div class="col-sm-4">
                            <button class="btn btn-primary" type="submit" @if (!empty($errors))disabled="disabled"@endif>Next</button>
                        </div>
                    </div>

                </div> <!-- end panel-body //-->

            </div><!-- end panel //-->

        </div>

    </div> <!-- end row //-->

    {!! Form::close() !!}

@endsection
