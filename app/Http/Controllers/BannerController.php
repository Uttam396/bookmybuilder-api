<?php

namespace App\Http\Controllers;
use App\Models\Banner;
use Request;
use Validator;
use Storage;

class BannerController extends Controller
{
    public function AddBanner(Request $request){

        $validator = Validator::make($request::all(), [
            'title' => 'required',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'hyperlink' => 'required',
           
        ]);

           if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
           }

            $title = request::Input('title'); 
            $banner_image = request::file('banner_image'); 
            $hyperlink = request::Input('hyperlink'); 
           

            if(request::hasFile('banner_image')){
                $fileName = uniqid() . '.' . $banner_image->getClientOriginalExtension();
                $fileDirectory = 'uploads';

                $s3 = \Storage::disk('s3');
                $fileLocation = $fileDirectory. '/' . $fileName;
                $s3->put($fileLocation1, file_get_contents($banner_image), 'public');
            }
           

            $bannerdata = new Banner();
            $bannerdata-> title = $title;
            
            if(isset($fileLocation)){
                $bannerdata->banner_image = $fileLocation;
            }
            $bannerdata-> hyperlink = $hyperlink;
           
            $bannerdata->save();
            return $bannerdata;
    
    }

    public function ViewBanner(Request $request){
        $viewbanners = Banner::orderby('id','DESC')->get();
        return $viewbanners;
    }

    public function BannerById(Request $request, $id){
        $singlebanner = Banner::find($id);
         if(is_null($singlebanner)) {
             return response()->json(['message' => 'Banner not Found'],404);
         }
         return response()->json($singlebanner::find($id), 200);
    }

    public function UpdateBanner(Request $request, $id){
        $updatebanner = Banner::find($id);
        if(is_null($updatebanner)) {
           return response()->json(['message' => 'Banner not Found'],404);
        }
        $updatebanner->update($request::all());
        return response($updatebanner, 200);
    }
    public function DeleteBanner(Request $request, $id){
        $deletebanner = Banner::find($id);
        if(is_null($deletebanner)) {
            return response()->json(['message' => 'Banner not Found'],404);
         }
         $deletebanner->delete();
         return response()->json(null,204);
    }
}
