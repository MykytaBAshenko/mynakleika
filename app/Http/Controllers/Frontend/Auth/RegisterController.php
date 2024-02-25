<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Helpers\Frontend\Auth\Socialite;
use App\Events\Frontend\Auth\UserRegistered;
use App\Http\Requests\Frontend\Auth\RegisterRequest;
use App\Models\Customer;
use App\Models\Delivery;
use App\Services\OrderService;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Repositories\Frontend\Auth\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Throwable;

/**
 * Class RegisterController.
 */
class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * RegisterController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    public function redirectPath()
    {
        return route(home_route());
    }

    /**
     * Show the application registration form.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {

        return view('frontend.auth.register')
            ->withSocialiteLinks((new Socialite)->getSocialLinks());
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $user = $this->userRepository->create(
		    $request->only(
		        'first_name',
                'last_name',
                'email',
                'mobile',
                'password'
            )
        );
        /* @var Customer $customer */
		$customer = \App\Models\Customer::create([
            'user_id' => $user->id,
		]);

        $delivery = Delivery::where('type', Delivery::TYPE_PICKUP)->first();
        $customer->deliveries()->attach($delivery);

        if (!empty(session('order'))) {
            /* @var OrderService $orderService */
            $orderService = App::make(OrderService::class);
            $orderService->create(session('order'), $customer);
            session()->forget('order');
        }

        // If the user must confirm their email or their account requires approval,
        // create the account but don't log them in.
        if (config('access.users.confirm_email') || config('access.users.requires_approval')) {
            event(new UserRegistered($user));

            config('access.users.requires_approval') ?
                session()->flash('flash_success', __('exceptions.frontend.auth.confirmation.created_pending')) :
                session()->flash('flash_success', __('exceptions.frontend.auth.confirmation.created_confirm'));

            return response()->json( ['redirect' => route('frontend.auth.login')] );

        } else {
            auth()->login($user);

            event(new UserRegistered($user));

            return response()->json( ['redirect' => route('customer.dashboard')] );
        }
    }
}
