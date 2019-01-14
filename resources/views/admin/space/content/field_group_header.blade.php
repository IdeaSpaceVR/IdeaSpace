<div class="form-group">
		<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="{{ $group_id }}-header">
						<h4 class="panel-title">	
								<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#{{ $group_id }}-collapse" aria-expanded="false" aria-controls="{{ $group_id }}-collapse">
								<span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span> {{ $form['#title'] }}
								</a>
						</h4>
				</div>
				<div id="{{ $group_id }}-collapse" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{ $group_id }}-header">
						<div class="panel-body">
