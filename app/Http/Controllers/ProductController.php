<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

/*
 * Changes:
 * Use Laravel's built-in ORM, Eloquent instead of Query Builder to interact with the database.
 * This provides a more expressive and clean way to manage database records.

 * Added Validation by using Laravel's built-in validation system to validate the request data.
 * This ensures that the Product's Name is required, unique, and within the specified length.

 * Use proper naming conventions for methods like create instead of new to match RESTful resource naming.

 * Instead of delete(Request $request), we can use destroy(Product $product) for type hinting for the Product model.

 * Use Named Routes for redirecting. This makes the code more readable and maintainable.
*/

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products|max:255',
            'description' => 'nullable|string',
        ]);

        Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return redirect(route('products.index'))->with('status', 'The product was saved');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect(route('products.index'))->with('status', 'The product was deleted');
    }
}
