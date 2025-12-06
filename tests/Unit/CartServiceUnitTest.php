<?php

use App\Services\CartService;
use App\Models\Cart;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PHPUnit\Framework\TestCase;
use Mockery;

class CartServiceUnitTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_add_product_calls_create_when_no_item_exists()
    {
        $hasManyMock = Mockery::mock(HasMany::class);
        $hasManyMock->shouldReceive('where')->with('product_id', 1)->andReturnSelf();
        $hasManyMock->shouldReceive('first')->andReturn(null);
        $hasManyMock->shouldReceive('create')->with([
            'product_id' => 1,
            'quantity' => 2,
            'user_id' => 5,
        ])->once();

        $cartMock = Mockery::mock(Cart::class);
        $cartMock->shouldReceive('items')->andReturn($hasManyMock);

        $service = new CartService();
        $service->addProduct($cartMock, 1, 2, 5);

        $hasManyMock->shouldHaveReceived('create');
        $this->assertTrue(true);
    }
}
