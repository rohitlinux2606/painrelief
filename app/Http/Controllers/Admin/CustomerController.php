<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        // 🔍 Search: Name, Email, Phone
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        // ✅ Status Filter (Active / Inactive)
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $customers = $query->orderBy('id', 'DESC')
            ->paginate(15)
            ->withQueryString();

        return view('admin.pages.customers.index', compact('customers'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title      = "New Product";
        return view('admin.pages.customers.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'nullable|email|unique:customers,email',
            'phone'      => 'nullable|string|unique:customers,phone',
            'password'   => 'nullable|string|min:6|confirmed',
            'dob'        => 'nullable|date',
            'gender'     => 'nullable|in:male,female,other',
            'is_active'  => 'required|boolean',
        ]);

        try {
            $validated['password'] = $request->filled('password')
                ? bcrypt($request->password)
                : null;

            Customer::create($validated);

            return redirect()->route('admin.customer-control.customer.index')
                ->with('success', 'Customer created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title      = "Edit Customer Detail";
        $customer    = Customer::findOrFail($id);
        return view('admin.pages.customers.edit', compact('title', 'customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'nullable|email|unique:customers,email,' . $customer->id,
            'phone'      => 'nullable|string|unique:customers,phone,' . $customer->id,
            'password'   => 'nullable|string|min:6|confirmed',
            'dob'        => 'nullable|date',
            'gender'     => 'nullable|in:male,female,other',
            'is_active'  => 'required|boolean',
        ]);

        try {
            // Password update only if entered
            if ($request->filled('password')) {
                $validated['password'] = bcrypt($request->password);
            } else {
                unset($validated['password']);
            }

            $customer->update($validated);

            return redirect()->route('admin.customer-control.customer.index')
                ->with('success', 'Customer updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Customer::findOrFail($id)->delete();

            return redirect()->back()->with('success', 'Customer Deleted Successfully.');
        } catch (\Exception $e) {
            Log::error("Tour Delete Error: " . $e->getMessage());
            return back()->with('error', 'Something went wrong.');
        }
    }
}
