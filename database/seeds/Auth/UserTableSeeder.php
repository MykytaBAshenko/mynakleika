<?php

use App\Models\Auth\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Class UserTableSeeder.
 */
class UserTableSeeder extends Seeder
{
	use DisableForeignKeys;

	/**
	 * Run the database seed.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->disableForeignKeys();

		// Add the master administrator, user id of 1
		User::create([
			'first_name'        => 'Admin',
			'last_name'         => 'Istrator',
			'email'             => 'admin@admin.com',
			'password'          => 'AHNIVDMJ6t1kUR6p',
			'confirmation_code' => md5(uniqid(mt_rand(), true)),
			'confirmed'         => true,
			'mobile'            => '+38 066 123 12 12',
            'api_token'         => Str::random(60),
		]);

		User::create([
			'first_name'        => 'Александр',
			'last_name'         => 'Башенко',
			'email'             => 'alex@bashenko.com',
			'password'          => 'T3V8lvZQFuyGqi6V',
			'confirmation_code' => md5(uniqid(mt_rand(), true)),
			'confirmed'         => true,
			'mobile'            => '+38 066 127 12 12',
            'api_token'         => Str::random(60),
		]);

		User::create([
			'first_name'        => 'Бухгалтер',
			'last_name'         => '',
			'email'             => 'buh@nakleika.com.ua',
			'password'          => '30xnF66QzAyCFvRn',
			'confirmation_code' => md5(uniqid(mt_rand(), true)),
			'confirmed'         => true,
			'mobile'            => '+38 066 133 12 12',
            'api_token'         => Str::random(60),
		]);

		User::create([
			'first_name'        => 'Dtp',
			'last_name'         => '',
			'email'             => 'dtp@nakleika.com.ua',
			'password'          => 'bJnaI8tXSyfDwj7S',
			'confirmation_code' => md5(uniqid(mt_rand(), true)),
			'confirmed'         => true,
			'mobile'            => '+38 066 153 12 12',
            'api_token'         => Str::random(60),
		]);

		$this->enableForeignKeys();
	}
}
