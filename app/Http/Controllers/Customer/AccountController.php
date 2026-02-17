<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function profile($status = null)
    {
        $customer = Auth::guard('customer')->user();

        // Get recent orders (last 3) for the dashboard overview
        $recentOrders = Order::where('customer_id', $customer->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Get all-time statistics
        $totalOrders = Order::where('customer_id', $customer->id)->count();
        $totalSpent = Order::where('customer_id', $customer->id)
            ->where('payment_status', 'paid')
            ->sum('grand_total');

        // Status Counts for filters
        $statusCounts = [
            'pending' => Order::where('customer_id', $customer->id)->where('status', 'pending')->count(),
            'confirmed' => Order::where('customer_id', $customer->id)->where('status', 'confirmed')->count(),
            'shipped' => Order::where('customer_id', $customer->id)->where('status', 'shipped')->count(),
            'delivered' => Order::where('customer_id', $customer->id)->where('status', 'delivered')->count(),
            'cancelled' => Order::where('customer_id', $customer->id)->where('status', 'cancelled')->count(),
        ];

        // Get orders with filtering and pagination for the "My Orders" tab
        $query = Order::where('customer_id', $customer->id)
            ->with(['items.variant.primaryImage.media', 'items.variant.images'])
            ->orderBy('created_at', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        $allOrders = $query->paginate(10);

        // Get wishlist count
        $wishlistCount = Wishlist::where('customer_id', $customer->id)->count();

        // Get addresses for the addresses tab
        $addresses = CustomerAddress::where('customer_id', $customer->id)
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.account.profile', compact(
            'customer',
            'recentOrders',
            'wishlistCount',
            'totalOrders',
            'totalSpent',
            'statusCounts',
            'allOrders',
            'addresses',
            'status'
        ));
    }

    public function updateProfile(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email,' . $customer->id,
            'mobile' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function addresses()
    {
        $customer = Auth::guard('customer')->user();
        $addresses = CustomerAddress::where('customer_id', $customer->id)
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.account.addresses', compact('customer', 'addresses'));
    }

    public function storeAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'mobile' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|size:2',
            'pincode' => 'required|string|max:20',
            'type' => 'required|in:shipping,billing,both',
            'is_default' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customer = Auth::guard('customer')->user();

        // If setting as default, unset other defaults
        if ($request->is_default) {
            CustomerAddress::where('customer_id', $customer->id)
                ->update(['is_default' => 0]);
        }

        CustomerAddress::create([
            'customer_id' => $customer->id,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'pincode' => $request->pincode,
            'type' => $request->type,
            'is_default' => $request->is_default ?? 0,
        ]);

        return redirect()->route('customer.account.addresses')
            ->with('success', 'Address added successfully!');
    }

    public function updateAddress(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'mobile' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|size:2',
            'pincode' => 'required|string|max:20',
            'type' => 'required|in:shipping,billing,both',
            'is_default' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customer = Auth::guard('customer')->user();
        $address = CustomerAddress::where('customer_id', $customer->id)
            ->where('id', $id)
            ->firstOrFail();

        // If setting as default, unset other defaults
        if ($request->is_default) {
            CustomerAddress::where('customer_id', $customer->id)
                ->where('id', '!=', $id)
                ->update(['is_default' => 0]);
        }

        $address->update([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'pincode' => $request->pincode,
            'type' => $request->type,
            'is_default' => $request->is_default ?? $address->is_default,
        ]);

        return redirect()->route('customer.account.addresses')
            ->with('success', 'Address updated successfully!');
    }

    public function deleteAddress($id)
    {
        $customer = Auth::guard('customer')->user();
        $address = CustomerAddress::where('customer_id', $customer->id)
            ->where('id', $id)
            ->firstOrFail();

        if ($address->is_default) {
            return redirect()->route('customer.account.addresses')
                ->with('error', 'Cannot delete default address. Set another address as default first.');
        }

        $address->delete();

        return redirect()->route('customer.account.addresses')
            ->with('success', 'Address deleted successfully!');
    }

    public function setDefaultAddress($id)
    {
        $customer = Auth::guard('customer')->user();

        CustomerAddress::where('customer_id', $customer->id)
            ->update(['is_default' => 0]);

        $address = CustomerAddress::where('customer_id', $customer->id)
            ->where('id', $id)
            ->firstOrFail();

        $address->update(['is_default' => 1]);

        return redirect()->route('customer.account.addresses')
            ->with('success', 'Default address updated successfully!');
    }

    public function changePassword()
    {
        $customer = Auth::guard('customer')->user();
        return view('customer.account.change-password', compact('customer'));
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customer = Auth::guard('customer')->user();

        // Check current password
        if (!Hash::check($request->current_password, $customer->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        // Update password
        $customer->password = Hash::make($request->password);
        $customer->password_changed_at = now();
        $customer->save();

        // You might want to add password history tracking here

        return redirect()->route('customer.account.change-password')
            ->with('success', 'Password updated successfully!');
    }
}
