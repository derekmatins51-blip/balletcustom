@extends('layouts.dash2')
@section('title', 'Ballet Card Details')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 p-4 lg:p-6">
    <div class="max-w-8xl mx-auto">
        <!-- Mobile Header -->
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
                        <p class="text-gray-600 dark:text-gray-400">View the details of your linked Ballet Card</p>
                    </div>
                </div>
                <a href="{{ route('cards') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm hover:bg-gray-50 dark:hover:bg-gray-600/70 transition-all duration-300">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Cards
                </a>
            </div>
        </div>

        <!-- Alerts -->
        <div class="mb-2">
            @if(session('error') || (session('message') && session('type') == 'error'))
                <div class="bg-red-50/90 dark:bg-red-900/20 border-l-4 border-red-500 dark:border-red-400 p-4 mb-4 rounded-r-xl backdrop-blur-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500 dark:text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 dark:text-red-300">{{ session('error') ?: session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            
            @if(session('success') || (session('message') && session('type') == 'success'))
                <div class="bg-green-50/90 dark:bg-green-900/20 border-l-4 border-green-500 dark:border-green-400 p-4 mb-4 rounded-r-xl backdrop-blur-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500 dark:text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') ?: session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            
            @if(session('message') && session('type') == 'danger')
                <div class="bg-red-50/90 dark:bg-red-900/20 border-l-4 border-red-500 dark:border-red-400 p-4 mb-4 rounded-r-xl backdrop-blur-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-500 dark:text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 dark:text-red-300">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Main Card Details -->
        <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/50 overflow-hidden">
            <!-- Card Info Banner -->
            <div class="bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 dark:from-primary-600 dark:via-primary-700 dark:to-primary-800 p-6 text-white">
                <div class="relative">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-xl lg:text-2xl font-bold mb-2">Ballet Card: {{ $balletCard->primary_account_type }}</h2>
                            <p class="text-white/90 text-sm">Status: {{ ucfirst($balletCard->status) }}</p>
                        </div>
                        <div class="hidden md:block">
                            <i class="fas fa-link text-white/75 text-4xl"></i>
                        </div>
                    </div>
                    
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute top-0 right-0 w-32 h-32 rounded-full bg-white transform translate-x-16 -translate-y-16"></div>
                        <div class="absolute bottom-0 left-0 w-24 h-24 rounded-full bg-white transform -translate-x-12 translate-y-12"></div>
                    </div>
                </div>
            </div>
            
            <!-- Card Details Section -->
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Card Visual -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Card Visual</h3>
                        <div class="relative w-full h-64 perspective-1000">
                            <div class="relative w-full h-full transform-style-preserve-3d transition-transform duration-700 ease-in-out hover:rotate-y-180">
                                <!-- Card Front -->
                                <div class="absolute w-full h-full backface-hidden rounded-xl shadow-lg overflow-hidden">
                                    <img src="{{ asset('image/ballet_cards/ballet_front.jpg') }}" alt="Ballet Card Front" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-br from-gray-900/70 to-gray-700/70 p-4 flex flex-col justify-between">
                                        <div>
                                            <p class="text-white text-sm font-semibold">Ballet Card</p>
                                            <p class="text-white text-xs opacity-80">Type: {{ $balletCard->primary_account_type }}</p>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-xs font-mono text-white mt-4">Passphrase: {{ substr($balletCard->pass_phrase, -4) }}</div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Back -->
                                <div class="absolute w-full h-full rotate-y-180 backface-hidden rounded-xl shadow-lg overflow-hidden">
                                    <img src="{{ asset('image/ballet_cards/ballet_back.jpg') }}" alt="Ballet Card Back" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-br from-gray-900/70 to-gray-700/70 p-4 flex flex-col justify-between">
                                        <p class="text-white text-sm font-semibold">Ballet Card Details</p>
                                        <p class="text-white text-xs opacity-80">Status: {{ ucfirst($balletCard->status) }}</p>
                                        <p class="text-white text-xs opacity-80">Serial: {{ $balletCard->serial_number ?? 'N/A' }}</p>
                                        <p class="text-white text-xs opacity-80">Address: {{ $balletCard->primary_account_deposit_address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Detailed Information</h3>
                        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl border border-gray-200/50 dark:border-gray-700/50 p-4 space-y-4">
                            <div class="flex justify-between items-center border-b border-gray-200/50 dark:border-gray-700/50 pb-2">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Primary Account Type:</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $balletCard->primary_account_type }}</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-gray-200/50 dark:border-gray-700/50 pb-2">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Primary Account Deposit Address:</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white break-all">{{ $balletCard->primary_account_deposit_address }}</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-gray-200/50 dark:border-gray-700/50 pb-2">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Serial Number:</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $balletCard->serial_number ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-gray-200/50 dark:border-gray-700/50 pb-2">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">PassPhrase:</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white break-all">{{ $balletCard->pass_phrase }}</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-gray-200/50 dark:border-gray-700/50 pb-2">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Current Balance:</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $balletCard->currency }} {{ number_format($balletCard->balance, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-2">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Status:</span>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if ($balletCard->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300
                                    @elseif ($balletCard->status == 'approved') bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300
                                    @elseif ($balletCard->status == 'locked') bg-orange-100 text-orange-800 dark:bg-orange-900/50 dark:text-orange-300
                                    @elseif ($balletCard->status == 'restricted') bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300
                                    @else bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300 @endif">
                                    {{ ucfirst($balletCard->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
