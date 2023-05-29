<?php

namespace App\Http\Controllers;

use App\Mail\ContactUsMail;
use App\Models\Gym;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Mail;

class HomeController extends Controller
{
    public function create()
    {
       /*  session()->flash('flash.type','floating');
        session()->flash('flash.level','success');
        session()->flash('flash.message','Email Sent Succesfully!');
 */
        return Inertia::render('Welcome',[
            'canLogin' => Route::has('login'),
            'gym' => Gym::select(['id','address','email','phone'])->where('id','1')->first()
        ]);
    }

    public function contactSendEmail(Request $request)
    {
        try{

            $attr = $request->validate([
                'name' => ['required','max:40','string'],
                'email' => ['required','email'],
                'message' => ['required','max:5000']
            ]);

            $sendToEmail = strtolower($attr['email']);
            
            Mail::to($sendToEmail)->send(new ContactUsMail($attr));
            
            if (Mail::flushMacros()) {
                //TODO flash message no se muestra despues de mandar el email o fallar 
                return back()->with([
                    'flash.type' => 'floating',
                    'flash.message' => 'Email Failed please try later.',
                    'flash.level' => 'danger'
                ]);
            }
            else
            {
                return back()->with([
                    'flash.level' => 'floating',
                    'flash.type' =>'success',
                    'flash.message' => 'Email Sent Succesfully!'
                ]);
            }

        }catch(Exception $e){
            return back()->with([
                'flash.level' => 'floating',
                'flash.type' =>'danger',
                'flash.message' => $e->getMessage()
            ]);
        }
       
    }
}
