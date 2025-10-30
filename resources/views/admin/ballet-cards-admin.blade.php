<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $bg = 'light';
    $text = 'dark';
    $gradient = 'primary';
} else {
    $bg = 'dark';
    $text = 'light';
    $gradient = 'dark';
}
?>
@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content ">
            <div class="panel-header bg-{{ $gradient }}-gradient">
                <div class="py-5 page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                        <div>
                            <h2 class="pb-2 text-white fw-bold">{{ __('Ballet Card Submissions') }}</h2>
                            <h5 class="mb-2 text-white op-7">Manage Ballet Card linking requests</h5>
                        </div>
                    </div>
                </div>
            </div>
            <x-danger-alert />
            <x-success-alert />
            <div class="page-inner mt--5">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('All Ballet Card Submissions') }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
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
                                                        <span class="badge {{ $card->status == 'pending' ? 'badge-warning' : ($card->status == 'approved' ? 'badge-success' : 'badge-danger') }}">
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
            </div>
        </div>
    </div>
@endsection
