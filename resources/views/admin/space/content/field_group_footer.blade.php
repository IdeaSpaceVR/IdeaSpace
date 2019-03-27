				</div>
		</div>
</div>
<span class="info-block">@if (!is_null($theme['theme-key'])) {{ trans($theme['theme-key'] . '::' . $form['#help']) }} @else {{ $form['#help'] }} @endif</span>
