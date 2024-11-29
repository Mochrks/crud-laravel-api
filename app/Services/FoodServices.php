<?php

namespace App\Services;

use App\Models\FavoriteFoods;
use App\Models\Foods;
use App\Models\Carts;
use App\Models\Categories;
use Illuminate\Support\Facades\Log;
use App\Utils\ResponseUtils;
use Illuminate\Http\Request;
use App\Utils\FoodQueryUtils;
use App\Utils\MinioUrlUtils;
use Illuminate\Support\Facades\Auth;

class FoodServices
{

    public function getAllFood($params)
    {
        try {
            $query = FoodQueryUtils::buildQuery($params);

            $pageNumber = $params['pageNumber'] ?? 1;
            $pageSize = $params['pageSize'] ?? 8;
            $foods = $query->paginate($pageSize, ['*'], 'page', $pageNumber);

            if ($foods->isEmpty()) {
                Log::error("ERROR Data makanan tidak ditemukan");
                return ResponseUtils::errorResponseNotFound('Data makanan tidak ditemukan', 404);
            }

            $response = [
                'total' => $foods->total(),
                'data' => $foods->map(function ($food) {
                    $user = Auth::user();
                    $userId = $user->user_id;

                    $is_favorite = FavoriteFoods::where('food_id', $food->food_id)
                        ->where('user_id', $userId)
                        ->where('is_favorite', true)
                        ->exists();
                    $is_cart = Carts::where('food_id', $food->food_id)
                        ->where('user_id', $userId)
                        ->exists();

                    return [
                        'foodId' => $food->food_id,
                        'categories' => [
                            'categoryId' => $food->category_id,
                            'categoryName' => optional($food->category)->category_name,
                        ],
                        'nama_makanan' => $food->food_name,
                        'harga' => $food->price,
                        'image_filename' => $food->image_filename,
                        'is_favorite' => $is_favorite,
                        'is_cart' =>  $is_cart,
                        'userId' => $userId,
                    ];
                }),
                'message' => 'Berhasil memuat makanan',
                'statusCode' => 200,
                'status' => 'OK'
            ];

            Log::info("INFO Berhasil memuat makanan");
            return $response;
        } catch (\Exception $ex) {

            Log::error("ERROR Terjadi kesalahan pada server");
            return ResponseUtils::errorResponse('Terjadi kesalahan pada server, silahkan coba lagi!', 500, $ex->getMessage());
        }
    }


    public function addToCart($foodId)
    {
        try {
            $user = Auth::user();
            $userId = $user->user_id;

            $food = Foods::find($foodId);

            if (!$food) {
                Log::error("ERROR Makanan dengan foodId: $foodId tidak ditemukan.");
                return ResponseUtils::errorResponseNotFound("Makanan dengan foodId: $foodId tidak ditemukan.", 404);
            }

            $isFavorite = FavoriteFoods::where('food_id', $foodId)
                ->where('user_id', $userId)
                ->value('is_favorite');

            // cek apakah sudah ada di cart
            $isInCart = Carts::where('food_id', $foodId)
                ->where('user_id', $userId)
                ->exists();
            if (!$isInCart) {
                $cart = new Carts();
                $cart->food_id = $foodId;
                $cart->user_id = $userId;
                $cart->qty = 1;
                $cart->is_deleted = false;
                $cart->created_by = "admin";
                $cart->created_time = now();
                $cart->modified_time = now();
                $cart->save();
            }

            $response = [
                'total' => 1,
                'data' => [
                    'foodId' => $food->food_id,
                    'categories' => [
                        'categoryId' => $food->category_id,
                        'categoryName' => optional($food->category)->category_name,
                    ],
                    'nama_makanan' => $food->food_name,
                    'harga' => $food->price,
                    'image_filename' => $food->image_filename,
                    'is_favorite' => $isFavorite ?? false,
                    'is_cart' => true,
                    'userId' => $userId,
                ],
                'message' => "\"$food->food_name\" berhasil ditambahkan ke dalam keranjang",
                'status_code' => 200,
                'status' => 'OK'
            ];

            Log::info("INFO \"$food->food_name\" berhasil ditambahkan ke dalam keranjang");
            return $response;
        } catch (\Exception $ex) {

            Log::error("ERROR Terjadi kesalahan pada server");
            return ResponseUtils::errorResponse('Terjadi kesalahan pada server, silahkan coba lagi!', 500, $ex->getMessage());
        }
    }


    public function toggleFavorite($foodId)
    {
        try {
            $user = Auth::user();
            $userId = $user->user_id;

            $favorite = FavoriteFoods::where('food_id', $foodId)
                ->where('user_id', $userId)
                ->first();
            if (!$favorite) {

                $favorite = new FavoriteFoods();
                $favorite->food_id = $foodId;
                $favorite->user_id = $userId;
                $favorite->is_favorite = true;
                $statusMessage = 'ditambahkan ke dalam ';
            } else {
                $favorite->is_favorite = !$favorite->is_favorite;
                $statusMessage = $favorite->is_favorite ? 'ditambahkan ke dalam' : 'dihapus dari';
            }

            $favorite->save();

            $food = Foods::find($foodId);

            Log::info("INFO Makanan \"$food->food_name\" berhasil $statusMessage favorit");
            return ResponseUtils::successResponseDataWTotal(1, '', "Makanan \"$food->food_name\" berhasil $statusMessage favorit", 200);
        } catch (\Exception $ex) {

            Log::error("ERROR Terjadi kesalahan pada server");
            return ResponseUtils::errorResponse('Terjadi kesalahan pada server, silahkan coba lagi!', 500, $ex->getMessage());
        }
    }


    public function deleteFromCart($foodId)
    {

        try {
            $food = Foods::find($foodId);
            $cartItem = Carts::find($foodId);

            if ($cartItem) {
                $cartItem->is_deleted = true;
                $cartItem->save();

                Log::info('INFO berhasil dihapus dari keranjang');
                return ResponseUtils::successResponse("Berhasil dihapus dari keranjang!", 200);
            } else {

                Log::error("ERROR Item foodID: $foodId tidak ditemukan.");
                return ResponseUtils::errorResponseNotFound("Item foodID: $foodId tidak ditemukan.", 404);
            }
        } catch (\Exception $ex) {

            Log::error("ERROR Terjadi kesalahan pada server");
            return ResponseUtils::errorResponse('Terjadi kesalahan pada server, silahkan coba lagi!', 500, $ex->getMessage());
        }
    }
}
