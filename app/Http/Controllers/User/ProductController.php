<?php


namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateEditProductRequest;
use App\Models\Department;
use App\Models\Gym;
use App\Models\Product;
use App\Traits\ProductTrait;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ProductController extends Controller
{
    use ProductTrait;
    public function __construct()
    {
        $this->authorizeResource(Product::class,'product');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('User/Products/Index',[
            'products' => Product::select(['id','name','unit_price','quantity','deleted_at'])->latest('created_at')->where('gym_id',request()->user()->gym_id)->filter(request(['search','trashed']))
            ->paginate(5)->withQueryString(),
            'filters' => \Illuminate\Support\Facades\Request::only(['search','trashed']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $gyms = Gym::with('department')->get();
        //dd($gyms->load('department'));
        return Inertia::render('User/Products/CreateEditProduct',[
            'gyms' => $gyms->makeHidden(['email','phone','department_id','deleted_at','created_at','updated_at'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEditProductRequest $request)
    {
        $product = Product::create($request->validated());

        return redirect()->route('products.show',$product->id)->with([
            'level' => 'success',
            'message' => 'Product Created Succesfully!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return Inertia::render('User/Products/Show',[
            'product' => $product->load('gym.department') 
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $gyms = Gym::with('department')->get();
        return Inertia::render('User/Products/CreateEditProduct',[
            'gyms' => $gyms->makeHidden(['email','phone','department_id','deleted_at','created_at','updated_at']),
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateEditProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()->route('products.show',$product->id)->with([
            'level' => 'success',
            'message' => 'Product Updated Succesfully!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.show',$product->id)->with([
            'level' => 'success',
            'message' => 'Product Deleted Succesfully!'
        ]);
    }

    public function restore(Product $product)
    {
        Product::withTrashed()->find($product->id)->restore();

        return redirect()->route('products.show',$product->id)->with([
            'level' => 'success',
            'message' => 'Product Restored Succesfully!'
        ]);
    }
}
