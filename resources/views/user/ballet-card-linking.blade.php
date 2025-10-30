@extends('layouts.app') {{-- Assuming a main layout for the user dashboard --}}

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Ballet Card Linking and Verification') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="card-style mb-4 p-4 border rounded">
                        <h5 class="card-title">Instructions and Guidelines</h5>
                        <ul>
                            <li>Ensure your Ballet Card is clean and in a well-lit Environment.</li>
                            <li>Peel off the QR-code sticker from the card carefully.</li>
                            <li>Scratch off the security layer to reveal Your PASS-PHRASE.</li>
                            <li>Take clear photos of both the front and back of the card.</li>
                            <li>All details on the card (e.g., card number, security features) must be clearly visible.</li>
                            <li>Only upload image files (JPG, PNG).</li>
                            <li>Each image should not exceed 5MB in size.</li>
                        </ul>
                    </div>

                    <form method="POST" action="{{ route('user.ballet-cards.link') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="front_image" class="form-label">Front of Ballet Card</label>
                            <input type="file" class="form-control @error('front_image') is-invalid @enderror" id="front_image" name="front_image" required>
                            @error('front_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="back_image" class="form-label">Back of Ballet Card</label>
                            <input type="file" class="form-control @error('back_image') is-invalid @enderror" id="back_image" name="back_image" required>
                            @error('back_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Submit for Verification</button>
                    </form>

                    <h5 class="mt-5">Your Linked Ballet Cards</h5>
                    @if ($userBalletCards->isEmpty())
                        <p>You have no Ballet Cards linked yet.</p>
                    @else
                        <table class="table table-striped mt-3">
                            <thead>
                                <tr>
                                    <th>Submission Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userBalletCards as $card)
                                    <tr>
                                        <td>{{ $card->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <span class="badge {{ $card->status == 'pending' ? 'bg-warning' : ($card->status == 'approved' ? 'bg-success' : 'bg-danger') }}">
                                                {{ ucfirst($card->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            {{-- Optionally add view/download links for images if needed by user --}}
                                            {{-- <a href="{{ Storage::url($card->front_image_path) }}" target="_blank" class="btn btn-sm btn-info">View Front</a> --}}
                                            {{-- <a href="{{ Storage::url($card->back_image_path) }}" target="_blank" class="btn btn-sm btn-info">View Back</a> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
