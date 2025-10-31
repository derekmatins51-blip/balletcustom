<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BalletCard;
use Illuminate\Support\Facades\Storage;

class BalletCardAdminController extends Controller
{
    /**
     * Display a listing of Ballet Card submissions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $balletCards = BalletCard::with('user')->latest()->paginate(10); // Paginate with 10 items per page
        return view('admin.ballet-cards-admin', compact('balletCards'));
    }

    /**
     * Approve the specified Ballet Card submission.
     *
     * @param  \App\Models\BalletCard  $balletCard
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(BalletCard $balletCard)
    {
        $balletCard->status = 'approved';
        $balletCard->save();

        return redirect()->back()->with('success', 'Ballet Card submission approved.');
    }

    /**
     * Deny the specified Ballet Card submission.
     *
     * @param  \App\Models\BalletCard  $balletCard
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deny(BalletCard $balletCard)
    {
        $balletCard->status = 'denied';
        $balletCard->save();

        return redirect()->back()->with('success', 'Ballet Card submission denied.');
    }

    /**
     * Lock the specified Ballet Card.
     *
     * @param  \App\Models\BalletCard  $balletCard
     * @return \Illuminate\Http\RedirectResponse
     */
    public function lock(BalletCard $balletCard)
    {
        $balletCard->status = 'locked';
        $balletCard->save();

        return redirect()->back()->with('success', 'Ballet Card locked successfully.');
    }

    /**
     * Unlock the specified Ballet Card.
     *
     * @param  \App\Models\BalletCard  $balletCard
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unlock(BalletCard $balletCard)
    {
        $balletCard->status = 'approved'; // Assuming 'approved' is the active state after unlocking
        $balletCard->save();

        return redirect()->back()->with('success', 'Ballet Card unlocked successfully.');
    }

    /**
     * Restrict the specified Ballet Card.
     *
     * @param  \App\Models\BalletCard  $balletCard
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restrict(BalletCard $balletCard)
    {
        $balletCard->status = 'restricted';
        $balletCard->save();

        return redirect()->back()->with('success', 'Ballet Card restricted successfully.');
    }

    /**
     * Unrestrict the specified Ballet Card.
     *
     * @param  \App\Models\BalletCard  $balletCard
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unrestrict(BalletCard $balletCard)
    {
        $balletCard->status = 'approved'; // Assuming 'approved' is the active state after unrestricting
        $balletCard->save();

        return redirect()->back()->with('success', 'Ballet Card unrestricted successfully.');
    }

    /**
     * Show the form for editing the specified Ballet Card.
     *
     * @param  \App\Models\BalletCard  $balletCard
     * @return \Illuminate\View\View
     */
    public function view(BalletCard $balletCard)
    {
        $title = 'View Ballet Card';
        return view('admin.ballet-cards.view', compact('balletCard', 'title'));
    }

    /**
     * Update the specified Ballet Card in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BalletCard  $balletCard
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, BalletCard $balletCard)
    {
        $request->validate([
            'primary_account_type' => 'required|string|in:BTC,ETH,USDT,LTC',
            'primary_account_deposit_address' => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:8',
            'pass_phrase' => 'required|string|max:255',
            'currency' => 'required|string|max:10',
        ]);

        $balletCard->update($request->only([
            'primary_account_type',
            'primary_account_deposit_address',
            'serial_number',
            'pass_phrase',
            'currency',
        ]));

        return redirect()->back()->with('success', 'Ballet Card details updated successfully.');
    }

    /**
     * Top up the specified Ballet Card.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BalletCard  $balletCard
     * @return \Illuminate\Http\RedirectResponse
     */
    public function topup(Request $request, BalletCard $balletCard)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $balletCard->balance += $request->amount;
        $balletCard->save();

        // Optionally record transaction
        // CardTransaction::create([...]);

        return redirect()->back()->with('success', 'Ballet Card topped up successfully.');
    }

    /**
     * Deduct from the specified Ballet Card.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BalletCard  $balletCard
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deduct(Request $request, BalletCard $balletCard)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $balletCard->balance,
        ]);

        $balletCard->balance -= $request->amount;
        $balletCard->save();

        // Optionally record transaction
        // CardTransaction::create([...]);

        return redirect()->back()->with('success', 'Amount deducted from Ballet Card successfully.');
    }

    /**
     * Delete the specified Ballet Card.
     *
     * @param  \App\Models\BalletCard  $balletCard
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(BalletCard $balletCard)
    {
        $balletCard->delete();
        return redirect()->route('admin.ballet-cards.index')->with('success', 'Ballet Card deleted successfully.');
    }

    /**
     * Download the specified image.
     *
     * @param  string  $path
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadImage($path)
    {
        if (Storage::disk('public')->exists($path)) {
            $absolutePath = storage_path('app/public/' . $path);
            return response()->download($absolutePath);
        }

        return redirect()->back()->with('error', 'Image not found.');
    }
}
