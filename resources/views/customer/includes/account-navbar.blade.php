<ul class="nav mb-4">
	<li class="nav-item">
		@if (Route::currentRouteName() === 'customer.profile.edit')
			<a class="btn btn-dark text-white">
				{{ __('menus.customer.profile.customer_profile') }}
			</a>
		@else
			<a class="btn btn-link" href="{{ route('customer.profile.edit') }}">
				{{ __('menus.customer.profile.customer_profile') }}
			</a>
		@endif
	</li>
	<li class="nav-item">
		@if (strpos(Route::currentRouteName(), 'legal_entities'))
			<a class="btn btn-dark text-white">
				{{ __('menus.customer.profile.legal_entities') }}
			</a>
		@else
			<a class="btn btn-link" href="{{ route('customer.legal_entities') }}">
				{{ __('menus.customer.profile.legal_entities') }}
			</a>
		@endif
	</li>
	<li class="nav-item">
		@if (strpos(Route::currentRouteName(), 'deliveries'))
			<a class="btn btn-dark text-white">
				{{ __('menus.customer.profile.deliveries') }}
			</a>
		@else
			<a class="btn btn-link" href="{{ route('customer.deliveries') }}">
				{{ __('menus.customer.profile.deliveries') }}
			</a>
		@endif
	</li>
</ul>
