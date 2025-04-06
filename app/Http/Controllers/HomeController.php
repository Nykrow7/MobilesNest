<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class HomeController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get featured products for the homepage
        $featuredProducts = Product::with('images')
            ->where('is_featured', true)
            ->take(8)
            ->get();
            
        // Get latest products
        $latestProducts = Product::with('images')
            ->latest()
            ->take(8)
            ->get();
            
        // Get product categories for the navigation
        $categories = ProductCategory::withCount('products')
            ->having('products_count', '>', 0)
            ->get();
            
        return view('welcome', compact('featuredProducts', 'latestProducts', 'categories'));
    }
    
    /**
     * Display the about page.
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('about');
    }
    
    /**
     * Display the contact page.
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        return view('contact');
    }
    
    /**
     * Process the contact form submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        
        // Here you would typically send an email or store the contact request
        // For now, we'll just redirect with a success message
        
        return redirect()->route('contact')
            ->with('success', 'Your message has been sent successfully!');
    }
}