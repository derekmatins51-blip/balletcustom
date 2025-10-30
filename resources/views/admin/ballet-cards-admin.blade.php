@extends('layouts.app') {{-- main layout for the admin dashboard --}}

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Ballet Card Submissions') }}</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <table id="balletCardsTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Submission Date</th>
                                <th>Status</th>
                                <th>Front Image</th>
                                <th>Back Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($balletCards as $card)
                                <tr>
                                    <td>{{ $card->id }}</td>
                                    <td>{{ $card->user->name ?? 'N/A' }} ({{ $card->user->email ?? 'N/A' }})</td>
                                    <td>{{ $card->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <span class="badge {{ $card->status == 'pending' ? 'bg-warning' : ($card->status == 'approved' ? 'bg-success' : 'bg-danger') }}">
                                            {{ ucfirst($card->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.ballet-cards.download-image', ['path' => $card->front_image_path]) }}" class="btn btn-sm btn-info" target="_blank">Download Front</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.ballet-cards.download-image', ['path' => $card->back_image_path]) }}" class="btn btn-sm btn-info" target="_blank">Download Back</a>
                                    </td>
                                    <td>
                                        @if ($card->status == 'pending')
                                            <form action="{{ route('admin.ballet-cards.approve', $card->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                            </form>
                                            <form action="{{ route('admin.ballet-cards.deny', $card->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">Deny</button>
                                            </form>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled>No Action</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
