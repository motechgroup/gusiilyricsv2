@extends('layouts.app')

@section('title', 'Support & Donate - Gusii Lyrics')
@section('meta_description', 'Support Ekegusii song lyrics preservation via M-Pesa STK Push or Stripe card payment.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">

    <!-- Header Banner (No Badge, Green & Gold Gradient Title) -->
    <div class="text-center space-y-3">
        <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
            Support <span class="bg-gradient-to-r from-emerald-400 via-amber-300 to-emerald-400 bg-clip-text text-transparent">Gusii Lyrics</span>
        </h1>
        <p class="text-gray-300 text-sm sm:text-base max-w-xl mx-auto leading-relaxed">
            Select a donation amount below to choose your payment option (M-Pesa or Card/Stripe).
        </p>
    </div>

    <!-- Un-enclosed Preset Amount Selection Section -->
    <div class="space-y-6 text-center py-4">
        <label class="block text-xs font-bold uppercase tracking-wider text-amber-400 font-mono">
            Choose Donation Amount (KES)
        </label>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3.5 max-w-3xl mx-auto">
            @foreach($presetAmounts as $amt)
                <button type="button" onclick="selectDonationAmount('{{ $amt }}')" class="px-4 py-4 rounded-2xl bg-gray-950/90 hover:bg-gradient-to-r hover:from-emerald-500 hover:to-amber-400 text-white hover:text-slate-950 font-mono font-black text-base border border-emerald-500/30 hover:border-amber-400 transition-all duration-200 active:scale-95 shadow-lg">
                    KES {{ number_format($amt) }}
                </button>
            @endforeach
        </div>

        <div class="pt-4 max-w-md mx-auto space-y-3">
            <label class="block text-xs text-gray-400 font-mono">Or enter custom amount:</label>
            <div class="flex gap-2">
                <input type="number" id="customAmountInput" placeholder="Enter amount e.g. 500" class="flex-grow px-4 py-3 bg-gray-950 border border-emerald-500/40 rounded-xl text-white font-mono text-sm focus:outline-none focus:border-amber-400">
                <button onclick="triggerCustomAmountChoice()" class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-500 via-amber-400 to-emerald-400 hover:from-emerald-400 hover:to-amber-300 text-slate-950 font-black text-xs shrink-0 transition shadow-lg">
                    Donate &rarr;
                </button>
            </div>
        </div>
    </div>

    <!-- Payment Gateways Official Logo Badges (Managed from Admin Settings, No Cards) -->
    <div class="pt-8 border-t border-gray-800/80">
        <div class="text-center mb-6">
            <span class="text-xs font-bold uppercase tracking-widest text-gray-400 font-mono">Supported Payment Partners</span>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-8 sm:gap-14">
            <!-- Official M-PESA Logo & Till Details -->
            <div class="flex items-center gap-4 text-left">
                <div class="px-4 py-2 rounded-2xl bg-[#00a651]/10 border border-[#00a651]/40 flex items-center justify-center shrink-0">
                    <span class="text-[#00a651] font-black text-xl tracking-tighter">M-PESA</span>
                </div>
                <div class="text-xs font-mono text-gray-300 space-y-0.5">
                    @if($settings['mpesa_till'])
                        <div>Buy Goods Till: <strong class="text-emerald-400 text-sm font-bold select-all">{{ $settings['mpesa_till'] }}</strong></div>
                    @endif
                    @if($settings['mpesa_paybill'])
                        <div>Paybill: <strong class="text-white font-bold select-all">{{ $settings['mpesa_paybill'] }}</strong></div>
                    @endif
                </div>
            </div>

            <div class="hidden sm:block w-px h-10 bg-gray-800"></div>

            <!-- Official Stripe Logo & Card Details -->
            <div class="flex items-center gap-4 text-left">
                <div class="px-4 py-2 rounded-2xl bg-[#635bff]/10 border border-[#635bff]/40 flex items-center justify-center shrink-0">
                    <span class="text-[#635bff] font-black text-xl tracking-tight">stripe</span>
                </div>
                <div class="text-xs text-gray-300 space-y-0.5">
                    <div class="font-bold text-white">Credit / Debit Card</div>
                    <div class="text-[11px] text-gray-400">Visa, Mastercard & Apple Pay</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Verified Supporters Wall -->
    <div class="space-y-4 pt-6 border-t border-gray-800/80">
        <h2 class="text-xl font-extrabold text-white text-center">Recent Verified Supporters</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
            @forelse($recentDonations as $don)
                <div class="p-4 rounded-2xl bg-gray-950/80 border border-gray-800/80 text-center space-y-1">
                    <div class="text-2xl">❤️</div>
                    <h4 class="font-bold text-white text-xs truncate">{{ $don->donor_name ?? 'Anonymous' }}</h4>
                    <span class="text-[11px] font-mono text-amber-400 font-bold block">{{ $don->currency }} {{ number_format($don->amount) }}</span>
                </div>
            @empty
                <div class="col-span-full text-center py-6 text-xs text-gray-500">Be the first supporter featured here!</div>
            @endforelse
        </div>
    </div>

</div>

<!-- Payment Option Choice Modal -->
<div id="paymentChoiceModal" class="fixed inset-0 z-50 bg-slate-950/85 backdrop-blur-md hidden flex items-center justify-center p-4">
    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-amber-400/40 shadow-2xl space-y-6 max-w-md w-full relative">
        <button onclick="closePaymentChoiceModal()" class="absolute top-4 right-4 p-2 text-gray-400 hover:text-white text-xl font-bold">&times;</button>

        <div class="text-center space-y-1">
            <h3 class="text-xl font-extrabold text-white">Choose Payment Method</h3>
            <p class="text-xs text-gray-300">Donation Amount: <strong id="choiceModalAmountText" class="text-amber-400 font-mono text-sm">KES 0</strong></p>
        </div>

        <div class="space-y-3 pt-2">
            <!-- Option 1: M-Pesa STK Push -->
            @if($settings['enable_mpesa'])
                <button onclick="openMpesaPhoneForm()" class="w-full p-4 rounded-2xl bg-[#00a651]/15 hover:bg-[#00a651]/25 border border-[#00a651]/50 text-left flex items-center justify-between group transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#00a651] text-white flex items-center justify-center font-black text-sm">
                            M
                        </div>
                        <div>
                            <h4 class="font-extrabold text-white text-sm group-hover:text-[#00a651] transition">M-Pesa Express / STK Push</h4>
                            <p class="text-[11px] text-gray-400">Receive PIN prompt directly on phone</p>
                        </div>
                    </div>
                    <span class="text-gray-400 group-hover:text-white font-bold">&rarr;</span>
                </button>
            @endif

            <!-- Option 2: Stripe / Card -->
            @if($settings['enable_stripe'] && !empty($settings['stripe_url']))
                <a id="stripeChoiceBtn" href="{{ $settings['stripe_url'] }}" target="_blank" class="w-full p-4 rounded-2xl bg-[#635bff]/15 hover:bg-[#635bff]/25 border border-[#635bff]/50 text-left flex items-center justify-between group transition block">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#635bff] text-white flex items-center justify-center font-black text-sm shrink-0">
                            S
                        </div>
                        <div>
                            <h4 class="font-extrabold text-white text-sm group-hover:text-[#635bff] transition">Stripe Card & Apple Pay</h4>
                            <p class="text-[11px] text-gray-400">Pay with Visa, Mastercard, Apple Pay</p>
                        </div>
                    </div>
                    <span class="text-gray-400 group-hover:text-white font-bold">&rarr;</span>
                </a>
            @endif

            @if(!$settings['enable_mpesa'] && (!$settings['enable_stripe'] || empty($settings['stripe_url'])))
                <div class="p-4 text-center text-xs text-amber-400 bg-amber-500/10 rounded-2xl border border-amber-500/20 font-medium">
                    Online automated gateways are currently undergoing routine maintenance. Please contact site management or use offline details below.
                </div>
            @endif
        </div>
    </div>
</div>

<!-- M-Pesa STK Push Phone Input Form Modal -->
<div id="mpesaPhoneModal" class="fixed inset-0 z-50 bg-slate-950/85 backdrop-blur-md hidden flex items-center justify-center p-4">
    <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-emerald-500/40 shadow-2xl space-y-5 max-w-md w-full relative">
        <button onclick="closeMpesaPhoneModal()" class="absolute top-4 right-4 p-2 text-gray-400 hover:text-white text-xl font-bold">&times;</button>

        <div class="text-center space-y-1">
            <span class="px-3 py-1 rounded-full bg-[#00a651]/20 text-[#00a651] text-[10px] font-bold uppercase tracking-wider font-mono">M-Pesa Express</span>
            <h3 class="text-xl font-extrabold text-white">Enter Safaricom Phone Number</h3>
            <p class="text-xs text-gray-300">Amount: <strong id="mpesaFormAmountText" class="text-emerald-400 font-mono">KES 0</strong></p>
        </div>

        <form id="stkPushForm" method="POST" action="{{ route('donate.stk-push') }}" class="space-y-4 text-xs">
            @csrf
            <input type="hidden" name="amount" id="stkAmountInput" value="500">

            <div>
                <label class="block font-bold text-gray-300 mb-1">M-Pesa Phone Number *</label>
                <input type="text" name="phone" required placeholder="e.g. 0712345678 or 254712345678" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-sm focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block font-bold text-gray-300 mb-1">Your Name (Optional)</label>
                <input type="text" name="donor_name" placeholder="e.g. Fenny Kerubo" class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500">
            </div>

            <button id="stkSubmitBtn" type="submit" class="w-full py-3.5 rounded-xl bg-[#00a651] hover:bg-emerald-400 text-slate-950 font-black text-xs shadow-lg transition">
                📱 Send M-Pesa PIN Prompt &rarr;
            </button>
        </form>
    </div>
</div>

<script>
    let selectedAmount = 500;

    function selectDonationAmount(amt) {
        selectedAmount = amt;
        document.getElementById('choiceModalAmountText').textContent = 'KES ' + Number(amt).toLocaleString();
        document.getElementById('mpesaFormAmountText').textContent = 'KES ' + Number(amt).toLocaleString();
        document.getElementById('stkAmountInput').value = amt;

        document.getElementById('paymentChoiceModal').classList.remove('hidden');
    }

    function triggerCustomAmountChoice() {
        const val = document.getElementById('customAmountInput').value;
        if (!val || val <= 0) {
            alert('Please enter a valid donation amount.');
            return;
        }
        selectDonationAmount(val);
    }

    function closePaymentChoiceModal() {
        document.getElementById('paymentChoiceModal').classList.add('hidden');
    }

    function openMpesaPhoneForm() {
        document.getElementById('paymentChoiceModal').classList.add('hidden');
        document.getElementById('mpesaPhoneModal').classList.remove('hidden');
    }

    function closeMpesaPhoneModal() {
        document.getElementById('mpesaPhoneModal').classList.add('hidden');
    }

    document.getElementById('stkPushForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('stkSubmitBtn');
        btn.disabled = true;
        btn.textContent = 'Sending PIN Prompt...';

        const formData = new FormData(this);
        try {
            const response = await fetch("{{ route('donate.stk-push') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            const res = await response.json();
            if (res.success) {
                alert('📲 ' + (res.message || 'M-Pesa PIN prompt sent to your phone! Please enter your PIN on your phone to complete donation.'));
                closeMpesaPhoneModal();
                window.location.reload();
            } else {
                alert('❌ ' + (res.message || 'Failed to send M-Pesa prompt. Please check your phone number and try again.'));
            }
        } catch (err) {
            alert('An error occurred. Please check your network connection.');
        } finally {
            btn.disabled = false;
            btn.textContent = '📱 Send M-Pesa PIN Prompt →';
        }
    });
</script>
@endsection
