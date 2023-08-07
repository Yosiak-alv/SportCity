<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ClientCreateEditRequest;
use App\Http\Requests\User\ClientSystemCreateEditRequest;
use App\Http\Requests\User\ClientTrainingSessionCreateRequest;
use App\Http\Requests\User\CreateClientPurchaseRequest;
use App\Http\Requests\User\CreateEditSuscriptionClient;
use App\Models\CardTransaction;
use App\Models\CashTransaction;
use App\Models\Gym;
use App\Models\Plan;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Suscription;
use App\Models\System;
use App\Models\TrainingSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Client;

class UserClientController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Client::class,'client');
    }

    protected function resourceAbilityMap(): array
    {
        return array_merge(parent::resourceAbilityMap(), [
            // method in Controller => method in Policy
            'restore' => 'restore',

            'createSystem' => 'createSystem',
            'storeSystem' => 'createSystem',
            'editSystem' => 'updateSystem',
            'updateSystem' => 'updateSystem',
            'destroySystem' => 'deleteSystem',

            'createSuscription' => 'createSuscription',
            'storeSuscription' => 'createSuscription',
            'showSuscription' => 'showSuscription',
            'cancelSuscription' => 'cancelSuscription',
            'suscriptionInvoice' => 'suscriptionInvoice',

            'assignAttendance' => 'assignAttendance',
            'storeAttendance' => 'assignAttendance',
            'attendaceShow' => 'attendaceShow',
            'registerAttendanceDate' => 'registerAttendanceDate',
            'destroyAttendace' => 'destroyAttendace',

            'createPurchase' => 'createPurchase',
            'storePurchase' => 'createPurchase',
            'showPurchase' => 'showPurchase'
        ]);
    }

    protected function resourceMethodsWithoutModels(): array
    {
        return array_merge(parent::resourceMethodsWithoutModels(), [
            // method in Controller
            /* 'addToOrder',
            'removeFromOrder', */
        ]);
    }
    /**
     * Display a listing of the resource.
     * Flash messages -> in get request flash.level => '', in post, patch, put, delete only level =>''
     */
    public function index()
    {
        //dd(request()->user()->hasPermissionTo('view clients'));
        return Inertia::render('User/User_Client/Index',[ 
            'clients' => Client::select(['id','dui','name','lastname','phone','deleted_at'])->where('gym_id',request()->user()->gym_id)->filter(request(['search','trashed']))
            ->paginate(5)->withQueryString(),
            'filters' => \Illuminate\Support\Facades\Request::only(['search','trashed']),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('User/User_Client/CreateEditClient',[
            'gyms' => Gym::all(['id','name'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * 
     */
    public function store(ClientCreateEditRequest $request)
    {
        $attr = $request->validated();
        $result = array_merge($attr,['password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi']);
        $client = Client::create($result);

        return to_route('clients.show',$client->id)->with([
            'level' => 'success',
            'message' => 'Client Created Succesfully!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return Inertia::render('User/User_Client/Show',[
            'client' => $client->load(['suscriptions.plan','purchases','system_client','gym.department','cardTransactions','cashTransactions']),
            'client_attendance_training_sessions' => $client->attendances_training_sessions()->when(\Illuminate\Support\Facades\Request::input('search') ?? false, function($query , $search) {
                $query->where(fn($query) =>
                    $query->where('name','like','%'.$search.'%')
                        ->orWhere('description','like','%'.$search.'%')
                        ->orWhere('duration','like','%'.$search.'%')
                        ->orWhere('starts_at','like','%'.$search.'%')
                        ->orWhere('finish_at','like','%'.$search.'%')
                );
            })->paginate(8)->withQueryString(),
            'filters' => \Illuminate\Support\Facades\Request::only('search'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return Inertia::render('User/User_Client/CreateEditClient',[
            'client' => $client,
            'gyms' => Gym::all(['id','name'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientCreateEditRequest $request, Client $client)
    {
        $client->update($request->validated());

        return redirect()->route('clients.show',$client->id)->with([
            'level' => 'success',
            'message' => 'Client Updated Succesfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')->with([
            'level' => 'success',
            'message' => 'Client Deleted Succesfully!'
        ]);
    }

    public function restore(Client $client)
    {
        Client::withTrashed()->find($client->id)->restore();

        return redirect()->route('clients.show',$client->id)->with([
            'level' => 'success',
            'message' => 'Client Restored Succesfully!'
        ]);
    }

    //CLIENT - SYSTEM
    public function createSystem(Client $client)
    {
        return Inertia::render('User/User_Client/Partials/Client_System/CreateEditClientSystem',[
            'systems' => System::all(),
            'client' => ['id' => $client->id,'name'=> $client->name,'lastname' => $client->lastname],
        ]);
    }
    public function storeSystem(ClientSystemCreateEditRequest $request, Client $client)
    {
        $conditions = collect([]);
        
        foreach ($request->conditions() as $index => $condition) {
            if ($request->validatedSystemsId()->contains($index)) {
                $conditions->put($index, [ 'condition' => $condition ]);
            }
        }
        $client->system_client()->sync($conditions);

        return redirect()->route('clients.show',$client->id)->with([
            'level' => 'success',
            'message' => 'Client System Created Succesfully!'
        ]);
    }
    public function editSystem(Client $client)
    {
        return Inertia::render('User/User_Client/Partials/Client_System/CreateEditClientSystem',[
            'systems' => System::all(),
            'client' => ['id' => $client->id,'name'=> $client->name,'lastname' => $client->lastname],
            'selected_client_systems' => $client->system_client()->select('id')->get()->pluck('id'),
            'select_client_system_conditions' => $client->system_client()->select(['system_id','condition'])->get()->pluck('condition','system_id'),
        ]);
    }
    public function updateSystem(ClientSystemCreateEditRequest $request, Client $client)
    {
        $conditions = collect([]);
        
        foreach ($request->conditions() as $index => $condition) {
            if ($request->validatedSystemsId()->contains($index)) {
                $conditions->put($index, [ 'condition' => $condition ]);
            }
        }
        $client->system_client()->sync($conditions);

        return redirect()->route('clients.show',$client->id)->with([
            'level' => 'success',
            'message' => 'Client System Updated Succesfully!'
        ]);
    }
    public function destroySystem(Client $client)
    {
        $client->system_client()->sync([]);
        
        return redirect()->route('clients.show',$client->id)->with([
            'level' => 'success',
            'message' => 'Client System Eliminated Succesfully!'
        ]);
    }

    //CLIENT - SUSCRIPTIONS

    public function createSuscription(Client $client)
    {
        return Inertia::render('User/User_Client/Partials/Client_Suscription/CreateEditSuscription',[
            'client' => ['id' => $client->id,'name'=> $client->name,'lastname' => $client->lastname],
            'plans' => Plan::all(),
        ]);
    }
    public function storeSuscription(CreateEditSuscriptionClient $request, Client $client)
    {   
        $request->merge([
            'user_id' => request()->user()->id,
        ]);
        
        if($request['plan_id'] == 1 || $request['plan_id'] == 2){ //mensualidad o pesas
            $request->merge([
                'ends_at' => Carbon::now()->addMonth()->timezone('America/El_Salvador')->toDateTimeString(),
            ]);
        }else{ //entrenamiento del dia 
            $request->merge([
                'ends_at' => Carbon::now()->timezone('America/El_Salvador')->toDateTimeString(),
            ]);
        }
        $suscription = Suscription::create([
            'client_id' => $request['client_id'],
            'plan_id' => $request['plan_id'],
            'user_id' => $request['user_id'],
            'ends_at' => $request['ends_at']
        ]);

        if($request['transaction'] == 'Card'){
            //card falta logica
            $transaction = [
                'client_id' => $request['client_id'],
                'idTransaccion' => '',
                'esReal' =>'',
                'esAprobada' => '',
                'codigoAutorizacion' => '',
                'mensaje' => 'Pago Realizado con Exito, Para ' . Plan::where('id',$request['plan_id'])->pluck('name')->first(),
                'formaPago' => 'Efectivo',
                'monto' => Plan::where('id',$request['plan_id'])->pluck('price')->first(),
                'suscription_id' => $suscription->id
            ];
            CardTransaction::created($transaction);
        }
        else{
            //cash
            $transaction = [
                'client_id' => $request['client_id'],
                'mensaje' => 'Pago Realizado con Exito, Para ' . Plan::where('id',$request['plan_id'])->pluck('name')->first(),
                'formaPago' => 'Efectivo',
                'monto' => Plan::where('id',$request['plan_id'])->pluck('price')->first(),
                'suscription_id' => $suscription->id
            ];
            CashTransaction::create($transaction);
        }
        

        return redirect()->route('clients.show',$client->id)->with([
            'level' => 'success',
            'message' => 'Client Suscription Created Succesfully!'
        ]);

    }
    public function showSuscription(Client $client,int $id)
    {
        return Inertia::render('User/User_Client/Partials/Client_Suscription/ClientSuscriptionShow',[
            'client' => $client->makeHidden(['genre','birth_date','height','weight','email_verified_at','created_at','updated_at']),
            'suscription' => Suscription::with(['plan'])->find($id),
            'transaction' => (CardTransaction::where('suscription_id',$id)->first() ?  CardTransaction::where('suscription_id',$id)->first() : CashTransaction::where('suscription_id',$id)->first()),
        ]);
    }
    public function cancelSuscription(Client $client,int $id)
    {
        $suscription = Suscription::find($id);
        $suscription->canceled = true;
        $suscription->save();

        $trasaction = (CardTransaction::where('suscription_id',$id)->first() ?  CardTransaction::where('suscription_id',$id)->first() : CashTransaction::where('suscription_id',$id)->first());
        $trasaction->canceled = true;
        $trasaction->save();

        return redirect()->route('clients.show',$client->id)->with([
            'level' => 'success',
            'message' => 'Client Suscription Canceled Succesfully!'
        ]);
    }

    public function suscriptionInvoice(Client $client,int $id)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('suscription-invoice',[
            'client' => $client,
            'transaction' => (CardTransaction::where('suscription_id',$id)->first() ?  CardTransaction::where('suscription_id',$id)->first() : CashTransaction::where('suscription_id',$id)->first()),
            'suscription' => Suscription::find($id),
        ]);

        return $pdf->download('suscription-invoice.pdf');
    }

    // CLIENT TRAINING SESSIONS

    public function assignAttendance(Client $client)
    {
        return Inertia::render('User/User_Client/Partials/Client_TrainingSessions/ClientTrainingSessionAssign',[
            'training_sessions' => TrainingSession::whereDoesntHave('attendancesClients', function ($query) use($client){
                return $query->where('client_id', $client->id);
            })->get(),
            'client' => ['id' => $client->id,'name'=> $client->name,'lastname' => $client->lastname],
        ]); 
    }
    public function storeAttendance(Client $client,ClientTrainingSessionCreateRequest $request)
    {
        $client->attendances_training_sessions()->attach($request->validatedTrainingSessionsId());

        return redirect()->route('clients.show',$client->id)->with([
            'level' => 'success',
            'message' => 'Client Training Sessions Associated Succesfully!'
        ]);
    }
    public function attendaceShow(Client $client,int $id)
    {
        $training_session = TrainingSession::find($id);
        return Inertia::render('User/User_Client/Partials/Client_TrainingSessions/ClientTrainingSessionShow',[
            'client_attendace_training_session' => $client->attendances_training_sessions()->where('training_session_id',$id)->first(),
            'training_session_coaches' => $training_session->training_sessions_coaches,
            'training_session_exercises' => $training_session->training_sessions_exercises,
            'client' => ['id' => $client->id,'name'=> $client->name,'lastname' => $client->lastname],
        ]);
    }
    public function registerAttendanceDate(Client $client,int $id, Request $request)
    {
        $attr = $request->validate([
            'attendance_date' => ['required']
        ]);
        $training_session = TrainingSession::find($id);
        $attendance_date = new \DateTime($attr['attendance_date']);
        $starts_At = new \DateTime($training_session->starts_at);
        $finish_At = new \DateTime($training_session->finish_at);

        if((($attendance_date >= $starts_At)  && ($attendance_date <= $finish_At) ))
        {
            $client->attendances_training_sessions()->updateExistingPivot($id, ['attendance_date' => $attr['attendance_date']]);

            return back()->with([
                'level' => 'success',
                'message' => 'Client Attendance Date Register Succesfully!'
            ]);
        }
        return back()->with([
            'level' => 'danger',
            'message' => 'Client Attendance Date Must be in the Interval !!! '
        ]);
       
    }
    public function destroyAttendace(Client $client,int $id)
    {
        $client->attendances_training_sessions()->detach($id);

        return redirect()->route('clients.show',$client->id)->with([
            'level' => 'success',
            'message' => 'Client Training Session Diassocieted Succesfully!'
        ]);
    }


    // CLIENT PURCHASE
    public function createPurchase(Client $client)
    {
        return Inertia::render('User/User_Client/Partials/Client_Purchase/ClientPurchaseCreate',[
            'client' => ['id' => $client->id,'name'=> $client->name,'lastname' => $client->lastname],
            'products' => Product::select(['id','name','description','unit_price','quantity'])->where('gym_id',request()->user()->gym_id)->where('quantity' ,'>', 0)->get()
        ]);
    }

    public function storePurchase(Client $client,CreateClientPurchaseRequest $request)
    {
        $quantities = collect([]);
        $purchase =  Purchase::create([
            'user_id' => request()->user()->id,
            'client_id' => $client->id,
            'item_count' => 0,
            'sub_total' => 0,
            'taxes'  => 0,
            'total' => 0,
            'canceled' => 0,
        ]);

        foreach ($request->quantities() as $index => $quantity) {
            if ($request->validatedProductIds()->contains($index)) {
                $quantities->push([ 
                    'product_id' => $index,
                    'quantity' => $quantity,
                    'unit_price' => Product::select(['unit_price'])->where('id',$index)->value('unit_price'),
                    'item_total' => number_format((float)((Product::select(['unit_price'])->where('id',$index)->value('unit_price')) * $quantity), 2, '.', ''),
                ]);
                $product = Product::find($index);
                $product->quantity = $product->quantity - $quantity;
                $product->save();
            }
        }
        //funciono con createMany
        $purchase->purchaseItems()->createMany($quantities->all());
        
        $purchase->item_count =  ($purchase->purchaseItems()->sum('quantity'));
        $purchase->sub_total = round($purchase->purchaseItems()->sum('item_total'),2);
        $purchase->taxes = round(($purchase->sub_total * .01), 2);
        $purchase->total = round($purchase->sub_total + $purchase->taxes,2);
        $purchase->save();

        if($request['transaction'] == 'Card'){

        }else{
            //cash
            $transaction = [
                'client_id' => $client->id,
                'mensaje' => 'Compra Realizada con Exito.',
                'formaPago' => 'Efectivo',
                'monto' => $purchase->total,
                'purchase_id' => $purchase->id
            ];
            CashTransaction::create($transaction);
        }

        return redirect()->route('clients.show',$client->id)->with([
            'level' => 'success',
            'message' => 'Client Purchase Created Succesfully!'
        ]);
       
    }
    public function showPurchase(Client $client,int $id)
    {   
        return Inertia::render('User/User_Client/Partials/Client_Purchase/ClientPurchaseShow',[
            'client' => $client->makeHidden(['genre','birth_date','height','weight','email_verified_at','created_at','updated_at']),
            'purchase' => Purchase::with(['purchaseItems.product'])->find($id), 
            'transaction' => (CardTransaction::where('purchase_id',$id)->first() ?  CardTransaction::where('purchase_id',$id)->first() : CashTransaction::where('purchase_id',$id)->first()),
        ]);
    }
    public function cancelPurchase(Client $client,int $id)
    {   
        //ya veremos 
        $purchase = Purchase::find($id);
        $purchase->canceled = true;
        $purchase->save();
       
        $trasaction = (CardTransaction::where('purchase_id',$id)->first() ?  CardTransaction::where('purchase_id',$id)->first() : CashTransaction::where('purchase_id',$id)->first());
        $trasaction->canceled = true;
        $trasaction->save();

        return redirect()->route('clients.show',$client->id)->with([
            'level' => 'success',
            'message' => 'Client Purchase Canceled Succesfully!'
        ]);
    }
    public function purchaseInvoice(Client $client,int $id)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('purchase-invoice',[
            'client' => $client,
            'transaction' => (CardTransaction::where('purchase_id',$id)->first() ?  CardTransaction::where('purchase_id',$id)->first() : CashTransaction::where('purchase_id',$id)->first()),
            'purchase' => Purchase::with('purchaseItems.product')->find($id),
        ]);

        return $pdf->download('purchase-invoice.pdf');
    }
}
