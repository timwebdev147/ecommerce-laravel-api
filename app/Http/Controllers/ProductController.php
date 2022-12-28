<?php



namespace App\Http\Controllers;

    use App\models\Product;
    use Illuminate\Http\Request;
 
    class ProductController extends Controller
    {
        public function index()  // fetch all products
        {
            return response()->json(Product::all(),200);
        }
 
        public function store(Request $request)  // creates a new product
        {
            if($request->hasFile('image')){
                $name = time()."_".$request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('images'), $name);
            }
            // return response()->json(asset("images/$name"),201);

            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'image' => $request->hasFile('image')? asset("images/$name"): $request->image
            ]);
 
            return response()->json([
                'status' => (bool) $product,
                'data'   => $product,
                'message' => $product ? 'Product Created!' : 'Error Creating Product'
            ]);
            
        }
 
        public function show(Product $product)
        {
            return response()->json($product,200); 
        }
 
        public function uploadFile(Request $request)  //upload the product image and fetch the image URL
        {   
            if($request->hasFile('image')){
                $name = time()."_".$request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('images'), $name);
            }
            return response()->json(asset("images/$name"),201);
        }
 
        public function update(Request $request, Product $product)  //Update the Product
        {
            $status = $product->update(
                $request->only(['name', 'description', 'units', 'price', 'image'])
            );
 
            return response()->json([
                'status' => $status,
                'message' => $status ? 'Product Updated!' : 'Error Updating Product'
            ]);
        }
 
        public function Quantity(Request $request, Product $product)  //Adds the product quantity
        {
            $product->quantity = $product->quantity + $request->get('quantity');
            $status = $product->save();
 
            return response()->json([
                'status' => $status,
                'message' => $status ? 'Units Added!' : 'Error Adding Product Units'
            ]);
        }
 
        public function destroy(Product $product)  //deletes the product
        {
            $status = $product->delete();
 
            return response()->json([
                'status' => $status,
                'message' => $status ? 'Product Deleted!' : 'Error Deleting Product'
            ]);
        }
    }
