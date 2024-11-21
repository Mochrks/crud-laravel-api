<?php

namespace App\Http\Controllers;

use App\Services\FoodServices;

use Illuminate\Http\Request;

class FoodController extends Controller
{
    protected $foodService;

    public function __construct(FoodServices $foodService)
    {
        $this->foodService = $foodService;
    }

    /**
     * @OA\Get(
     *      path="/food-order/foods",
     *      operationId="getAllFoods",
     *      tags={"Food Order"},
     *      summary="Get all foods",
     *      description="Retrieve all available foods",
     *      @OA\Parameter(
     *          name="categoryId",
     *          in="query",
     *          description="ID of the category",
     *          required=false,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          name="foodName",
     *          in="query",
     *          description="Name of the food",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="pageSize",
     *          in="query",
     *          description="Number of items per page",
     *          required=false,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          name="pageNumber",
     *          in="query",
     *          description="Page number",
     *          required=false,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          name="sortBy",
     *          in="query",
     *          description="Sort by attribute",
     *          required=false,
     *          @OA\Schema(type="string", enum={"foodname"}),
     *      ),
     *      @OA\Parameter(
     *          name="asc",
     *          in="query",
     *          description="Sort in ascending order",
     *          required=false,
     *          @OA\Schema(type="string", enum={"asc", "desc"}),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="total", type="integer", example="8"),
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="foodId", type="integer", example="1"),
     *                      @OA\Property(property="categories", type="object",
     *                          @OA\Property(property="categoryId", type="integer", example="1"),
     *                          @OA\Property(property="categoryName", type="string", example="Dinner"),
     *                      ),
     *                      @OA\Property(property="foodName", type="string", example="Nasi Goreng"),
     *                      @OA\Property(property="foodPrice", type="integer", example="12000"),
     *                      @OA\Property(property="imageUrl", type="string", example="https://asset.kompas.com/crops/DWvs7cEUvVQ-luk5M1X74elzNSM=/0x0:498x332/780x390/data/photo/2020/02/07/5e3d3ae57251e.jpg"),
     *                      @OA\Property(property="is_favorite", type="boolean", example="true"),
     *                      @OA\Property(property="is_cart", type="boolean", example="true"),
     *                      @OA\Property(property="userId", type="integer", example="1"),
     *                  ),
     *              ),
     *              @OA\Property(property="message", type="string", example="Berhasil memuat Makanan"),
     *              @OA\Property(property="statusCode", type="integer", example="200"),
     *              @OA\Property(property="status", type="string", example="OK"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *      )
     * )
     */


    public function getAllFoods(Request $request)
    {
        $response = $this->foodService->getAllFood($request->all());
        return response()->json($response);
    }

    /**
     * @OA\Post(
     *      path="/food-order/cart",
     *      operationId="addToCart",
     *      tags={"Food Order"},
     *      summary="Add item to cart",
     *      description="Add an item to the user's cart",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"foodId"},
     *              @OA\Property(property="foodId", type="integer", example="123"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Item successfully added to cart",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *      ),
     * )
     */
    public function addToCart(Request $request)
    {
        $foodId = $request->input('foodId');
        $response = $this->foodService->addToCart($foodId);
        return response()->json($response);
    }


    /**
     * @OA\Put(
     *      path="/food-order/foods/{foodId}/favorites",
     *      operationId="toggleFavorite",
     *      tags={"Food Order"},
     *      summary="Toggle favorite item",
     *      description="Toggle favorite status of the specified food item",
     *      @OA\Parameter(
     *          name="foodId",
     *          in="path",
     *          required=true,
     *          description="ID of the food item",
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Favorite status toggled successfully",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *      ),
     * )
     */

    public function toggleFavorite(Request $request, $foodId)
    {
        $response = $this->foodService->toggleFavorite($foodId);
        return response()->json($response);
    }


    /**
     * @OA\Delete(
     *      path="/food-order/cart/{cartId}",
     *      operationId="deleteFromCart",
     *      tags={"Food Order"},
     *      summary="Delete item from cart",
     *      description="Delete an item from the user's cart",
     *      @OA\Parameter(
     *          name="cartId",
     *          in="path",
     *          required=true,
     *          description="ID of the item in the cart",
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Item successfully deleted from cart",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error",
     *      ),
     * )
     */

    public function deleteFromCart($foodId)
    {
        $response = $this->foodService->deleteFromCart($foodId);
        return response()->json($response);
    }
}
