<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends DashboardController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->simplePaginate(2);

        return view('dashboard.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:2|max:255',
            'price' => 'required|numeric',
            'body' => 'nullable',
            'image' => 'required|mimes:jpg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // تولید نام منحصر به فرد برای فایل
        $imageName = Str::uuid()->toString() . '.' . $request->image->extension();

        // ذخیره تصویر در public/images/products
        $imagePath = $request->file('image')->move(public_path('images/products'), $imageName);

        // ذخیره اطلاعات محصول
        $product = Product::create([
            'title' => $request->title,
            'body' => $request->body,
            'price' => $request->price,
            'image_url' => 'images/products/' . $imageName,
        ]);

        return redirect(route('dashboard.product.index'));
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('dashboard.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // اعتبارسنجی ورودی‌ها
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:2|max:255',
            'price' => 'required|numeric',
            'body' => 'nullable',
            'image' => 'nullable|mimes:jpg,png|max:2048', // تصویر دیگر الزامی نیست
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // بررسی و مدیریت فایل جدید
        if ($request->hasFile('image')) {
            $imageName = Str::uuid()->toString() . '.' . $request->image->extension();
            $imagePath = public_path('images/products');

            // حذف تصویر قبلی از پوشه public
            if ($product->image_url && file_exists(public_path($product->image_url))) {
                unlink(public_path($product->image_url));
            }

            // ذخیره تصویر جدید در پوشه public/images/products
            $request->file('image')->move($imagePath, $imageName);
            $product->image_url = 'images/products/' . $imageName;
        }

        // به‌روزرسانی اطلاعات محصول
        $product->update([
            'title' => $request->title,
            'body' => $request->body,
            'price' => $request->price,
            'image_url' => $product->image_url ?? $product->getOriginal('image_url'), // در صورت تغییر نکردن تصویر، مقدار قبلی باقی بماند
        ]);

        return redirect(route('dashboard.product.index'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect(route('dashboard.product.index'));
    }
}
