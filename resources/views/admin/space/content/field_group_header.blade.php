<div class="panel panel-default" style="margin-top:40px">
		<div class="panel-heading" role="tab" id="{{ $group_id }}-header" style="background-color:#FFFFFF;border-bottom-left-radius:3px;border-bottom-right-radius:3px">
				<h4 class="panel-title">	
						<a class="collapsed" style="font-size:18px;color:#0080e5;font-weight:bold" role="button" data-toggle="collapse" data-parent="#accordion" href="#{{ $group_id }}-collapse" aria-expanded="false" aria-controls="{{ $group_id }}-collapse">
						<span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span> @if (!is_null($theme['theme-key'])) {{ trans($theme['theme-key'] . '::' . $form['#title']) }} @else {{ $form['#title'] }} @endif
						</a>
				</h4>
		</div>
		<div id="{{ $group_id }}-collapse" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{ $group_id }}-header">
				<div class="panel-body">
