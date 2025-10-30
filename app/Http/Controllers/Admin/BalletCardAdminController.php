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
        $balletCards = BalletCard::with('user')->latest()->get();
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
