<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Models\Product;
use App\Models\ProductImage;

class Productcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query(); // Eager loading categories

        // फिल्टर: Search (Title, SKU, or Brand)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('sku', 'like', '%' . $request->search . '%')
                    ->orWhere('brand', 'like', '%' . $request->search . '%');
            });
        }

        // // फिल्टर: Category
        // if ($request->filled('category_id')) {
        //     $query->where('category_id', $request->category_id);
        // }

        // फिल्टर: Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->orderBy('id', 'DESC')
            ->paginate(15)
            ->withQueryString();

        // // फिल्टर्स के लिए कैटेगरीज भेजें
        // $categories = \App\Models\Category::all();

        return view('admin.pages.products.index', compact('products'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title      = "New Product";
        return view('admin.pages.products.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info($request->all());
        // 1. डेटा वैलिडेशन
        $validated = $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'price'             => 'required|numeric|min:0',
            'compare_at_price'  => 'nullable|numeric|gt:price',
            'cost_per_item'     => 'nullable|numeric|min:0',
            'sku'               => 'nullable|string|unique:products,sku',
            'barcode'           => 'nullable|string',
            'stock_quantity'    => 'nullable|integer|min:0',
            'status'            => 'required|in:active,draft,archived',
            'category_id'       => 'nullable|exists:categories,id',
            'brand'             => 'nullable|string|max:255',
            'thumbnail'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Max 2MB
            'external_link'     => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            // 2. इमेज अपलोड हैंडल करना
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath =  uploadFile($request->file('thumbnail'), 'uploads/');
            }

            // 3. डेटाबेस में प्रोडक्ट क्रिएट करना
            $product = Product::create([
                'title'             => $request->title,
                'slug'              => Str::slug($request->title), // Auto-generate Slug
                'description'       => $request->description,
                'price'             => $request->price,
                'compare_at_price'  => $request->compare_at_price,
                'cost_per_item'     => $request->cost_per_item,
                'sku'               => $request->sku,
                'barcode'           => $request->barcode,
                'stock_quantity'    => $request->stock_quantity ?? 0,
                'track_quantity'    => $request->has('track_quantity'), // Checkbox handling
                'status'            => $request->status,
                // 'category_id'       => $request->category_id,
                'brand'             => $request->brand,
                'thumbnail'         => $thumbnailPath,
                'external_link'     => $request->external_link,
            ]);

            // 3. गैलरी इमेजेस हैंडल करें
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = uploadFile($image, 'uploads/products/gallery/');

                    // product_images टेबल में एंट्री करें
                    $product->images()->create([
                        'image_path' => $path
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.product-control.product.index')
                ->with('success', 'Product created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            // अगर एरर आए और इमेज अपलोड हो चुकी हो, तो उसे डिलीट कर दें
            if ($thumbnailPath) {
                deleteFile($thumbnailPath);
            }

            Log::error("Product Store Error: " . $e->getMessage());
            return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title      = "Edit Product Detail";
        $product    = Product::findOrFail($id);
        return view('admin.pages.products.edit', compact('title', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // 1. डेटा वैलिडेशन (SKU को छोड़कर बाकी सेम, SKU में खुद की ID इग्नोर करें)
        $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'price'             => 'required|numeric|min:0',
            'compare_at_price'  => 'nullable|numeric|gt:price',
            'sku'               => 'nullable|string|unique:products,sku,' . $product->id,
            'status'            => 'required|in:active,draft,archived',
            'thumbnail'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'external_link'     => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();

            // चेकबॉक्स हैंडलिंग
            $data['track_quantity'] = $request->has('track_quantity') ? 1 : 0;

            // 2. इमेज अपडेट लॉजिक
            if ($request->hasFile('thumbnail')) {
                // पुरानी इमेज डिलीट करें (अगर है तो)
                if ($product->thumbnail) {
                    deleteFile($product->thumbnail);
                }
                // नई इमेज अपलोड करें
                $data['thumbnail'] = uploadFile($request->file('thumbnail'), 'uploads/');
            }

            // 3. डेटा अपडेट करें
            $product->update($data);

            // 4. गैलरी में नई इमेजेस जोड़ना (Append)
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = uploadFile($image, 'uploads/products/gallery/');
                    $product->images()->create(['image_path' => $path]);
                }
            }

            DB::commit();
            return redirect()->route('admin.product-control.product.index')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Product Update Error: " . $e->getMessage());
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Product::findOrFail($id)->delete();

            return redirect()->back()->with('success', 'Product Deleted Successfully.');
        } catch (\Exception $e) {
            Log::error("Tour Delete Error: " . $e->getMessage());
            return back()->with('error', 'Something went wrong.');
        }
    }


    public function deleteImage(Request $request)
    {
        $image = ProductImage::findOrFail($request->id);

        // फाइल सिस्टम से फोटो हटाएँ
        if (file_exists(public_path($image->image_path))) {
            unlink(public_path($image->image_path));
        }

        $image->delete();
        return response()->json(['success' => true]);
    }

    public function generateLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'platform'   => 'required|string',
            'campaign_name' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        try {
            $product = Product::findOrFail($request->product_id);

            // UTM Params Build
            $utmSource = Str::slug($request->platform);
            $utmMedium = 'cpc'; // Default
            $utmCampaign = $request->campaign_name ? Str::slug($request->campaign_name) : 'general';

            $baseUrl = route('product-detail', $product->id);
            $generatedUrl = $baseUrl . "?utm_source={$utmSource}&utm_medium={$utmMedium}&utm_campaign={$utmCampaign}";

            // Creating the link record
            $link = \App\Models\MarketingLink::create([
                'product_id'    => $product->id,
                'platform'      => $request->platform,
                'campaign_name' => $request->campaign_name,
                'utm_source'    => $utmSource,
                'utm_medium'    => $utmMedium,
                'utm_campaign'  => $utmCampaign,
                'generated_url' => $generatedUrl,
            ]);

            return response()->json([
                'success' => true,
                'link' => $link,
                'message' => 'Marketing link generated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
