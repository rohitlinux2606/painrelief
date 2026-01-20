<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\Product;
use App\Models\ProductVideos;

class ProductVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Eager load product to avoid N+1 queries
        $query = ProductVideos::with('product');

        // 🔍 Search: Product Title or Video URL
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('video_url', 'like', '%' . $request->search . '%')
                    ->orWhereHas('product', function ($qp) use ($request) {
                        $qp->where('title', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // 📦 Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $videos = $query->orderBy('id', 'DESC')
            ->paginate(15)
            ->withQueryString();

        return view('admin.pages.products.videos.index', compact('videos'));
    }


    /**
     * Show the form for creating a new product video.
     */
    public function create()
    {
        $title = "Add Product Video (Shorts)";
        // $products = Product::where('status', 'active')->orderBy('title', 'ASC')->get();
        $products = Product::orderBy('title', 'ASC')->get();
        return view('admin.pages.products.videos.create', compact('title', 'products'));
    }

    /**
     * Store a newly created product video in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'video_url'  => 'required|url',
            'status'     => 'required|in:1,0',
        ], [
            'product_id.required' => 'Please select a product.',
            'video_url.required'  => 'Video URL is required.',
        ]);


        try {
            ProductVideos::create([
                'product_id' => $request->product_id,
                'video_url'  => $request->video_url,
                'status'     => $request->status,
            ]);

            return redirect()->route('admin.product-control.product-videos.index')
                ->with('success', 'Product video added successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $video = ProductVideos::findOrFail($id);
        $title = "Edit Product Video";

        // Sabhi active products dropdown ke liye
        $products = Product::orderBy('title', 'ASC')->get();

        return view('admin.pages.products.videos.edit', compact('title', 'video', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'video_url'  => 'required|url',
            'status'     => 'required|in:1,0',
        ]);

        try {
            $video = ProductVideos::findOrFail($id);

            $video->update([
                'product_id' => $request->product_id,
                'video_url'  => $request->video_url,
                'status'     => $request->status,
            ]);

            return redirect()->route('admin.product-control.product-videos.index')
                ->with('success', 'Product video updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            ProductVideos::findOrFail($id)->delete();

            return redirect()->back()->with('success', 'Video Deleted Successfully.');
        } catch (\Exception $e) {
            Log::error("Tour Delete Error: " . $e->getMessage());
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function extractVideoID($url)
    {
        $regExp = '/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=|shorts\/)([^#\&\?]*).*/';

        preg_match($regExp, $url, $matches);

        return (isset($matches[2]) && strlen($matches[2]) == 11) ? $matches[2] : false;
    }
}
