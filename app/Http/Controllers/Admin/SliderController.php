<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $images = Slider::get();
        return view('admin.slider.index' , compact('images'));
    }
    public function create()
    {
        return view('admin.slider.create');
    }
    public function storeFolder(Request $q)
    {
        return response() -> json (
			[
				'name' => move_img_by_Hash ('sliders' ,$q -> file ('img')),
        	]);
        return $q;
    }
    public function saveImgpathDB(Request $request)
    {
        try {
            // save dropzone images
            if ($request->has('imgs') && count($request->imgs) > 0) {
                foreach ($request->imgs as $image) {
                    Slider::create([
                        'img' => $image,
                    ]);
                }
            }

            return redirect()->route('admin.sliders')->with(['success' => 'تم الاضافة بنجاح']);

        } catch (\Exception $er) {
            return $er;
            return redirect()->route('admin.sliders')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);


        }
    }
    public function destroy($id)
    {
        try {
            $image = Slider::find($id) ;
            delete_file ('site/images/'.$image ->img);
             $image -> delete ();
            return redirect()->route('admin.sliders')->with(['success' => 'تم الحذف بنجاح']);

        }
        catch (\Exception $er)
        {
            return $er;
        return redirect()->route('admin.sliders')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }


    }
}
