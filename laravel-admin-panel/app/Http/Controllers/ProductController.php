<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(3);
        return view('products.index', compact('products'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'primary_image' => 'required|image',
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'description' => 'required',
            'price' => 'required|integer',
            'status' => 'required|integer',
            'quantity' => 'required|integer',
            'sale_price' => 'nullable|integer',
            'date_on_sale_from' => 'nullable|date_format:Y/m/d H:i:s',
            'date_on_sale_to' => 'nullable|date_format:Y/m/d H:i:s',
            'images.*' => 'nullable|image'
        ]);

        $primaryImageName = Carbon::now()->microsecond . '-' . $request->primary_image->getClientOriginalName();
        $request->file('primary_image')->move(public_path('images/products'), $primaryImageName);

        if ($request->has('images') && $request->images !== null) {
            $fileNameImages = [];
            foreach ($request->images as $image) {
                $fileNameImage = Carbon::now()->microsecond . '-' . $image->getClientOriginalName();
                $image->move(public_path('images/products'), $fileNameImage);
                array_push($fileNameImages, $fileNameImage);
            }
        }

        DB::beginTransaction();


        $product = Product::create([
            'name' => $request->name,
            'slug' => $this->makeSlug($request->name),
            'category_id' => $request->category_id,
            'primary_image' => $primaryImageName,
            'description' => $request->description,
            'status' => $request->status,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'sale_price' => $request->has('sale_price') ? $request->sale_price : 0,
            'date_on_sale_from' => $request->date_on_sale_from !== null ? getMiladiDate($request->date_on_sale_from) : null,
            'date_on_sale_to' => $request->date_on_sale_to !== null ? getMiladiDate($request->date_on_sale_to) : null,
        ]);

        if ($request->has('images') && $request->images !== null) {
            foreach ($fileNameImages as $fileNameImage) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $fileNameImage
                ]);
            }
        }

        DB::commit();

        return redirect()->route('product.index')->with('success', 'محصول با موفقیت ایجاد شد');
    }
    public function makeSlug($string)
    {
        $slug = slugify($string);
        $count = Product::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        $result = $count ? "{$slug}-{$count}" : $slug;

        return $result;
    }
    public function show(Product $product)
    {
        $categories = Category::all();
        return view('products.show', compact('product', 'categories'));
    }
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'primary_image' => 'nullable|image',
            'name' => 'required|string',
            'category_id' => 'required|integer',
            'description' => 'required',
            'price' => 'required|integer',
            'status' => 'required|integer',
            'quantity' => 'required|integer',
            'sale_price' => 'nullable|integer',
            'date_on_sale_from' => 'nullable|date_format:Y/m/d H:i:s',
            'date_on_sale_to' => 'nullable|date_format:Y/m/d H:i:s',
            'images.*' => 'nullable|image'
        ]);

        if ($request->hasFile('primary_image')) {
            if ($product->primary_image) {
                File::delete(public_path('images/products/' . $product->primary_image));
            }
            $primaryImageName = Carbon::now()->microsecond . '-' . $request->primary_image->getClientOriginalName();
            $request->file('primary_image')->move(public_path('images/products'), $primaryImageName);
        } else {
            $primaryImageName = $product->primary_image;
        }

        $fileNameImages = [];
        if ($request->hasFile('images')) {
            foreach ($product->images as $image) {
                File::delete(public_path('images/products/' . $image->image));
                $image->delete();
            }

            foreach ($request->file('images') as $image) {
                $fileNameImage = Carbon::now()->microsecond . '-' . $image->getClientOriginalName();
                $image->move(public_path('images/products'), $fileNameImage);
                $fileNameImages[] = $fileNameImage;
            }
        }

        DB::beginTransaction();

        try {
            $product->update([
                'name' => $request->name,
                'slug' => $request->name != $product->name ? $this->makeSlug($request->name) : $product->slug,
                'category_id' => $request->category_id,
                'primary_image' => $primaryImageName,
                'description' => $request->description,
                'status' => $request->status,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'sale_price' => $request->sale_price ?? 0,
                'date_on_sale_from' => $request->date_on_sale_from ? getMiladiDate($request->date_on_sale_from) : null,
                'date_on_sale_to' => $request->date_on_sale_to ? getMiladiDate($request->date_on_sale_to) : null,
            ]);

            foreach ($fileNameImages as $fileNameImage) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $fileNameImage
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'خطا در ویرایش محصول: ' . $e->getMessage());
        }

        return redirect()->route('product.index')->with('success', 'محصول با موفقیت ویرایش شد');
    }

    public function destroy($id)
    {
        $item = Product::findOrFail($id);

        $item->delete();
        return redirect()->route('product.index')->with('warning', ' محصول با موفقیت حذف شد.');
    }
}
