<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class HomeController extends Controller
{
    public function slider()
    {
        $slider = Slider::find(1);

        return view('admin.backend.slider.get_slider', compact('slider'));
    }

    public function update(Request $request)
    {
        ds($request->all());
        $id = $request->id;

        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $slider = Slider::findOrFail($id);

        if ($request->file('image')) {
            $image = $request->file('image');

            $manager = new ImageManager(new Driver());

            $nameGenerated = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            $img = $manager->read($image);
            $img->resize(1696, 729)->save(public_path('upload/slider/' . $nameGenerated));

            $saveUrl = 'upload/slider/' . $nameGenerated;

            if (file_exists(public_path($slider->image))) {
                @unlink(public_path($slider->image));
            }

            $slider->image = $saveUrl;
        }

        $slider->title = $request->title;
        $slider->description = $request->description;
        $slider->link = $request->link;
        $slider->save();

        $notification = [
            'type' => 'success',
            'message' => 'Slider updated successfully.'
        ];

        return redirect()->back()->with($notification);
    }
}
