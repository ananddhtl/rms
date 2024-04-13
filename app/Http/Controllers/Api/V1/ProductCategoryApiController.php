<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseApiController;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\ProductResource;
use Exception;
use Illuminate\Http\Request;

class ProductCategoryApiController extends BaseApiController
{
    public function __invoke(Request $request)
    {
        try {
            $categories = ProductCategory::query()->with('image');
            if ($request->query('q')) {
                $categories->where('name', 'LIKE', "%$request->q%");
            }
            $categories = $categories->get();
            return $this->sendResponse(CategoryResource::collection($categories), 'Category fetched successfully!');
        } catch (Exception $e) {
            return $this->sendError('Something went wrong');
        }
    }

    public function productsByCategory(Request $request)
    {
        try {
           
            $category = ProductCategory::where('id', $request->id)->with('image')->first();
    
           
            if (!$category) {
                return $this->sendError('Category not found.');
            }
    
          
            $products = $category->products()->with('image')->with('category')->with('category.image')->latest()->get();
    
           
            return $this->sendResponse(ProductResource::collection($products), 'Products fetched successfully!');
        } catch (Exception $e) {
           
         
           
            return $this->sendError('Something went wrong.');
        }
    }
    
    
}
