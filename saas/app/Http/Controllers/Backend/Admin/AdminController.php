<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\BillingHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function profile()
    {
        $id = Auth::user()->id;
        $profile = User::find($id);

        return view('admin.profile', compact('profile'));
    }

    public function profileUpdate(Request $request)
    {
        $id = Auth::user()->id;
        $profile = User::find($id);

        // validete input request
        $request->validate([
            'name' => 'required|min:4',
            'email' => 'required|unique:users,email,'.$id,
            'address' => 'required',
            'phone' => 'required',
        ]);

        $profile->name = $request->name;
        $profile->email = $request->email;
        $profile->phone = $request->phone;
        $profile->address = $request->address;

        $oldPhotoPath = $profile->photo;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/admin_images/'), $fileName);
            $profile->photo = $fileName;

            if ($oldPhotoPath && $oldPhotoPath !== $fileName) {
                $this->deletePhoto($oldPhotoPath);
            }
        }
        $profile->save();

        $notification = [
            'type' => 'success',
            'message' => 'Admin profile updated successfully.'
        ];

        return redirect()->back()->with($notification);
    }

    public function changePassword()
    {
        return view('admin.change-password');
    }

    public function passwordUpdate(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if (! Hash::check($request->old_password, $user->password)) {
            $notification = [
                'type' => 'error',
                'message' => 'Old password does not match.'
            ];

            return redirect()->back()->with($notification);
        }

        User::find($user->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        Auth::logout();

        $notification = [
            'type' => 'success',
            'message' => 'Password updated successfully.'
        ];

        return redirect()->route('login')->with($notification);

    }

    public function orders()
    {
        $billingHistories = BillingHistory::orderBy('id', 'desc')->get();

        return view('admin.backend.order.all', compact('billingHistories'));
    }

    public function updateOrderStatus($id)
    {
        $billing = BillingHistory::findOrFail($id);
        $billing->status = 'Paid';
        $billing->save();

        $notification = [
            'type' => 'success',
            'message' => 'Billing Status updated successfully.'
        ];

        return redirect()->back()->with($notification);
    }

    private function deletePhoto(string $oldPhotoPath): void
    {
        $fullPath = public_path('upload/admin_images/' . $oldPhotoPath);

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}
