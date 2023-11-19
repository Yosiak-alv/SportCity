<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Suscription;
use App\Models\TrainingSession;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Client;
use App\Models\Purchase;
class DashboardClientController extends Controller
{
    public function index () {
        $client  = Client::with(['suscriptions.plan','purchases','system_client','gym.department'])->find(auth()->user()->id);

        return Inertia::render('Client/ClientDashboard',[
            'client' => $client,
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
    public function showTrainingSession(TrainingSession $training_session){
        return Inertia::render('Client/Partials/Client_TrainingSessions/ClientTrainingSessionShow',[
            'client_attendace_training_session' => $training_session,
            'training_session_coaches' => $training_session->training_sessions_coaches,
            'training_session_exercises' => $training_session->training_sessions_exercises,
           
        ]);
    }
    public function showPurchase(Purchase $purchase){
        return Inertia::render('Client/Partials/Client_Purchase/ClientPurchaseShow',[
            'purchase' =>  $purchase->load(['purchaseItems.product']), 
        ]);
    }
    public function purchaseInvoice(Purchase $purchase) {

        if($purchase->canceled || !$purchase->client()->exists()){
            abort(403,'THIS ACTION IS UNAUTHORIZED');
        }
        foreach ($purchase->purchaseItems as $item) {
            if ($item->product === null) {
                abort(403,'THIS ACTION IS UNAUTHORIZED, PRODUCT NOT FOUND');
            }
        }
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('purchase-invoice',[
            'client' => $purchase->client,
            'purchase' => $purchase->load('purchaseItems.product'),
        ]);
        return $pdf->download('purchase-invoice.pdf');
    }

    public function showSuscription(Suscription $suscription){
        return Inertia::render('Client/Partials/Client_Suscription/ClientSuscriptionShow',[
            'suscription' => $suscription->load(['plan']),
        ]);
    }

    public function suscriptionInvoice(Suscription $suscription){
        if($suscription->canceled || !$suscription->client()->exists() )
            abort(403,'THIS ACTION IS UNAUTHORIZED');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('suscription-invoice',[
            'suscription' => $suscription->load(['client.gym.department', 'plan']),
        ]);

        return $pdf->download('suscription-invoice.pdf');
    }
}
