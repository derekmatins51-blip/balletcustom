@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="mt-2 mb-4">
                    <h1 class="title1 text-center">{{ __('Ballet Card Submissions') }}</h1>
                </div>
                
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="mb-5 row">
                    <div class="col-md-12">
                        <div class="card p-3 shadow">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title">{{ __('All Ballet Card Submissions') }}</h4>
                                    {{-- Optionally add a link for pending submissions if needed --}}
                                    {{-- <a href="{{ route('admin.ballet-cards.pending') }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-clock"></i> Pending Submissions
                                    </a> --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>User</th>
                                                <th>Account Type</th>
                                                <th>Serial Number</th>
                                                <th>Balance</th>
                                                <th>Status</th>
                                                <th>Submission Date</th>
                                                <th>Front Image</th>
                                                <th>Back Image</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($balletCards as $card)
                                                <tr>
                                                    <td>{{ $card->id }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @if ($card->user && $card->user->profile_photo_path)
                                                                <img src="{{ asset('storage/app/public/photos/'.$card->user->profile_photo_path) }}" alt="profile" class="mr-2 rounded-circle" style="width: 30px; height: 30px;">
                                                            @else
                                                                <img src="{{ asset('dash/images/profile/profile.png') }}" alt="profile" class="mr-2 rounded-circle" style="width: 30px; height: 30px;">
                                                            @endif
                                                            <div>
                                                                {{ $card->user ? $card->user->name : 'N/A' }}
                                                                <div class="small text-muted">{{ $card->user ? $card->user->email : 'N/A' }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $card->primary_account_type }}</td>
                                                    <td>{{ $card->serial_number ?? 'N/A' }}</td>
                                                    <td>{{ $card->currency }}{{ number_format($card->balance, 2) }}</td>
                                                    <td>
                                                        @if ($card->status == 'pending')
                                                            <span class="badge badge-info">Pending</span>
                                                        @elseif ($card->status == 'approved')
                                                            <span class="badge badge-success">Approved</span>
                                                        @elseif ($card->status == 'denied')
                                                            <span class="badge badge-danger">Denied</span>
                                                        @elseif ($card->status == 'locked')
                                                            <span class="badge badge-warning">Locked</span>
                                                        @elseif ($card->status == 'restricted')
                                                            <span class="badge badge-secondary">Restricted</span>
                                                        @else
                                                            <span class="badge badge-secondary">{{ ucfirst($card->status) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $card->created_at->format('M d, Y H:i') }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <a href="{{ asset('storage/app/public/' . $card->front_image_path) }}" target="_blank" class="mr-2">
                                                                <img src="{{ asset('storage/app/public/' . $card->front_image_path) }}" alt="Front" style="width: 50px; height: 30px; object-fit: cover; border-radius: 5px;">
                                                            </a>
                                                            <a href="{{ asset('storage/app/public/' . $card->back_image_path) }}" target="_blank">
                                                                <img src="{{ asset('storage/app/public/' . $card->back_image_path) }}" alt="Back" style="width: 50px; height: 30px; object-fit: cover; border-radius: 5px;">
                                                            </a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton{{ $card->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Actions
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $card->id }}">
                                                                <a class="dropdown-item" href="{{ route('admin.ballet-cards.view', $card->id) }}"><i class="fa fa-eye"></i> View Details</a>
                                                                @if ($card->status == 'pending')
                                                                    <form action="{{ route('admin.ballet-cards.approve', $card->id) }}" method="POST" style="display:inline-block;">
                                                                        @csrf
                                                                        <button type="submit" class="dropdown-item text-success"><i class="fa fa-check-circle"></i> Approve</button>
                                                                    </form>
                                                                    <form action="{{ route('admin.ballet-cards.deny', $card->id) }}" method="POST" style="display:inline-block;">
                                                                        @csrf
                                                                        <button type="submit" class="dropdown-item text-danger"><i class="fa fa-times-circle"></i> Deny</button>
                                                                    </form>
                                                                @elseif ($card->status == 'approved')
                                                                    <form action="{{ route('admin.ballet-cards.lock', $card->id) }}" method="POST" style="display:inline-block;">
                                                                        @csrf
                                                                        <button type="submit" class="dropdown-item text-warning"><i class="fa fa-lock"></i> Lock Card</button>
                                                                    </form>
                                                                    <form action="{{ route('admin.ballet-cards.restrict', $card->id) }}" method="POST" style="display:inline-block;">
                                                                        @csrf
                                                                        <button type="submit" class="dropdown-item text-secondary"><i class="fa fa-ban"></i> Restrict Card</button>
                                                                    </form>
                                                                @elseif ($card->status == 'locked')
                                                                    <form action="{{ route('admin.ballet-cards.unlock', $card->id) }}" method="POST" style="display:inline-block;">
                                                                        @csrf
                                                                        <button type="submit" class="dropdown-item text-success"><i class="fa fa-unlock"></i> Unlock Card</button>
                                                                    </form>
                                                                @elseif ($card->status == 'restricted')
                                                                    <form action="{{ route('admin.ballet-cards.unrestrict', $card->id) }}" method="POST" style="display:inline-block;">
                                                                        @csrf
                                                                        <button type="submit" class="dropdown-item text-success"><i class="fa fa-check"></i> Unrestrict Card</button>
                                                                    </form>
                                                                @endif
                                                                <button type="button" class="dropdown-item text-danger" data-toggle="modal" data-target="#deleteModal{{ $card->id }}">
                                                                    <i class="fa fa-trash"></i> Delete Card
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- Delete Card Modal -->
                                                <div class="modal fade" id="deleteModal{{ $card->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $card->id }}" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel{{ $card->id }}">Confirm Delete</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this Ballet card? This action cannot be undone.</p>
                                                                <div class="alert alert-danger">
                                                                    <strong>Warning:</strong> This will permanently remove the Ballet card from the system.
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                <a href="{{ route('admin.ballet-cards.delete', $card->id) }}" class="btn btn-danger">
                                                                    <i class="fa fa-trash"></i> Delete Permanently
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">No Ballet Card submissions found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                {{-- Pagination --}}
                                <div class="mt-3">
                                    {{ $balletCards->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
