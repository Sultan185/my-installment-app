<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$user = User::firstOrNew(['email' => 'admin@gmail.com']);
		$user->name = 'admin';
		$user->password = Hash::make('123456');
		$user->save();
	}
}
