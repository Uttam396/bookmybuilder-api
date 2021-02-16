<?php

namespace App\Http\Controllers;
use App\Models\Staff;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function Index(Request $request){
        // print_r('Om Shri Ganeshay Namah');
        $a = 'ऊँ गं गणपतये नम: ।।';
        print_r('एकदंताय विद्महे, वक्रतुण्डाय धीमहि, तन्नो दंती प्रचोदयात।। महाकर्णाय विद्महे, वक्रतुण्डाय धीमहि, तन्नो दंती प्रचोदयात।। गजाननाय विद्महे, वक्रतुण्डाय धीमहि, तन्नो दंती प्रचोदयात।।');
        return $a;
     }

     
}
