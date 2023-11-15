<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\CreatePurchaseRequest;
use App\Models\Client;
use App\Models\Gym;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Purchase::class, 'purchase');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('User/Purchases/Index',[
            'purchases' => Purchase::select(['id','item_count','taxes','sub_total','total','canceled'])->latest('created_at')
            ->filter(request(['search']))->paginate(10)->withQueryString(),
            'filters' => \Illuminate\Support\Facades\Request::only(['search']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('User/Purchases/CreateEditPurchase',[
            'products' =>  request()->user()->hasRole(['administrator','manager']) ? Product::with(['gym:id,name'])->where('quantity' ,'>', 0)->get() : 
                Product::with(['gym:id,name'])->where('gym_id',request()->user()->gym_id)->where('quantity' ,'>', 0)->get(),
            'clients' =>  request()->user()->hasRole(['administrator','manager']) ? Client::with(['gym:id,name'])->get() : 
                Client::with(['gym:id,name'])->where('gym_id',request()->user()->gym_id)->get(),
            'gyms' => request()->user()->hasRole(['administrator','manager']) ?  Gym::all(['id','name']) : null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePurchaseRequest $request)
    {
        try{
            $attr = $request->validated();
            $this->storePurchaseVlidations($request, $attr);

            $quantities = collect([]);
            foreach ($request->quantities() as $index => $quantity) {
                if ($request->validatedProductIds()->contains($index)) {
                    $quantities->push([ 
                        'product_id' => $index,
                        'quantity' => $quantity,
                        'unit_price' => Product::select(['unit_price'])->where('id',$index)->value('unit_price'),
                        'item_total' => number_format((float)((Product::select(['unit_price'])->where('id',$index)->value('unit_price')) * $quantity), 2, '.', ''),
                    ]);
                    $product = Product::find($index);
                    if($product->quantity < $quantity){
                        throw new \Exception('Invalid quantity selection. Quantity must be less than or equal to the product quantity');
                    }else{
                        $product->quantity = $product->quantity - $quantity;
                        $product->save();
                    }
                }
            }
            $purchase =  Purchase::create([
                'user_id' => request()->user()->id,
                'client_id' => $attr['client_id'],
                'item_count' => 0,
                'sub_total' => 0,
                'taxes'  => 0,
                'total' => 0,
                'canceled' => 0,
            ]);
            //funciono con createMany
            $purchase->purchaseItems()->createMany($quantities->all());
            
            $purchase->item_count =  ($purchase->purchaseItems()->sum('quantity'));
            $purchase->sub_total = round($purchase->purchaseItems()->sum('item_total'),2);
            $purchase->taxes = round(($purchase->sub_total * .01), 2);
            $purchase->total = round($purchase->sub_total + $purchase->taxes,2);
            $purchase->save();
    
            return redirect()->route('purchases.show',$purchase->id)->with([
                'level' => 'success',
                'message' => 'Client Purchase Created Succesfully!'
            ]);
        }catch(\Exception $e){
            return back()->with([
                'level' => 'danger',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        return Inertia::render('User/Purchases/Show',[
            'purchase' => $purchase->load(['purchaseItems.product','client'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //no
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //no
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //no
    }

    public function cancelPurchase(Purchase $purchase)
    {   
        $purchase->canceled = true;
        $purchase->save();

        // Recupera los elementos de compra asociados a la compra
        $purchaseItems = $purchase->purchaseItems;
        // Ajusta la cantidad de productos según la cantidad cancelada
        foreach ($purchaseItems as $purchaseItem) {
            // Supongamos que la cantidad cancelada es 2
            $product = $purchaseItem->product;
            $product->quantity += $purchaseItem->quantity; //devolviendo productos
            $product->save(); // Guarda los cambios en el producto
        }

        return back()->with([
            'level' => 'success',
            'message' => 'Client Purchase Canceled Succesfully, Products Return Succesfully!'
        ]);
    }
    public function purchaseInvoice(Purchase $purchase)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('purchase-invoice',[
            'client' => $purchase->client,
            'purchase' => $purchase->load('purchaseItems.product'),
        ]);
        return $pdf->download('purchase-invoice.pdf');
    }


    private function storePurchaseVlidations($request, $attr){
        if (request()->user()->hasRole(['administrator', 'manager'])) {
            $products = Product::whereIn('id', $request->validatedProductIds())->where('gym_id', $attr['gym_id'])->get();
            $client = Client::where('id', $attr['client_id'])->where('gym_id', $attr['gym_id'])->get();
        } else {
            $products =  Product::whereIn('id', $request->validatedProductIds())->where('gym_id', request()->user()->gym_id)->get();
            $client = Client::where('id', $attr['client_id'])->where('gym_id', $attr['gym_id'])->get();
        }

        if ($products->count() !== count($request->validatedProductIds())) {
            throw new \Exception('Invalid Products selection. Products must belong to the same gym');
        }
        if ($client->count() !== 1) {
            throw new \Exception('Invalid Client selection. Client must belong to the same gym');
        }
    }
}
