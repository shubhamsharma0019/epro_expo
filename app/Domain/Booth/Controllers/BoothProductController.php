<?php

namespace App\Domain\Booth\Controllers;

use App\Http\Requests\Company\BoothProductRequest;
use App\Domain\Booth\Models\BoothBooking;
use App\Domain\Booth\Models\BoothProduct;
use App\Domain\Booth\Services\BoothFileUploadService;
use App\Domain\Booth\Services\BoothSetupStepService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BoothProductController extends BaseBoothSetupController
{
    public function index(BoothBooking $booking, BoothSetupStepService $steps): View
    {
        $booking = $this->setupBooking($booking);
        $productsQuery = $booking->boothProducts()->latest();

        if ($search = request('search')) {
            $productsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('category', 'like', '%' . $search . '%')
                    ->orWhere('short_description', 'like', '%' . $search . '%');
            });
        }

        if ($category = request('category')) {
            $productsQuery->where('category', $category);
        }

        $categories = $booking->boothProducts()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('company.booth-setup.products', $this->commonData($booking, $steps) + [
            'products' => $productsQuery->paginate(5)->withQueryString(),
            'categories' => $categories,
        ]);
    }

    public function create(BoothBooking $booking, BoothSetupStepService $steps): View
    {
        $booking = $this->setupBooking($booking);
        $categories = $booking->boothProducts()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('company.booth-setup.products', $this->commonData($booking, $steps) + [
            'product' => null,
            'products' => $booking->boothProducts()->latest()->paginate(5),
            'categories' => $categories,
            'showProductForm' => true,
        ]);
    }

    public function show(BoothBooking $booking, BoothProduct $product, BoothSetupStepService $steps): View
    {
        return $this->edit($booking, $product, $steps);
    }

    public function store(BoothProductRequest $request, BoothBooking $booking, BoothFileUploadService $files, BoothSetupStepService $steps): RedirectResponse
    {
        $booking = $this->setupBooking($booking);
        $data = $request->validated();
        if ($request->hasFile('product_image')) {
            $data['product_image'] = $files->upload($request->file('product_image'), $booking->id, 'products');
        }
        $data += ['company_id' => $booking->company_id, 'booth_booking_id' => $booking->id];
        BoothProduct::create($data);
        if ($booking->boothProducts()->where('status', 'published')->exists()) {
            $steps->markStepCompleted($booking, 'products');
        } else {
            $steps->markStepInProgress($booking, 'products');
        }
        return redirect()->route('company.booth-setup.products.index', $booking)->with('status', 'Product saved.');
    }

    public function edit(BoothBooking $booking, BoothProduct $product, BoothSetupStepService $steps): View
    {
        abort_unless($product->company_id === (int) session('company_id') && $product->booth_booking_id === $booking->id, 403);
        $booking = $this->setupBooking($booking);
        $categories = $booking->boothProducts()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('company.booth-setup.products', $this->commonData($booking, $steps) + [
            'product' => $product,
            'products' => $booking->boothProducts()->latest()->paginate(5),
            'categories' => $categories,
            'showProductForm' => true,
        ]);
    }

    public function update(BoothProductRequest $request, BoothBooking $booking, BoothProduct $product, BoothFileUploadService $files, BoothSetupStepService $steps): RedirectResponse
    {
        abort_unless($product->company_id === (int) session('company_id') && $product->booth_booking_id === $booking->id, 403);
        $booking = $this->setupBooking($booking);
        $data = $request->validated();
        if ($request->hasFile('product_image')) {
            $data['product_image'] = $files->upload($request->file('product_image'), $booking->id, 'products', $product->product_image);
        }
        $product->update($data);
        $booking->boothProducts()->where('status', 'published')->exists()
            ? $steps->markStepCompleted($booking, 'products')
            : $steps->markStepInProgress($booking, 'products');
        return redirect()->route('company.booth-setup.products.index', $booking)->with('status', 'Product updated.');
    }

    public function destroy(BoothBooking $booking, BoothProduct $product, BoothFileUploadService $files, BoothSetupStepService $steps): RedirectResponse
    {
        abort_unless($product->company_id === (int) session('company_id') && $product->booth_booking_id === $booking->id, 403);
        $booking = $this->setupBooking($booking);
        $files->delete($product->product_image);
        $product->delete();
        $booking->boothProducts()->where('status', 'published')->exists()
            ? $steps->markStepCompleted($booking, 'products')
            : $steps->markStepPending($booking, 'products');
        return back()->with('status', 'Product deleted.');
    }
}
