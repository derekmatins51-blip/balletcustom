@extends('layouts.dash2')
@section('title', 'Ballet Card Details')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="max-w-8xl mx-auto p-4 lg:p-6 space-y-6">
        
        <div class="lg:hidden mb-2">
            @include('partials._mobile_header', [
                'title' => 'Ballet Card Details',
                'showBackButton' => true,
                'backUrl' => route('cards'),
                'showNotifications' => true,
                'showDarkMode' => true,
                'financeUser' => Auth::user()
            ])
        </div>

        <!-- Desktop Header -->
        <div class="hidden lg:block mb-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center">
                        <i class="fas fa-link text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Ballet Card Details</h1>
                        <p class="text-gray-600 dark:text-gray-400">Manage your {{ $balletCard->primary_account_type }} Ballet Card</p>
                    </div>
                </div>
                <a href="{{ route('cards') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm hover:bg-gray-50 dark:hover:bg-gray-600/70 transition-all duration-300">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Cards
                </a>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('message'))
            <div class="rounded-xl {{ session('type') == 'success' ? 'bg-green-50/80 dark:bg-green-900/20 text-green-800 dark:text-green-300 border border-green-200/50 dark:border-green-700/50' : 'bg-red-50/80 dark:bg-red-900/20 text-red-800 dark:text-red-300 border border-red-200/50 dark:border-red-700/50' }} p-4 backdrop-blur-sm mb-2">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        @if(session('type') == 'success')
                            <i class="fas fa-check-circle text-green-500 dark:text-green-400"></i>
                        @else
                            <i class="fas fa-exclamation-circle text-red-500 dark:text-red-400"></i>
                        @endif
                    </div>
                    <p class="text-sm font-medium">{{ session('message') }}</p>
                </div>
            </div>
        @endif

        <!-- Card Status and Actions -->
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl border border-gray-200/50 dark:border-gray-700/50 p-4">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div class="flex items-center space-x-3">
                    @if($balletCard->status == 'approved')
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-semibold bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                            <i class="fas fa-check-circle mr-1.5"></i> Active
                        </span>
                    @elseif($balletCard->status == 'pending')
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-semibold bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300">
                            <i class="fas fa-clock mr-1.5"></i> Pending
                        </span>
                    @elseif($balletCard->status == 'locked')
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-semibold bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-300">
                            <i class="fas fa-lock mr-1.5"></i> Locked
                        </span>
                    @elseif($balletCard->status == 'restricted')
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-semibold bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300">
                            <i class="fas fa-ban mr-1.5"></i> Restricted
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-semibold bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                            <i class="fas fa-times-circle mr-1.5"></i> {{ ucfirst($balletCard->status) }}
                        </span>
                    @endif
                </div>
                
                <!-- Card action buttons -->
                <div class="flex flex-wrap gap-2">
                    @if($balletCard->status == 'approved')
                        <form action="{{ route('user.ballet-cards.deactivate', $balletCard->id) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-3 py-2 border border-yellow-300 dark:border-yellow-600 shadow-sm text-sm leading-4 font-semibold rounded-lg text-yellow-700 dark:text-yellow-300 bg-yellow-50 dark:bg-yellow-900/20 hover:bg-yellow-100 dark:hover:bg-yellow-900/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
                                <i class="fas fa-pause mr-1.5"></i> Deactivate
                            </button>
                        </form>
                    @elseif($balletCard->status == 'inactive')
                        <form action="{{ route('user.ballet-cards.activate', $balletCard->id) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-3 py-2 border border-green-300 dark:border-green-600 shadow-sm text-sm leading-4 font-semibold rounded-lg text-green-700 dark:text-green-300 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                <i class="fas fa-play mr-1.5"></i> Activate
                            </button>
                        </form>
                    @endif
                    
                    @if(in_array($balletCard->status, ['approved', 'inactive']))
                        <form action="{{ route('user.ballet-cards.block', $balletCard->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to block this card? This action may be irreversible.')">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-3 py-2 border border-red-300 dark:border-red-600 shadow-sm text-sm leading-4 font-semibold rounded-lg text-red-700 dark:text-red-300 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                <i class="fas fa-lock mr-1.5"></i> Block Card
                            </button>
                        </form>
                    @endif
                    
                    {{-- Add other actions like transactions if applicable for Ballet Cards --}}
                </div>
            </div>
        </div>

        <!-- 3D Card Display -->
        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl border border-gray-200/50 dark:border-gray-700/50 p-6">
            <div class="flex items-center space-x-2 mb-4">
                <div class="w-6 h-6 rounded-lg bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center">
                    <i class="fas fa-link text-white text-xs"></i>
                </div>
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Ballet Card</h2>
            </div>
            
            <div class="w-full max-w-md mx-auto mb-6">
                <div class="credit-card-container perspective-1000 flex justify-center">
                    <div class="credit-card transform-style-preserve-3d transition-transform duration-700" id="balletCreditCard" style="width: 86mm; height: 54mm;">
                        <!-- Front of the card -->
                        <div class="credit-card-front absolute inset-0 backface-hidden rounded-xl shadow-lg overflow-hidden">
                            <img src="{{ asset('images/ballet_cards/ballet_front.jpg') }}" alt="Ballet Card Front" class="w-full h-full object-contain" style="pointer-events: none;">
                        </div>
                        
                        <!-- Back of the card -->
                        <div class="credit-card-back absolute inset-0 rotate-y-180 backface-hidden rounded-xl shadow-lg overflow-hidden">
                            <img src="{{ asset('images/ballet_cards/ballet_back.jpg') }}" alt="Ballet Card Back" class="w-full h-full object-contain" style="pointer-events: none;">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Card Actions -->
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <button id="togglePassphraseBtn" type="button" class="inline-flex items-center justify-center px-4 py-3 sm:py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-semibold text-gray-700 dark:text-gray-300 bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm hover:bg-gray-50 dark:hover:bg-gray-600/70 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors touch-manipulation">
                    <i class="fas fa-eye mr-2"></i> <span id="togglePassphraseText">Show Passphrase</span>
                </button>
                <button id="copyWalletBtn" type="button" class="inline-flex items-center justify-center px-4 py-3 sm:py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-semibold text-gray-700 dark:text-gray-300 bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm hover:bg-gray-50 dark:hover:bg-gray-600/70 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors touch-manipulation">
                    <i class="fas fa-copy mr-2"></i> Copy Wallet
                </button>
                <button id="flipBalletCardBtn" type="button" class="inline-flex items-center justify-center px-4 py-3 sm:py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-semibold text-gray-700 dark:text-gray-300 bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm hover:bg-gray-50 dark:hover:bg-gray-600/70 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors touch-manipulation">
                    <i class="fas fa-sync-alt mr-2"></i> Flip Card
                </button>
            </div>
        </div>

        <!-- Card Information Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Card Details -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl border border-gray-200/50 dark:border-gray-700/50 p-4">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-6 h-6 rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center">
                        <i class="fas fa-info-circle text-white text-xs"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Ballet Card Information</h3>
                </div>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-gray-200/50 dark:border-gray-700/50">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Primary Account Type</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $balletCard->primary_account_type }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-200/50 dark:border-gray-700/50">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Primary Account Deposit Address</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white break-all">{{ $balletCard->primary_account_deposit_address }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-200/50 dark:border-gray-700/50">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Serial Number</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $balletCard->serial_number ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-200/50 dark:border-gray-700/50">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">PassPhrase</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white break-all">{{ $balletCard->pass_phrase }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-200/50 dark:border-gray-700/50">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Current Balance</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $balletCard->currency }} {{ number_format($balletCard->balance, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Linked On</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $balletCard->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- No Billing Information for Ballet Cards -->
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl border border-gray-200/50 dark:border-gray-700/50 p-4">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-6 h-6 rounded-lg bg-gradient-to-r from-green-500 to-green-600 flex items-center justify-center">
                        <i class="fas fa-info text-white text-xs"></i>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Additional Information</h3>
                </div>
                
                <div class="space-y-3">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Ballet Cards are physical crypto wallets and do not have traditional billing information, daily limits, or expiry dates like virtual cards.
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Manage your Ballet Card's status and view its details here.
                    </p>
                </div>
            </div>
        </div>

        @if(isset($recentTransactions) && count($recentTransactions) > 0)
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
                <div class="flex items-center justify-between p-4 border-b border-gray-200/50 dark:border-gray-700/50">
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 rounded-lg bg-gradient-to-r from-purple-500 to-purple-600 flex items-center justify-center">
                            <i class="fas fa-history text-white text-xs"></i>
                        </div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Recent Transactions</h3>
                    </div>
                    <a href="{{ route('user.ballet-cards.transactions', $balletCard) }}" class="text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300">
                        View All
                    </a>
                </div>
                
                <div class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                    @foreach($recentTransactions as $transaction)
                        <div class="p-4 hover:bg-gray-50/80 dark:hover:bg-gray-700/50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                        @if($transaction->transaction_type == 'purchase')
                                            <i class="fas fa-shopping-cart text-red-500 text-xs"></i>
                                        @elseif($transaction->transaction_type == 'refund')
                                            <i class="fas fa-undo text-green-500 text-xs"></i>
                                        @else
                                            <i class="fas fa-exchange-alt text-blue-500 text-xs"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->description }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold @if($transaction->transaction_type == 'purchase') text-red-600 dark:text-red-400 @else text-green-600 dark:text-green-400 @endif">
                                        @if($transaction->transaction_type == 'purchase')
                                            -{{ $balletCard->currency }} {{ number_format(abs($transaction->amount), 2) }}
                                        @else
                                            +{{ $balletCard->currency }} {{ number_format(abs($transaction->amount), 2) }}
                                        @endif
                                    </p>
                                    <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-lg 
                                        @if($transaction->status == 'completed') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 
                                        @elseif($transaction->status == 'pending') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 
                                        @else bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 @endif">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>

<style>
.perspective-1000 {
  perspective: 1000px;
  -webkit-perspective: 1000px;
}

.transform-style-preserve-3d {
  transform-style: preserve-3d;
  -webkit-transform-style: preserve-3d;
}

.backface-hidden {
  backface-visibility: hidden;
  -webkit-backface-visibility: hidden;
}

.credit-card {
  width: 100%;
  height: 100%; /* Adjusted to fit the parent container's explicit size */
  position: relative;
  transform-style: preserve-3d;
  -webkit-transform-style: preserve-3d;
  transition: transform 0.7s;
  -webkit-transition: -webkit-transform 0.7s;
}

.credit-card-front,
.credit-card-back {
  width: 100%;
  height: 100%;
  position: absolute;
  backface-visibility: hidden;
  -webkit-backface-visibility: hidden;
}

.credit-card-back {
  transform: rotateY(180deg);
  -webkit-transform: rotateY(180deg);
}

.credit-card.flipped {
  transform: rotateY(180deg);
  -webkit-transform: rotateY(180deg);
}
</style>

<script>
  let isPassphraseVisible = false;
  let isBalletCardFlipped = false;

  const balletCreditCard = document.getElementById('balletCreditCard');
  const flipBalletCardBtn = document.getElementById('flipBalletCardBtn');
  const togglePassphraseBtn = document.getElementById('togglePassphraseBtn');
  const copyWalletBtn = document.getElementById('copyWalletBtn');

  // Ensure the card starts on the front side
  if (balletCreditCard) {
    balletCreditCard.style.transform = 'rotateY(0deg)';
    balletCreditCard.classList.remove('flipped');
  }

  // Flip card
  if (flipBalletCardBtn && balletCreditCard) {
    flipBalletCardBtn.addEventListener('click', () => {
      isBalletCardFlipped = !isBalletCardFlipped;
      balletCreditCard.style.transform = isBalletCardFlipped ? 'rotateY(180deg)' : 'rotateY(0deg)';
      balletCreditCard.classList.toggle('flipped', isBalletCardFlipped);
    });
  }

  // Show/hide passphrase
  if (togglePassphraseBtn) {
    togglePassphraseBtn.addEventListener('click', () => {
      const masked = document.getElementById('maskedPassphrase');
      const full   = document.getElementById('fullPassphrase');
      const txt    = document.getElementById('togglePassphraseText');
      if (!masked || !full || !txt) return;

      isPassphraseVisible = !isPassphraseVisible;
      masked.classList.toggle('hidden', isPassphraseVisible);
      full.classList.toggle('hidden', !isPassphraseVisible);
      txt.textContent = isPassphraseVisible ? 'Hide Passphrase' : 'Show Passphrase';
    });
  }

  // Copy wallet address to clipboard
  if (copyWalletBtn) {
    copyWalletBtn.addEventListener('click', function() {
      const walletAddress = document.getElementById('balletWalletAddress').textContent.trim();
      if (!walletAddress) return;

      if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(walletAddress).then(() => {
          this.innerHTML = '<i class="fas fa-check mr-2"></i> Copied!';
          this.classList.add('text-green-600');
          setTimeout(() => {
            this.innerHTML = '<i class="fas fa-copy mr-2"></i> Copy Wallet';
            this.classList.remove('text-green-600');
          }, 2000);
        });
      } else {
        // Fallback
        const ta = document.createElement('textarea');
        ta.value = walletAddress;
        document.body.appendChild(ta);
        ta.select();
        try {
          document.execCommand('copy');
          this.innerHTML = '<i class="fas fa-check mr-2"></i> Copied!';
          this.classList.add('text-green-600');
          setTimeout(() => {
            this.innerHTML = '<i class="fas fa-copy mr-2"></i> Copy Wallet';
            this.classList.remove('text-green-600');
          }, 2000);
        } catch (err) {
          console.error('Fallback copy failed:', err);
        }
        document.body.removeChild(ta);
      }
    });
  }
</script>
@endsection
