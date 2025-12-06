<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Services\CartServiceInterface;
use App\Repositories\CartRepositoryInterface;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartItemRequest;

class CartController extends Controller
{
    protected $cartService;
    protected $cartRepository;

    public function __construct(CartServiceInterface $cartService, CartRepositoryInterface $cartRepository)
    {
        $this->cartService = $cartService;
        $this->cartRepository = $cartRepository;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();
        $cartItems = $this->cartRepository->getItems($cart);
        return view('cart', compact('cartItems'));
    }

    public function add(AddToCartRequest $request)
    {
        $cart = $this->cartService->getCart();
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        $userId = Auth::id();
        $this->cartService->addProduct($cart, $productId, $quantity, $userId);
        return redirect()->route('cart.index')->with('success', 'Товар додано до кошика!');
    }

    public function update(UpdateCartItemRequest $request)
    {
        $cart = $this->cartService->getCart();
        $itemId = $request->input('item_id');
        $quantity = $request->input('quantity');
        $this->cartService->updateProduct($cart, $itemId, $quantity);
        return redirect()->route('cart.index')->with('success', 'Кількість оновлено!');
    }

    public function remove($itemId)
    {
        $cart = $this->cartService->getCart();
        $this->cartService->removeProduct($cart, $itemId);
        return redirect()->route('cart.index')->with('success', 'Товар видалено з кошика!');
    }

    public function attachGuestCartToUser()
    {
        if (!Auth::check()) return;
        $sessionId = session()->getId();
        $guestCart = $this->cartRepository->findBySessionId($sessionId);
        if ($guestCart) {
            $userCart = $this->cartRepository->findByUserId(Auth::id()) ?? $this->cartRepository->create(['user_id' => Auth::id()]);
            foreach ($guestCart->items as $item) {
                $existing = $userCart->items()->where('product_id', $item->product_id)->first();
                if ($existing) {
                    $existing->quantity += $item->quantity;
                    $existing->save();
                    $item->delete();
                } else {
                    $item->cart_id = $userCart->id;
                    $item->user_id = Auth::id();
                    $item->save();
                }
            }
            $guestCart->delete();
        }
    }
}
