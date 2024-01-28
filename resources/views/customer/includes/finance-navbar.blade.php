<ul class="nav mb-4">
	<li class="nav-item">
		@if (Route::currentRouteName() === 'customer.finance.payments')
			<a class="btn btn-dark text-white">{{ __('menus.customer.finance.payments') }}</a>
		@else
			<a class="btn btn-link" href="{{ route('customer.finance.payments') }}">{{ __('menus.customer.finance.payments') }}</a>
		@endif
	</li>

	<li class="nav-item">
		@if (Route::currentRouteName() === 'customer.finance.invoices')
			<a class="btn btn-dark text-white">{{ __('menus.customer.finance.invoices') }}</a>
		@else
			<a class="btn btn-link" href="{{ route('customer.finance.invoices') }}">{{ __('menus.customer.finance.invoices') }}</a>
		@endif
	</li>

	<li class="nav-item">
		@if (Route::currentRouteName() === 'customer.finance.transactions')
			<a class="btn btn-dark text-white">{{ __('menus.customer.finance.transactions') }}</a>
		@else
			<a class="btn btn-link" href="{{ route('customer.finance.transactions') }}">{{ __('menus.customer.finance.transactions') }}</a>
		@endif
	</li>
</ul>
