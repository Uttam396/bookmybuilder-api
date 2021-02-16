<?php

namespace App\Http\Controllers;
use App\Models\Staff;
use Request;
use Validator;
use Storage;

class StaffController extends Controller
{
    public function AddStaff(Request $request){

        $validator = Validator::make($request::all(), [
            'uid' => 'required|min:2|max:6',
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'phone'=> 'required',
            'email' => 'required|email',
            'user_type'=> 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'documents' => 'required',
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
            $password = request::Input('password'); 
            $confirm_password = request::Input('confirm_password'); 
            $documents = request::file('documents'); 
            $remarks = request::Input('remarks'); 
            $status = request::Input('status'); 

            if(request::hasFile('profile_picture')){
                $fileName1 = uniqid() . '.' . $profile_picture->getClientOriginalExtension();
                $fileDirectory1 = 'uploads';

                $s3 = \Storage::disk('s3');
                $fileLocation1 = $fileDirectory. '/' . $fileName1;
                $s3->put($fileLocation1, file_get_contents($profile_picture), 'public');
            }
            if(request::hasFile('documents')){
                $fileName2 = uniqid() . '.' . $documents->getClientOriginalExtension();
                $fileDirectory2 = 'uploads';

                $s3 = \Storage::disk('s3');
                $fileLocation2 = $fileDirectory2. '/' . $fileName2;
                $s3->put($fileLocation2, file_get_contents($documents), 'public');
            }


            // $uid = $request->uid;
            // $profile_picture = $request->profile_picture;
            // $name = $request->name;
            // $phone = $request->phone;
            // $email = $request->email;
            // $user_type = $request->user_type;
            // $password = $request->password;
            // $confirm_password = $request->confirm_password;
            // $documents = $request->documents;
            // $remarks = $request->remarks;
            // $status = $request->status;

            $staffdata = new Staff();
            $staffdata-> uid = $uid;
            
            if(isset($fileLocation1)){
                $staffdata->profile_picture = $fileLocation1;
            }
            $staffdata-> name = $name;
            $staffdata->phone = $phone;
            $staffdata->email = $email;
            $staffdata->user_type = $user_type;
            $staffdata->password = $password;
            $staffdata->confirm_password = $confirm_password;

            if(isset($fileLocation2)){
                $staffdata->documents = $fileLocation2;
            }
          
            $staffdata->remarks  = $remarks;
            $staffdata->status = $status;
            $staffdata->save();
            return $staffdata;
    
    }

    public function ViewStaff(Request $request){
        $viewstaffs = Staff::orderby('id','DESC')->get();
          return $viewstaffs;
    }

    public function StaffById(Request $request, $id){
         $singlestaff = Staff::find($id);
         if(is_null($singlestaff)) {
             return response()->json(['message' => 'Staff not Found'],404);
         }
         return response()->json($singlestaff::find($id), 200);
    }

    public function UpdateStaff(Request $request, $id){
        $updatestaff = Staff::find($id);
         if(is_null($updatestaff)) {
            return response()->json(['message' => 'Staff not Found'],404);
         }
         $updatestaff->update($request::all());
         return response($updatestaff, 200);
    }

    public function DeleteStaff(Request $request, $id){
        $deletestaff = Staff::find($id);
        if(is_null($deletestaff)) {
            return response()->json(['message' => 'Staff not Found'],404);
         }
         $deletestaff->delete();
         return response()->json(null,204);
    }
}
