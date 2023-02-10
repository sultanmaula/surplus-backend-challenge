<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use App\Models\Image as ModelsImage;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $product = Product::with('category', 'image')->where('enable', 1)->get();

            return response()->json([
                'code' => 200,
                'message' => 'SUCCESS',
                'result' => $product,
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'NOT FOUND'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'enable' => 'required|boolean',
            ]);

            $product = Product::with('category', 'image')->create([
                'name' => $request->name,
                'description' => $request->description,
                'enable' => $request->enable,
            ]);

            // save product category
            if ($categories = $request->category_id) {
                foreach ($categories as $category) {
                    CategoryProduct::create([
                        'product_id' => $product->id,
                        'category_id' => $category,
                    ]);
                }
            }

            // save product image
            $images = $request->file('image');
            if ($request->hasFile('image')) {
                foreach ($images as $image) {
                    $destination_path = public_path('uploads');
                    $name = date('YmdHis').rand(10,1000).'.'.$image->getClientOriginalExtension();

                    $img = Image::make($image->getRealPath());
                    $img->resize(600, 600, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destination_path.'/'.$name);

                    $image_save = ModelsImage::create([
                        'name' => $name,
                        'file' => url('/uploads').'/'.$name,
                        'enable' => $request->enable,
                    ]);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_id' => $image_save->id,
                    ]);
                }
            }

            return response()->json([
                'code' => 200,
                'message' => 'SUCCESS',
                'result' => $product,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $product = Product::with('category', 'image')->findOrFail($id);

            return response()->json([
                'code' => 200,
                'message' => 'SUCCESS',
                'result' => $product,
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'NOT FOUND'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'enable' => 'required|boolean',
            ]);

            $product = Product::with('category', 'image')->findOrFail($id);
            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'enable' => $request->enable,
            ]);

            // update product category
            if ($categories = $request->category_id) {
                foreach ($categories as $category) {
                    CategoryProduct::updateOrCreate(
                        [
                            'product_id' => $id,
                        ],
                        [
                            'category_id' => $category,
                        ]
                    );
                }
            }

            // update product image
            $images = $request->file('image');
            if ($request->hasFile('image')) {
                foreach ($images as $image) {
                    $destination_path = public_path('uploads');
                    $name = date('YmdHis').rand(10,1000).'.'.$image->getClientOriginalExtension();

                    $img = Image::make($image->getRealPath());
                    $img->resize(600, 600, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destination_path.'/'.$name);

                    $image_save = ModelsImage::create([
                        'name' => $name,
                        'file' => url('/uploads').'/'.$name,
                        'enable' => $request->enable,
                    ]);

                    ProductImage::updateOrCreate(
                        [
                            'product_id' => $id,
                        ],
                        [
                            'image_id' => $image_save->id,
                        ]
                    );
                }
            }

            return response()->json([
                'code' => 200,
                'message' => 'SUCCESS',
                'result' => $product,
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'NOT FOUND'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            if ($category = CategoryProduct::where('product_id', $id)->get()) {
                CategoryProduct::where('product_id', $id)->delete();
            }

            if ($image = ProductImage::where('product_id', $id)->get()) {
                ProductImage::where('product_id', $id)->delete();
            }

            return response()->json([
                'code' => 200,
                'message' => 'SUCCESS',
                'result' => $product,
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => 404,
                'message' => 'NOT FOUND'
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
