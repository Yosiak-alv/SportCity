<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\CreateEditSuscription;
use App\Models\Client;
use App\Models\Plan;
use App\Models\Suscription;
use App\Traits\SuscriptionTrait;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
class SuscriptionController extends Controller
{
    use SuscriptionTrait;
    public function __construct()
    {
        $this->authorizeResource(Suscription::class,'suscription');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('User/Suscriptions/Index',[
            'suscriptions' => Suscription::with('client:id,name','plan')->latest('created_at')
            ->filter(request(['search']))->paginate(5)->withQueryString(),
            'filters' => \Illuminate\Support\Facades\Request::only(['search']),
            'plans' => Plan::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('User/Suscriptions/CreateEditSuscription',[
            'clients' => Client::select(['id','name'])->get(),
            'plans' => Plan::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEditSuscription $request)
    {
        $attr = $request->validated();
        $plan = Plan::find($attr['plan_id']);
        $attr['user_id'] = request()->user()->id;
        $attr['ends_at'] = $plan->duration == 'Month' ? Carbon::now()->addMonth()->timezone('America/El_Salvador')->toDateTimeString()
        : Carbon::now()->addDay()->timezone('America/El_Salvador')->toDateTimeString();
        $suscription = Suscription::create($attr);
        
        return redirect()->route('suscriptions.show', $suscription->id)->with([
            'level' => 'success',
            'message' => 'Suscription Created Succesfully!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Suscription $suscription)
    {
        return Inertia::render('User/Suscriptions/Show',[
            'suscription' => $suscription->load(['client' , 'plan']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Suscription $suscription)
    {
        return Inertia::render('User/Suscriptions/CreateEditSuscription',[
            'clients' => Client::select(['id','name'])->get(),
            'plans' => Plan::all(),
            'suscription' => $suscription,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateEditSuscription $request, Suscription $suscription)
    {
        $attr = $request->validated();
        $plan = Plan::find($attr['plan_id']);
        $attr['user_id'] = request()->user()->id;
        $attr['ends_at'] = $plan->duration == 'Month' ? Carbon::now()->addMonth()->timezone('America/El_Salvador')->toDateTimeString()
        : Carbon::now()->addDay()->timezone('America/El_Salvador')->toDateTimeString();
        $suscription->update($attr);
        
        return redirect()->route('suscriptions.show', $suscription->id)->with([
            'level' => 'success',
            'message' => 'Suscription Updated Succesfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Suscription $suscription)
    {
        $suscription->delete();
        return redirect()->route('suscriptions.index')->with([
            'level' => 'success',
            'message' => 'Suscription Deleted Succesfully!'
        ]);
    }
    public function suscriptionInvoice(Suscription $suscription)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('suscription-invoice',[
            'suscription' => $suscription->load(['client.gym.department' , 'plan'])
        ]);

        return $pdf->download('suscription-invoice.pdf');
    }
    public function cancelSuscription(Suscription $suscription)
    {
        $suscription->canceled = true;
        $suscription->save();

        return back()->with([
            'level' => 'success',
            'message' => 'Suscription Canceled Succesfully!'
        ]);
    }
}
