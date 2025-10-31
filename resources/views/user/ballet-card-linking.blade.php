@extends('layouts.dash2')
@section('title', 'Ballet Card Linking')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 p-4 lg:p-6">
    <div class="max-w-8xl mx-auto">
        <!-- Mobile Header -->
        <div class="lg:hidden mb-2">
            @include('partials._mobile_header', [
                'title' => 'Ballet Card Linking',
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
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Ballet Card Linking and Verification</h1>
                        <p class="text-gray-600 dark:text-gray-400">Link your purchased Ballet Cards for verification</p>
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

        <!-- Main Application Card -->
        <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-xl rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/50 overflow-hidden">
            <!-- Card Info Banner -->
            <div class="bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 dark:from-primary-600 dark:via-primary-700 dark:to-primary-800 p-6 text-white">
                <div class="relative">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-xl lg:text-2xl font-bold mb-2">Ballet Card Linking</h2>
                            <p class="text-white/90 text-sm">Upload photos of your Ballet Card for verification</p>
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
            
            <!-- Application Form -->
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center space-x-2 mb-1">
                        <div class="w-6 h-6 rounded-lg bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center">
                            <i class="fas fa-info text-white text-xs"></i>
                        </div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Instructions and Guidelines</h3>
                    </div>
                    
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl border border-gray-200/50 dark:border-gray-700/50 p-4 text-gray-700 dark:text-gray-300">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-400">
                                    <i class="fas fa-lightbulb text-sm"></i>
                                </div>
                                <p class="text-sm">Ensure your Ballet Card is clean and in a well-lit environment.</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-400">
                                    <i class="fas fa-sticky-note text-sm"></i>
                                </div>
                                <p class="text-sm">Peel off the QR-code sticker from the card carefully.</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-400">
                                    <i class="fas fa-key text-sm"></i>
                                </div>
                                <p class="text-sm">Scratch off the security layer to reveal your PASS-PHRASE.</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-400">
                                    <i class="fas fa-camera-retro text-sm"></i>
                                </div>
                                <p class="text-sm">Take clear photos of both the front and back of the card.</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-400">
                                    <i class="fas fa-eye text-sm"></i>
                                </div>
                                <p class="text-sm">All details on the card (e.g., card number, security features) must be clearly visible.</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-400">
                                    <i class="fas fa-file-image text-sm"></i>
                                </div>
                                <p class="text-sm">Only upload image files (JPG, PNG).</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 dark:text-primary-400">
                                    <i class="fas fa-compress-alt text-sm"></i>
                                </div>
                                <p class="text-sm">Each image should not exceed 5MB in size.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('user.ballet-cards.link') }}" enctype="multipart/form-data" class="space-y-6 mt-6">
                    @csrf
                    
                    <!-- Image Upload Section -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2 mb-1">
                            <div class="w-6 h-6 rounded-lg bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center">
                                <i class="fas fa-camera text-white text-xs"></i>
                            </div>
                            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Upload Card Photos</h3>
                        </div>
                        
                        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl border border-gray-200/50 dark:border-gray-700/50 p-4 space-y-4">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                <!-- Front Image -->
                                <div>
                                    <label for="front_image" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Front of Ballet Card <span class="text-red-500">*</span></label>
                                    <input type="file" class="block w-full text-sm text-gray-900 dark:text-white
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-lg file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-primary-500 file:text-white
                                        hover:file:bg-primary-600
                                        @error('front_image') border-red-400 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror rounded-lg bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm"
                                        id="front_image" name="front_image" required>
                                    @error('front_image')
                                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Back Image -->
                                <div>
                                    <label for="back_image" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Back of Ballet Card <span class="text-red-500">*</span></label>
                                    <input type="file" class="block w-full text-sm text-gray-900 dark:text-white
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-lg file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-primary-500 file:text-white
                                        hover:file:bg-primary-600
                                        @error('back_image') border-red-400 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror rounded-lg bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm"
                                        id="back_image" name="back_image" required>
                                    @error('back_image')
                                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="flex flex-col lg:flex-row lg:space-x-3 space-y-2 lg:space-y-0 pt-4">
                        <button type="submit" class="w-full lg:flex-1 inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-xl shadow-lg text-base font-semibold text-white bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98]">
                            <i class="fas fa-upload mr-2"></i>
                            Link Ballet Card
                        </button>
                        <a href="{{ route('cards') }}" class="w-full lg:w-auto inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-xl shadow-sm text-base font-semibold text-gray-700 dark:text-gray-300 bg-white/70 dark:bg-gray-700/70 backdrop-blur-sm hover:bg-gray-50 dark:hover:bg-gray-600/70 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-300">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Cards
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
