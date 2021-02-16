<?php

namespace App\Http\Controllers;
use Validator;
use Storage;
use Request;
use App\Models\Alerts;

class AlertController extends Controller
{
    public function AddAlert(Request $request){

        $validator = Validator::make($request::all(), [
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required',
            'posted_by' => 'required',
            'hyperlink' => 'required',
           
        ]);

           if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
           }

            $title = request::Input('title'); 
            $image = request::file('image'); 
            $description = request::Input('description');
            $posted_by = request::Input('posted_by');
            $hyperlink = request::Input('hyperlink'); 
           

            if(request::hasFile('image')){
                $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                $fileDirectory = 'uploads';

                $s3 = \Storage::disk('s3');
                $fileLocation = $fileDirectory. '/' . $fileName;
                $s3->put($fileLocation, file_get_contents($image), 'public');
            }
           

            $alertdata = new Alerts();
            $alertdata-> title = $title;
            
            if(isset($fileLocation)){
                $alertdata->image = $fileLocation;
            }
            $alertdata-> description = $description;
            $alertdata-> posted_by = $posted_by;
            $alertdata-> hyperlink = $hyperlink;
           
            $alertdata->save();
            return $alertdata;
    
    }

    public function ViewAlerts(Request $request){
        $viewalerts = Alerts::orderby('id','DESC')->get();
        return response()->json($viewalerts ,200 );
    }

    public function AlertById(Request $request, $id){
        $singlealert = Alerts::find($id);
         if(is_null($singlealert)) {
             return response()->json(['message' => 'Alerts not Found'],404);
         }
         return response()->json($singlealert::find($id), 200);
    }

    public function UpdateAlert(Request $request, $id){
        $updatealert = Alerts::find($id);
        if(is_null($updatealert)) {
           return response()->json(['message' => 'Alerts not Found'],404);
        }
        $updatealert->update($request::all());
        return response($updatealert, 200);
    }
    public function DeleteAlert(Request $request, $id){
        $deletealert = Alerts::find($id);
        if(is_null($deletealert)) {
            return response()->json(['message' => 'Alerts not Found'],404);
         }
         $deletealert->delete();
         return response()->json(null,204);
    }
}
