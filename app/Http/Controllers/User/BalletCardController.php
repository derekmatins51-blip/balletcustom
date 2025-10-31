<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\BalletCard;

class BalletCardController extends Controller
{
    /**
     * Display the Ballet Card linking form.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkingForm()
    {
        $userBalletCards = Auth::user()->balletCards;
        return view('user.ballet-card-linking');
    }

    /**
     * Handle the Ballet Card linking submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function linkCard(Request $request)
    {
        $request->validate([
            'front_image' => 'required|image|max:5120', // Max 5MB
            'back_image' => 'required|image|max:5120',  // Max 5MB
        ]);

        $user = Auth::user();

        // Store images
        $frontImagePath = $request->file('front_image')->store('ballet_cards', 'public');
        $backImagePath = $request->file('back_image')->store('ballet_cards', 'public');

        BalletCard::create([
            'user_id' => $user->id,
            'front_image_path' => $frontImagePath,
            'back_image_path' => $backImagePath,
            'status' => 'pending',
        ]);

        return redirect()->route('cards')->with('success', 'Ballet Card Linking In Progress. It will appear on your cards page once approved.');
    }
}
