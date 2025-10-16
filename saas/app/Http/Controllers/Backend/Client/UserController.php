<?php

namespace App\Http\Controllers\Backend\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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

        return view('client.profile', compact('profile'));
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
            $file->move(public_path('upload/user_images/'), $fileName);
            $profile->photo = $fileName;

            if ($oldPhotoPath && $oldPhotoPath !== $fileName) {
                $this->deletePhoto($oldPhotoPath);
            }
        }
        $profile->save();

        $notification = [
            'type' => 'success',
            'message' => 'User profile updated successfully.'
        ];

        return redirect()->back()->with($notification);
    }

    private function deletePhoto(string $oldPhotoPath): void
    {
        $fullPath = public_path('upload/user_images/' . $oldPhotoPath);

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}
