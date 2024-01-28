<div class="sidebar">
    <nav class="sidebar-nav">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h3>{{ $logged_in_user->customer->customer_name }}</h3>
                    <p class="pb-2 text-muted">{{ $logged_in_user->email }}</p>
                    <hr>
                </div>

                <div class="col-12 mt-1">
                    <div class="d-flex justify-content-between">
                        <h5>{{ __('labels.general.sidebar.balance') }}</h5>
                        <h5>{{ \App\Helpers\General\MoneyHelper::toString($logged_in_user->customer->account) }} грн.</h5>
                    </div>
                    <hr>
                </div>

                <div class="col-12 mt-1">
                    <div class="d-flex justify-content-between">
                        <h6 class="py-2">{{ __('labels.general.sidebar.new_orders') }}</h6>
                        <h6 class="order-info py-2 bg-success text-dark">{{ $orders->new }}</h6>
                    </div>
                </div>

                <div class="col-12 mt-1">
                    <div class="d-flex justify-content-between">
                        <h6 class="py-2">{{ __('labels.general.sidebar.in_progress_orders') }}</h6>
                        <h6 class="order-info py-2 bg-warning text-dark">{{ $orders->in_progress }}</h6>
                    </div>
                </div>

                <div class="col-12 mt-1">
                    <div class="d-flex justify-content-between">
                        <h6 class="py-2">{{ __('labels.general.sidebar.delivered_orders') }}</h6>
                        <h6 class="order-info py-2 bg-primary text-dark">{{ $orders->delivered }}</h6>
                    </div>
                </div>

                <div class="col-12 mt-1">
                    <div class="d-flex justify-content-between">
                        <h6 class="py-2">{{ __('labels.general.sidebar.unpaid_orders') }}</h6>
                        <h6 class="order-info py-2 bg-danger text-dark">{{ $orders->not_paid }}</h6>
                    </div>
                    <hr>
                </div>
            </div>
        </div><!--card-body-->
    </nav><!--sidebar-nav-->
</div><!--sidebar-->
