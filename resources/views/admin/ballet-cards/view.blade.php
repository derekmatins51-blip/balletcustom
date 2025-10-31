@extends('layouts.app')
@section('content')
    @include('admin.topmenu')
    @include('admin.sidebar')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="mt-2 mb-4">
                    <h1 class="title1 text-center">{{ $title }}</h1>
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

                <div class="row">
                    <div class="col-md-5">
                        <div class="card p-3 shadow">
                            <div class="card-header">
                                <h4 class="card-title">Ballet Card Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="card mb-4 text-white" style="background-image: linear-gradient(45deg, #7e57c2, #5e35b1); border-radius: 15px;">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-4">
                                            <div>
                                                <img src="{{ asset('dash/images/cards/chip.png') }}" alt="Card Chip" height="40">
                                            </div>
                                            <div>
                                                <h5 class="text-white mb-0">Ballet Card</h5>
                                            </div>
                                        </div>
                                        <h5 class="text-white mb-3">
                                            Passphrase: **** **** **** {{ substr($balletCard->pass_phrase, -4) }}
                                        </h5>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <small class="text-white-50">ACCOUNT TYPE</small>
                                                <p class="text-white mb-0">{{ $balletCard->primary_account_type }}</p>
                                            </div>
                                            <div>
                                                <small class="text-white-50">SERIAL NUMBER</small>
                                                <p class="text-white mb-0">{{ $balletCard->serial_number ?? 'N/A' }}</p>
                                            </div>
                                            <div>
                                                <img src="{{ asset('dash/images/cards/visa.png') }}" alt="Card" height="30"> {{-- Placeholder image --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="font-weight-bold">Card ID</td>
                                                <td>{{ $balletCard->id }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Primary Account Type</td>
                                                <td>{{ $balletCard->primary_account_type }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Primary Account Deposit Address</td>
                                                <td>{{ $balletCard->primary_account_deposit_address }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Serial Number</td>
                                                <td>{{ $balletCard->serial_number ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">PassPhrase</td>
                                                <td>{{ $balletCard->pass_phrase }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Balance</td>
                                                <td>
                                                    <h4 class="text-primary mb-0">{{ $balletCard->currency }}{{ number_format($balletCard->balance, 2) }}</h4>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Status</td>
                                                <td>
                                                    @if ($balletCard->status == 'approved')
                                                        <span class="badge badge-success">Approved</span>
                                                    @elseif ($balletCard->status == 'pending')
                                                        <span class="badge badge-info">Pending</span>
                                                    @elseif ($balletCard->status == 'locked')
                                                        <span class="badge badge-warning">Locked</span>
                                                    @elseif ($balletCard->status == 'restricted')
                                                        <span class="badge badge-secondary">Restricted</span>
                                                    @elseif ($balletCard->status == 'denied')
                                                        <span class="badge badge-danger">Denied</span>
                                                    @else
                                                        <span class="badge badge-secondary">{{ $balletCard->status }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Created On</td>
                                                <td>{{ $balletCard->created_at->format('M d, Y h:i A') }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Last Updated</td>
                                                <td>{{ $balletCard->updated_at->format('M d, Y h:i A') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-3">
                                    <div>
                                        <a href="{{ route('admin.ballet-cards.index') }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-arrow-left"></i> Back to Ballet Cards
                                        </a>
                                    </div>
                                    <div>
                                        @if ($balletCard->status == 'pending')
                                            <form action="{{ route('admin.ballet-cards.approve', $balletCard->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check-circle"></i> Approve</button>
                                            </form>
                                            <form action="{{ route('admin.ballet-cards.deny', $balletCard->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times-circle"></i> Deny</button>
                                            </form>
                                        @elseif ($balletCard->status == 'approved')
                                            <form action="{{ route('admin.ballet-cards.lock', $balletCard->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-lock"></i> Lock Card</button>
                                            </form>
                                            <form action="{{ route('admin.ballet-cards.restrict', $balletCard->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-secondary btn-sm"><i class="fa fa-ban"></i> Restrict Card</button>
                                            </form>
                                        @elseif ($balletCard->status == 'locked')
                                            <form action="{{ route('admin.ballet-cards.unlock', $balletCard->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-unlock"></i> Unlock Card</button>
                                            </form>
                                        @elseif ($balletCard->status == 'restricted')
                                            <form action="{{ route('admin.ballet-cards.unrestrict', $balletCard->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Unrestrict Card</button>
                                            </form>
                                        @endif
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">
                                            <i class="fa fa-trash"></i> Delete Card
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- User Information -->
                        <div class="card p-3 shadow mt-4">
                            <div class="card-header">
                                <h4 class="card-title">Cardholder Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    @if ($balletCard->user && $balletCard->user->profile_photo_path)
                                        <img src="{{ asset('storage/app/public/photos/'.$balletCard->user->profile_photo_path) }}" alt="profile" class="mr-3 rounded-circle" style="width: 60px; height: 60px;">
                                    @else
                                        <img src="{{ asset('dash/images/profile/profile.png') }}" alt="profile" class="mr-3 rounded-circle" style="width: 60px; height: 60px;">
                                    @endif
                                    <div>
                                        <h5 class="mb-0">{{ $balletCard->user->name }}</h5>
                                        <p class="text-muted mb-0">{{ $balletCard->user->email }}</p>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td class="font-weight-bold">Account ID</td>
                                                <td>{{ $balletCard->user->id }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Phone</td>
                                                <td>{{ $balletCard->user->phone ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Address</td>
                                                <td>{{ $balletCard->user->address ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Joined On</td>
                                                <td>{{ $balletCard->user->created_at->format('M d, Y') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <a href="{{ route('viewuser', $balletCard->user->id) }}" class="btn btn-primary btn-block">
                                    <i class="fa fa-user"></i> View User Profile
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-7">
                        <!-- Card Balance Management -->
                        <div class="card p-3 shadow">
                            <div class="card-header">
                                <h4 class="card-title">Balance Management</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card bg-success text-white mb-4">
                                            <div class="card-body">
                                                <h5 class="mb-1">Top Up Card</h5>
                                                <form action="{{ route('admin.ballet-cards.topup', $balletCard->id) }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="amount">Amount ({{ $balletCard->currency }})</label>
                                                        <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter amount" min="1" step="0.01" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="description">Description (Optional)</label>
                                                        <input type="text" class="form-control" id="description" name="description" placeholder="Enter description">
                                                    </div>
                                                    <button type="submit" class="btn btn-light btn-block">
                                                        <i class="fa fa-arrow-up"></i> Top Up
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card bg-danger text-white mb-4">
                                            <div class="card-body">
                                                <h5 class="mb-1">Deduct from Card</h5>
                                                <form action="{{ route('admin.ballet-cards.deduct', $balletCard->id) }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="deduct_amount">Amount ({{ $balletCard->currency }})</label>
                                                        <input type="number" class="form-control" id="deduct_amount" name="amount" placeholder="Enter amount" min="1" step="0.01" max="{{ $balletCard->balance }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="deduct_description">Description (Optional)</label>
                                                        <input type="text" class="form-control" id="deduct_description" name="description" placeholder="Enter description">
                                                    </div>
                                                    <button type="submit" class="btn btn-light btn-block">
                                                        <i class="fa fa-arrow-down"></i> Deduct
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Edit Card Details -->
                        <div class="card p-3 shadow mt-4">
                            <div class="card-header">
                                <h4 class="card-title">Edit Ballet Card Details</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.ballet-cards.update', $balletCard->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="primary_account_type">Primary Account Type</label>
                                        <select class="form-control" id="primary_account_type" name="primary_account_type" required>
                                            <option value="BTC" {{ $balletCard->primary_account_type == 'BTC' ? 'selected' : '' }}>BTC - Bitcoin</option>
                                            <option value="ETH" {{ $balletCard->primary_account_type == 'ETH' ? 'selected' : '' }}>ETH - Ethereum</option>
                                            <option value="USDT" {{ $balletCard->primary_account_type == 'USDT' ? 'selected' : '' }}>USDT - Tether</option>
                                            <option value="LTC" {{ $balletCard->primary_account_type == 'LTC' ? 'selected' : '' }}>LTC - Litecoin</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="primary_account_deposit_address">Primary Account Deposit Address</label>
                                        <input type="text" class="form-control" id="primary_account_deposit_address" name="primary_account_deposit_address" value="{{ $balletCard->primary_account_deposit_address }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="serial_number">Serial Number</label>
                                        <input type="text" class="form-control" id="serial_number" name="serial_number" value="{{ $balletCard->serial_number }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="pass_phrase">PassPhrase</label>
                                        <input type="text" class="form-control" id="pass_phrase" name="pass_phrase" value="{{ $balletCard->pass_phrase }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="currency">Currency</label>
                                        <input type="text" class="form-control" id="currency" name="currency" value="{{ $balletCard->currency }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fa fa-save"></i> Update Card Details
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Transaction History (if applicable for Ballet Cards) --}}
                        {{-- <div class="card p-3 shadow mt-4">
                            <div class="card-header">
                                <h4 class="card-title">Transaction History</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Reference</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Merchant</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($transactions as $transaction)
                                                <tr>
                                                    <td>{{ $transaction->transaction_reference }}</td>
                                                    <td>
                                                        @if($transaction->transaction_type == 'purchase')
                                                            <span class="badge badge-info">Purchase</span>
                                                        @elseif($transaction->transaction_type == 'topup')
                                                            <span class="badge badge-success">Top-up</span>
                                                        @elseif($transaction->transaction_type == 'deduction')
                                                            <span class="badge badge-warning">Deduction</span>
                                                        @elseif($transaction->transaction_type == 'refund')
                                                            <span class="badge badge-primary">Refund</span>
                                                        @else
                                                            <span class="badge badge-secondary">{{ ucfirst($transaction->transaction_type) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($transaction->amount > 0)
                                                            <span class="text-success">
                                                                +{{ $transaction->currency }}{{ number_format(abs($transaction->amount), 2) }}
                                                            </span>
                                                        @else
                                                            <span class="text-danger">
                                                                -{{ $transaction->currency }}{{ number_format(abs($transaction->amount), 2) }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $transaction->merchant_name }}</td>
                                                    <td>
                                                        @if($transaction->status == 'completed')
                                                            <span class="badge badge-success">Completed</span>
                                                        @elseif($transaction->status == 'pending')
                                                            <span class="badge badge-warning">Pending</span>
                                                        @elseif($transaction->status == 'failed')
                                                            <span class="badge badge-danger">Failed</span>
                                                        @else
                                                            <span class="badge badge-secondary">{{ ucfirst($transaction->status) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $transaction->transaction_date->format('M d, Y h:i A') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No transactions found for this card.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    {{ $transactions->links() }}
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Delete Card Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
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
                    <a href="{{ route('admin.ballet-cards.delete', $balletCard->id) }}" class="btn btn-danger">
                        <i class="fa fa-trash"></i> Delete Permanently
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
