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

/*
 * Fix any security issues you notice in the ProductController.
 * SQL Injection Vulnerability:
 * The new and delete methods in the original code directly query in the database using SQL queries
 * without any validation or sanitization of user input.
 * This leaves your application vulnerable to SQL injection attacks.
 * To fix this, I used Eloquent instead.

 * No Input Validation:
 * The original code lacks input validation. It accepts user input without any validation,
 * which can lead to security vulnerabilities and data integrity issues.
 * To fix this, I added an input Validation.

 * No Authentication and Authorization:
 * This might not be applicable in this exam since there is no login and logout function.
 * But a good addition to this would be to add authentication or authorization checks for create and delete methods.

 * Lack of Route Binding:
 * The delete method expects an id from the request but doesn't specify where it comes from.
 * It is better to use route model binding to automatically inject the model based on the URL parameter.
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