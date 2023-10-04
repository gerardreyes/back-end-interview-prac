<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Tag;
use Database\Factories\ProductFactory;
use Database\Factories\TagFactory;

class ProductControllerTest extends TestCase
{
    use DatabaseTransactions; // Use transactions to reset the database after each test

    public function testIndex()
    {
        // Create test products and tags using factories
        $products = ProductFactory::new()->count(3)->create();
        $tags = TagFactory::new()->count(2)->create();

        // Attach tags to products
        foreach ($products as $product) {
            $product->tags()->sync($tags->pluck('id')->toArray());
        }

        // Send a GET request to the index route
        $response = $this->get(route('products.index'));

        // Check if the response contains the product names and tags
        $response->assertStatus(200);
        foreach ($products as $product) {
            $response->assertSee($product->name);
            foreach ($product->tags as $tag) {
                $response->assertSee($tag->name);
            }
        }
    }

    public function testStore()
    {
        // Create test product data
        $productData = [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'tags' => 'Tag1,Tag2,Tag3',
        ];
    
        // Send a POST request to the store route with the product data
        $response = $this->post(route('products.store'), $productData);
    
        // Check if the product was created and redirected to the index route
        $response->assertStatus(302); // Redirect
        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    
        // Check if the tags were created and associated with the product
        $product = Product::where('name', 'Test Product')->first();
        $this->assertCount(3, $product->tags);
    
        // Check for success message
        $response->assertSessionHas('status', 'The product was saved');
    }
    
    public function testDestroy()
    {
        // Create test products in the database
        $products = ProductFactory::new()->count(3)->create();
    
        // Send DELETE requests to the destroy route for each product
        foreach ($products as $product) {
            $response = $this->delete(route('products.destroy', $product));
    
            // Check if the product was deleted and redirected to the index route
            $response->assertStatus(302); // Redirect
            $this->assertDatabaseMissing('products', ['id' => $product->id]);
    
            // Check for success message
            $response->assertSessionHas('status', 'The product was deleted');
        }
    }
}
