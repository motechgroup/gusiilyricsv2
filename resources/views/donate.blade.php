@extends('layouts.app')

@section('title', 'Support & Donate - Gusii Lyrics Vault')
@section('meta_description', 'Support Ekegusii song lyrics preservation via M-Pesa STK Push or Stripe card payment.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">

    <!-- Header Banner -->
    <div class="text-center space-y-3">
        <span class="px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 text-xs font-bold uppercase tracking-wider">
            ❤️ Platform Heritage Preservation
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
            Support <span class="text-gradient-emerald">Gusii Lyrics Vault</span>
        </h1>
        <p class="text-gray-300 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
            Select an amount below to receive an M-Pesa PIN push prompt on your phone!
        </p>
    </div>

    <!-- Preset Amount Selection Card -->
    <div class="glass-panel p-6 sm:p-10 rounded-3xl border border-emerald-500/30 space-y-6 text-center shadow-2xl">
        <label class="block text-xs font-bold uppercase tracking-wider text-emerald-400">
            Select Donation Amount (KES)
        </label>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
            @foreach($presetAmounts as $amt)
                <button type="button" onclick="openPhoneModalForAmount('{{ $amt }}')" class="px-4 py-4 rounded-2xl bg-gray-900 hover:bg-emerald-500 hover:text-slate-950 text-white font-mono font-black text-base border border-gray-800 transition duration-200 active:scale-95 shadow-md">
                    KES {{ number_format($amt) }}
                </button>
            @endforeach
        </div>

        <div class="pt-4 border-t border-gray-800/80 max-w-md mx-auto space-y-3">
            <label class="block text-xs text-gray-400 font-mono">Or enter a custom amount:</label>
            <div class="flex gap-2">
                <input type="number" id="customAmountInput" placeholder="Enter amount e.g. 500" class="flex-grow px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-sm focus:outline-none focus:border-emerald-500">
                <button onclick="triggerCustomAmountModal()" class="px-5 py-3 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold text-xs shrink-0 transition">
                    Donate &rarr;
                </button>
            </div>
        </div>
    </div>

    <!-- Alternative Gateways Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Manual M-Pesa Paybill / Till Card -->
        <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-gray-800 space-y-3 text-xs font-mono text-gray-300">
            <h3 class="text-sm font-bold text-white font-sans">💚 Manual M-Pesa Buy Goods & Paybill</h3>
            @if($settings['mpesa_till'])
                <p>Buy Goods Till: <strong class="text-emerald-400 text-base select-all">{{ $settings['mpesa_till'] }}</strong></p>
            @endif
            @if($settings['mpesa_paybill'])
                <p>Paybill / Shortcode: <strong class="text-white select-all">{{ $settings['mpesa_paybill'] }}</strong></p>
            @endif
        </div>

        <!-- Stripe Card Gateway -->
        <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-indigo-500/30 space-y-3 flex flex-col justify-between">
            <div>
                <h3 class="text-sm font-bold text-white">💳 Stripe Credit Card / Apple Pay</h3>
                <p class="text-xs text-gray-400 mt-1">Pay with Visa, Mastercard, or Apple Pay globally.</p>
            </div>

            @if($settings['stripe_url'])
                <a href="{{ $settings['stripe_url'] }}" target="_blank" class="w-full text-center py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs transition">
                    Pay with Card via Stripe &rarr;
                </a>
            @endif
        </div>
    </div>

    <!-- Recent Supporters Wall -->
    <div class="space-y-4">
        <h2 class="text-xl font-extrabold text-white text-center">Recent Verified Supporters</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
            @forelse($recentDonations as $don)
                <div class="glass-panel p-4 rounded-2xl border border-gray-800 text-center space-y-1">
                    <div class="text-2xl">❤️</div>
                    <h4 class="font-bold text-white text-xs truncate">{{ $don->donor_name ?? 'Anonymous' }}</h4>
                    <span class="text-[11px] font-mono text-emerald-400 font-bold block">{{ $don->currency }} {{ number_format($don->amount) }}</span>
                </div>
            @empty
                <div class="col-span-full text-center py-6 text-xs text-gray-500">Be the first supporter featured here!</div>
            @endforelse
        </div>
    </div>

</div>

<script>
    function openPhoneModalForAmount(amt) {
        setModalAmount(amt);
        openDonateModal();
    }

    function triggerCustomAmountModal() {
        const val = document.getElementById('customAmountInput').value;
        if (!val || val <= 0) {
            alert('Please enter a valid donation amount.');
            return;
        }
        setModalAmount(val);
        openDonateModal();
    }
</script>
@endsection
