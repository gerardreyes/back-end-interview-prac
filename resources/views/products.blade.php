{{--
* Model Query in Blade Template:
  Using App\Models\Product::all() to retrieve Products is not a recommended practice.
  Instead, you should pass the Products data from your Controller to the Blade template.
  It's more efficient and follows the MVC pattern.

* Input Validation for Form Fields:
  You should consider adding validation rules to your form fields. 
  For example, you can use the required and max rules for the "name" field.
  This will help ensure data integrity and security.

* Displaying HTML Tags:
  Using {!! $product->name !!} outputs data without escaping it.
  If Product Names contain HTML or script tags, it could potentially lead to a Cross-Site Scripting (XSS) vulnerability.
  You should use {{ $product->name) }} to escape the any HTML or special characters within the variable.

* Error Handling:
  Consider adding error handling to your form submissions.
  If there's an error during form submission (e.g., database insert fails), you should provide feedback to the user.

* Consider Using Named Routes:
  Instead of hardcoding URLs in your forms, consider using named routes for better maintainability.
--}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Products</title>

    <style>
        .alert-success {
            color: green;
        }

    </style>
</head>
<body>

<h1>Current Products</h1>

<!-- Products from ProductController -->
@if ($products->count())
    <ul>
        @foreach ($products as $product)
            <li>
                {{ $product->name }}
                <!-- Use Named Route -->
                <form action="{{ route('products.destroy', $product) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@else
    <p><em>No products have been created yet.</em></p>
@endif



@if (session('status'))
    <div class="alert-success">
        {{ session('status') }}
    </div>
@endif

<!-- Display validation errors -->
@if ($errors->any())
    <div class="alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<hr />

<h2>New product</h2>
<!-- Use Named Route -->
<form action="{{ route('products.store') }}" method="POST">
    @csrf
    <!-- Add validation for name -->
    <input type="text" name="name" placeholder="name" required max=255/><br />
    <!-- Error handling for name -->
    @if ($errors->has('name'))
        <span class="text-danger">{{ $errors->first('name') }}</span>
    @endif
    <br />
    <textarea name="description" placeholder="description"></textarea><br />
    <input type="text" name="tags" placeholder="tags" /><br />
    <button type="submit">Submit</button>
</form>

</body>
</html>
