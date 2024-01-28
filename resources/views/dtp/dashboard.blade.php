@extends('dtp.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')

<div class="row mt-4">
	<div class="col-lg">
		<div class="card">
			<div class="card-body">
				<dtp-table-component />
			</div>
		</div>
	</div>
</div>

@endsection
