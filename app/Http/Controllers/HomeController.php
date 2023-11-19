<?php

namespace App\Http\Controllers;

use App\Mail\ContactUsMail;
use App\Models\Gym;
use App\Models\Plan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Mail;

class HomeController extends Controller
{
    public function create()
    {
        return Inertia::render('Welcome',[
            'canLogin' => Route::has('login'),
            'gym' => Gym::select(['id','address','email','phone'])->where('id','1')->first(),
            'plans' => Plan::all()
        ]);
    }

    public function contactSendEmail(Request $request)
    {
        try{
            $attr = $request->validate([
                'name' => ['required','max:40','string'],
                'email' => ['required','email'],
            ]);

            $sendToEmail = strtolower($attr['email']);
            
            Mail::to($sendToEmail)->send(new ContactUsMail($attr));
            
            if (Mail::flushMacros()) {
                //TODO flash message no se muestra despues de mandar el email o fallar 
                return back()->with([
                    'level' => 'danger',
                    'message' => 'Email Failed please try later.'
                ]);
            }
            else
            {
                return back()->with([
                    'level' => 'success',
                    'message' => 'Email Sent Succesfully!'
                ]);
            }

        }catch(Exception $e){
            return back()->with([
                'level' => 'danger',
                'message' => $e->getMessage()
            ]);
        }
    }
}
