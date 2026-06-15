<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $productId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $productId)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'name' => Auth::check() ? 'nullable|string' : 'required|string|max:255',
            'email' => Auth::check() ? 'nullable|email' : 'required|email|max:255',
        ]);

        Review::create(array_merge($validated, [
            'product_id' => $productId,
            'user_id' => Auth::id(),
        ]));

        return back()->with('success', 'Your review has been submitted successfully.');
    }
}