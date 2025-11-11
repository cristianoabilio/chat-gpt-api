<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Heading;
use App\Models\Slider;
use Illuminate\Http\Request;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use PhpParser\Node\Expr\FuncCall;

class HomeController extends Controller
{
    public function slider()
    {
        $slider = Slider::find(1);

        return view('admin.backend.slider.get_slider', compact('slider'));
    }

    public function update(Request $request)
    {
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

    public function updateSlider(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);
        $slider->update($request->only(['title', 'description']));

        return response()->json([
            'success' => true,
            'message' => 'Updated successfully.'
        ]);
    }

    public function updateSliderImage(Request $request, $id)
    {
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
            $slider->save();

            return response()->json([
                'success' => true,
                'image_url' => asset($saveUrl),
                'message' => 'Updated successfully.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Updated failed.'
        ]);
    }

    public function updateHeading(Request $request, $id)
    {
        $heading = Heading::findOrFail($id);
        $heading->update($request->only(['title', 'description']));

        return response()->json([
            'success' => true,
            'message' => 'Updated successfully.'
        ]);
    }

    public function useCase()
    {
        return view('home.pages.body.use_case');
    }

    public function feature()
    {
        return view('home.pages.body.feature');
    }

    public function pricing()
    {
        return view('home.pages.body.pricing');
    }
}
