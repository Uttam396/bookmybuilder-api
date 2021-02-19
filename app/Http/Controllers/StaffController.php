<?php

namespace App\Http\Controllers;
use App\Models\User;
use Request;
use Validator;
use Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StaffController extends Controller
{
    public function AddStaff(Request $request){

        $validator = Validator::make($request::all(), [
            
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'phone'=> 'required|max:10',
            'email' => 'required|email',
            'user_type'=> 'required',
            'password' => 'required|min:6',
            'remarks' => 'required',
            'status' => 'required' 

        ]);

           if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
           }
            $uid = request::Input('uid'); 
            $profile_picture = request::file('profile_picture'); 
            $name = request::Input('name'); 
            $phone = request::Input('phone'); 
            $email = request::Input('email'); 
            $user_type = request::Input('user_type'); 
            $password = Hash::make(request::Input('password')); 
            $documents = request::file('documents'); 
            $remarks = request::Input('remarks'); 
            $status = request::Input('status'); 

            if(request::hasFile('profile_picture')){
                $fileName = uniqid() . '.' . $profile_picture->getClientOriginalExtension();
                $fileDirectory = 'uploads';

                $s3 = \Storage::disk('s3');
                $fileLocation = $fileDirectory. '/' . $fileName;
                $s3->put($fileLocation, file_get_contents($profile_picture), 'public');
            }
            // if(request::hasFile('documents')){
            //     $fileName2 = uniqid() . '.' . $documents->getClientOriginalExtension();
            //     $fileDirectory2 = 'uploads';

            //     $s3 = \Storage::disk('s3');
            //     $fileLocation2 = $fileDirectory2. '/' . $fileName2;
            //     $s3->put($fileLocation2, file_get_contents($documents), 'public');
            // }

            $staffdata = new User();
            
            if(isset($fileLocation)){
                $staffdata->profile_picture = $fileLocation;
            }
            $staffdata-> name = $name;
            $staffdata->phone = $phone;
            $staffdata->email = $email;
            $staffdata->user_type = $user_type;
            $staffdata->password = $password;
            $staffdata->remarks  = $remarks;
            $staffdata->status = $status;

            if(request::hasFile('documents'))
            {
                foreach($documents as $document)
                {

                    $fileName2 = uniqid() . '.' . $document->getClientOriginalExtension();
                    $fileDirectory2 = 'uploads';
                    $s3 = \Storage::disk('s3');
                    $fileLocation2 = $fileDirectory2. '/' . $fileName2;
                    $s3->put($fileLocation2, file_get_contents($document), 'public'); 
                    $doc_img = new DocumentImages;               
                    $doc_img->documents_url=$fileLocation2;
                    $doc_img->document_id= $staffdata->uid;
                    $doc_img->save();   
                }
               
            }
            $staffdata->save();

            return $staffdata;
    
    }

    public function ViewStaff(Request $request){
        $uid= request::input('uid');
        $viewstaffs = User::orderby('uid','DESC')->get();
        foreach($viewstaffs as $key=>$val){
            {
                $viewstaffs[$key]->profile_picture = 'https://bookmybuilder12.s3.ap-south-1.amazonaws.com/'.$viewstaffs[0]->profile_picture;
                $viewstaffs[$key]->documents = 'https://bookmybuilder12.s3.ap-south-1.amazonaws.com/'.$viewstaffs[0]->documents;
            }   
         }
       
          return $viewstaffs;
    }

    public function StaffById(Request $request, $uid){
         $singlestaff = User::find($uid);
         if(is_null($singlestaff)) {
             return response()->json(['message' => 'Staff not Found'],404);
         }
         return response()->json($singlestaff::find($uid), 200);
    }

    public function UpdateStaff(Request $request, $uid){
        $updatestaff = User::find($uid);
         if(is_null($updatestaff)) {
            return response()->json(['message' => 'Staff not Found'],404);
         }
         $updatestaff->update($request::all());
         return response($updatestaff, 200);
    }

    public function DeleteStaff(Request $request, $uid){
        $deletestaff = User::find($uid);
        if(is_null($deletestaff)) {
            return response()->json(['message' => 'Staff not Found'],404);
         }
         $deletestaff->delete();
         return response()->json(null,204);
    }
}
