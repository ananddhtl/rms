<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseApiController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\Api\ProductResource;
use Exception;
use Illuminate\Http\Request;

class ProductApiController extends BaseApiController
{
    public function __invoke(Request $request)
    {
        try {
            $products = Product::query()->with('image')->with('category')->with('category.image');
            if ($request->query('q')) {
                $products->where('name', 'LIKE', "%$request->q%");
            }
            if ($request->query('category')) {
                if ($request->query('category')) {
                    $categoryId = $request->query('category');
                    $products->whereHas('category', function ($query) use ($categoryId) {
                        $query->where('id', $categoryId);
                    });
                }
            }
            $products = $products->latest()->get();
            return $this->sendResponse(ProductResource::collection($products), 'Products fetched successfully!');
        } catch (Exception $e) {
            return $this->sendError('Something went wrong');
        }
    }

    public function getProductById(Request $request)
    {
        try {
            $product = Product::query()
                ->where('id', $request->id)
                ->with('image')
                ->with('category')
                ->with('category.image')
                ->first();
    
            if ($product) {
                return $this->sendResponse(new ProductResource($product), 'Product fetched successfully!');
            } else {
                return $this->sendError('Product not found');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
            return $this->sendError('Something went wrong');
        }
    }
    

    public function searchProducts(Request $request)
{
    try {
        $products = Product::where('name', 'like', '%' . $request->search_term . '%')
            ->with('image')
            ->with('category')
            ->with('category.image')
            ->get();

        return $this->sendResponse(ProductResource::collection($products), 'Products fetched successfully!');
    } catch (Exception $e) {
        dd($e->getMessage());
        return $this->sendError('Something went wrong');
    }
}

}
