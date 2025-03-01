<?php

use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_product_routes()
    {
        $response = $this->get('/products');
        $response->assertRedirect('/login');
    }

    public function test_user_can_view_purchase_page()
    {
        $user = User::factory()->create([
            'role' => 'user'
        ]);
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->get("/products/{$product->id}/purchase");
        $response->assertStatus(200);
        $response->assertViewIs('products.purchase');
    }

    public function test_user_can_purchase_product()
    {
        $user = User::factory()->create([
            'role' => 'user'
        ]);
        $product = Product::factory()->create(['quantity_available' => 10]);

        $response = $this->actingAs($user)->post("/products/{$product->id}/purchase", [
            'quantity' => 2,
        ]);

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('success', 'Product purchased successfully.');
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'quantity_available' => 8,
        ]);
    }

    public function test_admin_can_view_products_index()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/products');
        $response->assertStatus(200);
        $response->assertViewIs('products.index');
    }

    public function test_admin_can_create_product()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/products/create', [
            'name' => 'Test Product',
            'price' => 10.00,
            'quantity_available' => 100,
        ]);

        $response->assertRedirect('/products');
        $response->assertSessionHas('success', 'Product created successfully.');
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 10.00,
            'quantity_available' => 100,
        ]);
    }

    public function test_admin_can_edit_product()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $product = Product::factory()->create();

        $response = $this->actingAs($admin)->get("/products/{$product->id}/edit");
        $response->assertStatus(200);
        $response->assertViewIs('products.edit');
    }

    public function test_admin_can_update_product()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $product = Product::factory()->create();

        $response = $this->actingAs($admin)->put("/products/{$product->id}", [
            'name' => 'Updated Product',
            'price' => 20.00,
            'quantity_available' => 50,
        ]);

        $response->assertRedirect('/products');
        $response->assertSessionHas('success', 'Product updated successfully.');
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'price' => 20.00,
            'quantity_available' => 50,
        ]);
    }

    public function test_admin_can_delete_product()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $product = Product::factory()->create();

        $response = $this->actingAs($admin)->delete("/products/{$product->id}");

        $response->assertRedirect('/products');
        $response->assertSessionHas('success', 'Product deleted successfully.');
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);
    }

    public function test_purchase_fails_when_requested_quantity_exceeds_available()
    {
        $user = User::factory()->create(['role' => 'user']);
        $product = Product::factory()->create(['quantity_available' => 5]);

        $response = $this->actingAs($user)->post("/products/{$product->id}/purchase", [
            'quantity' => 10
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Not enough quantity available.');
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'quantity_available' => 5
        ]);
    }

    public function test_purchase_fails_with_invalid_quantity()
    {
        $user = User::factory()->create(['role' => 'user']);
        $product = Product::factory()->create(['quantity_available' => 5]);

        $response = $this->actingAs($user)->post("/products/{$product->id}/purchase", [
            'quantity' => 0
        ]);

        $response->assertSessionHasErrors('quantity');
    }

    public function test_purchase_fails_with_negative_quantity()
    {
        $user = User::factory()->create(['role' => 'user']);
        $product = Product::factory()->create(['quantity_available' => 5]);

        $response = $this->actingAs($user)->post("/products/{$product->id}/purchase", [
            'quantity' => -1
        ]);

        $response->assertSessionHasErrors('quantity');
    }

    public function test_purchase_fails_with_non_existent_product()
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->post("/products/99999/purchase", [
            'quantity' => 1
        ]);

        $response->assertStatus(404);
    }

    public function test_admin_cannot_create_product_with_negative_price()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/products/create', [
            'name' => 'Test Product',
            'price' => -10.00,
            'quantity_available' => 100,
        ]);

        $response->assertSessionHasErrors('price');
    }

    public function test_admin_cannot_create_product_with_negative_quantity()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/products/create', [
            'name' => 'Test Product',
            'price' => 10.00,
            'quantity_available' => -100,
        ]);

        $response->assertSessionHasErrors('quantity_available');
    }
}
