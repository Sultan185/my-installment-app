<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
	public function index()
	{
		$customers = Customer::orderByDesc('id')->paginate(10);
		return view('customers.index', compact('customers'));
	}

	public function create()
	{
		return view('customers.create');
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'national_id' => ['required', 'string', 'max:50', 'unique:customers,national_id'],
			'phone' => ['required', 'string', 'max:30'],
		]);

		Customer::create($validated);

		return redirect()->route('customers.index')->with('status', 'تم إنشاء العميل بنجاح');
	}

	public function edit(Customer $customer)
	{
		return view('customers.edit', compact('customer'));
	}

	public function update(Request $request, Customer $customer)
	{
		$validated = $request->validate([
			'name' => ['required', 'string', 'max:255'],
			'national_id' => ['required', 'string', 'max:50', 'unique:customers,national_id,' . $customer->id],
			'phone' => ['required', 'string', 'max:30'],
		]);

		$customer->update($validated);

		return redirect()->route('customers.index')->with('status', 'تم تحديث بيانات العميل');
	}

	public function destroy(Customer $customer)
	{
		$customer->delete();
		return redirect()->route('customers.index')->with('status', 'تم حذف العميل');
	}
}
