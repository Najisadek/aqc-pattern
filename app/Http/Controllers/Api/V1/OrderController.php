<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\AQC\V1\Order\{CancelOrder, CreateOrder, DeleteOrder, GetOrders, UpdateOrderStatus};
use App\Http\Requests\V1\Order\{CreateOrderRequest, UpdateOrderStatusRequest};
use Illuminate\Http\{JsonResponse, Request};
use App\Models\Order;

final class OrderController
{
    public function index(Request $request): JsonResponse
    {
        $orders = (new GetOrders)->handle($request->all());

        return response()->json($orders);
    }

    public function store(CreateOrderRequest $request): JsonResponse
    {
        $order = (new CreateOrder)->handle([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return response()->json($order, 201);
    }

    public function show(Order $order): JsonResponse
    {
        return response()->json($order->load('items.product'));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order): JsonResponse
    {
        $order = (new UpdateOrderStatus)->handle(
            $order,
            $request->input('status')
        );

        return response()->json($order);
    }

    public function cancel(Order $order): JsonResponse
    {
        $order = (new CancelOrder)->handle($order);

        return response()->json($order);
    }

    public function destroy(Order $order): JsonResponse
    {
        (new DeleteOrder)->handle($order);

        return response()->json(null, 204);
    }
}
