<?php

namespace App\Controller\Order;

use App\Command\CreateOrderCommand;
use App\Controller\ApiController;
use App\Domain\Order\Response\OrderResponseBuilder;
use App\Domain\Order\Validation\PostOrderValidator;
use App\Query\GetOrdersListQuery;
use App\Services\ProductServiceApi\Api\ProductApi;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends ApiController
{
    public function __construct(private readonly OrderResponseBuilder $orderResponseBuilder)
    {
    }

    #[Route(path: "/orders", name: "create_order", methods: [Request::METHOD_POST])]
    public function create(
        Request $request,
        PostOrderValidator $validator,
        CreateOrderCommand $createOrderCommand,
        ProductApi $productApi
    ): JsonResponse
    {
        $payload = $this->getRequestPayload($request);

        $violations = $validator->validate($payload);
        if ($violations->count() > 0) {
            $message = [];
            foreach ($violations as $violation) {
                $message[] = $violation->getPropertyPath() . $violation->getMessage();
            }

            throw new HttpException(
                Response::HTTP_BAD_REQUEST,
                json_encode($message),
            );
        }

        try {
            $product = $productApi->updateProduct($payload['product'], $payload['qty']);

            $order = ($createOrderCommand) ($payload, $product['price']);
        }
        catch (\Throwable $exception){
            $statusCode = $exception->getCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR;
            throw new HttpException(
                $statusCode,
                $exception->getMessage()
            );
        }

        return $this->json($this->orderResponseBuilder->build($order, $product));
    }


    #[Route(path:"/orders", name: "list_orders", methods: [Request::METHOD_GET])]
    public function list(
        GetOrdersListQuery $ordersListQuery,
        ProductApi $productApi
    ): JsonResponse
    {
        try {
            $orders = ($ordersListQuery)();

            $products = $productApi->listProducts();
        }
        catch (\Throwable $exception) {
            throw new HttpException(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                $exception->getMessage()
            );
        }

        return $this->json($this->orderResponseBuilder->buildAsArray($orders, $products));
    }
}