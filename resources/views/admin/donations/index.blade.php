@extends('layouts.admin')

@section('title', 'Manage Donations & Support - Admin')

@section('content')
<div class="space-y-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-gray-800">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white">💳 Manage Donations & Platform Support</h1>
            <p class="text-xs text-gray-400 mt-1">Track visitor contributions via M-Pesa & Stripe, record offline donations, and review financial logs.</p>
        </div>
        <button onclick="openManualDonationModal()" class="px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow-md">
            + Record Manual Donation
        </button>
    </div>

    <!-- Revenue Summary Cards (Un-enclosed) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="p-5 rounded-2xl bg-gray-950/80 border border-emerald-500/30">
            <div class="text-[11px] font-bold text-emerald-400 uppercase tracking-wider">Total KES Collected</div>
            <div class="text-3xl font-black text-white mt-2">KES {{ number_format($totals['total_kes'], 2) }}</div>
            <span class="text-[10px] text-gray-400 mt-1 block">M-Pesa & Local Contributions</span>
        </div>

        <div class="p-5 rounded-2xl bg-gray-950/80 border border-indigo-500/30">
            <div class="text-[11px] font-bold text-indigo-400 uppercase tracking-wider">Total USD Collected</div>
            <div class="text-3xl font-black text-white mt-2">${{ number_format($totals['total_usd'], 2) }}</div>
            <span class="text-[10px] text-gray-400 mt-1 block">Stripe Global Contributions</span>
        </div>

        <div class="p-5 rounded-2xl bg-gray-950/80 border border-gray-800">
            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Completed Donations</div>
            <div class="text-3xl font-black text-white mt-2">{{ $totals['count_completed'] }}</div>
            <span class="text-[10px] text-gray-400 mt-1 block">Verified Transactions</span>
        </div>

        <div class="p-5 rounded-2xl bg-gray-950/80 border border-amber-500/30">
            <div class="text-[11px] font-bold text-amber-400 uppercase tracking-wider">Pending Verification</div>
            <div class="text-3xl font-black text-white mt-2">{{ $totals['count_pending'] }}</div>
            <span class="text-[10px] text-gray-400 mt-1 block">Awaiting Confirmation</span>
        </div>
    </div>

    <!-- Filters & Table (Un-enclosed) -->
    <div class="space-y-4">
        
        <!-- Filter Bar -->
        <form method="GET" action="{{ route('admin.donations.index') }}" class="p-4 rounded-2xl bg-gray-950/80 border border-gray-800 flex flex-wrap gap-4 items-center justify-between">
            <div class="flex items-center gap-3">
                <select name="gateway" class="px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
                    <option value="">All Payment Gateways</option>
                    <option value="mpesa" {{ request('gateway') === 'mpesa' ? 'selected' : '' }}>M-Pesa</option>
                    <option value="stripe" {{ request('gateway') === 'stripe' ? 'selected' : '' }}>Stripe</option>
                    <option value="manual" {{ request('gateway') === 'manual' ? 'selected' : '' }}>Manual / Cash</option>
                </select>

                <select name="status" class="px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
                    <option value="">All Statuses</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>

                <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs">
                    Filter Logs
                </button>
            </div>

            <a href="{{ route('donate') }}" target="_blank" class="text-xs font-bold text-emerald-400 hover:underline">
                View Public /donate Page &rarr;
            </a>
        </form>

        <!-- Donations Table -->
        <div class="rounded-2xl overflow-hidden border border-gray-800/80 bg-gray-950/60">
            <table class="w-full text-left text-xs text-gray-300">
                <thead class="bg-gray-950 text-gray-400 font-bold uppercase tracking-wider border-b border-gray-800">
                    <tr>
                        <th class="p-4">Date</th>
                        <th class="p-4">Donor Name</th>
                        <th class="p-4">Amount</th>
                        <th class="p-4">Gateway</th>
                        <th class="p-4">Transaction Ref</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($donations as $don)
                        <tr class="hover:bg-gray-800/40">
                            <td class="p-4 font-mono text-gray-400">{{ $don->created_at->format('M d, Y H:i') }}</td>
                            <td class="p-4 font-bold text-white">
                                {{ $don->donor_name ?? 'Anonymous Supporter' }}
                                @if($don->donor_email)
                                    <span class="block text-[10px] text-gray-400 font-mono font-normal">{{ $don->donor_email }}</span>
                                @endif
                            </td>
                            <td class="p-4 font-mono font-bold text-emerald-400 text-sm">
                                {{ $don->currency }} {{ number_format($don->amount, 2) }}
                            </td>
                            <td class="p-4 uppercase text-[10px] font-bold font-mono">
                                <span class="px-2 py-0.5 rounded {{ $don->gateway === 'mpesa' ? 'bg-emerald-500/20 text-emerald-300' : ($don->gateway === 'stripe' ? 'bg-indigo-500/20 text-indigo-300' : 'bg-gray-800 text-gray-300') }}">
                                    {{ $don->gateway }}
                                </span>
                            </td>
                            <td class="p-4 font-mono text-gray-300 text-[11px] select-all">{{ $don->transaction_reference ?? 'N/A' }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded text-[10px] font-bold uppercase {{ $don->status === 'completed' ? 'bg-emerald-500/20 text-emerald-300' : ($don->status === 'pending' ? 'bg-amber-500/20 text-amber-300' : 'bg-rose-500/20 text-rose-300') }}">
                                    {{ $don->status }}
                                </span>
                            </td>
                            <td class="p-4 text-right space-x-2">
                                <form method="POST" action="{{ route('admin.donations.status', $don->id) }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="px-2.5 py-1 rounded bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 font-semibold text-[11px]">
                                        Approve
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.donations.destroy', $don->id) }}" class="inline" onsubmit="return confirm('Delete this donation record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1 rounded bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-semibold text-[11px]">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-xs text-gray-500">No donation records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $donations->links() }}
        </div>
    </div>

</div>

<!-- Record Manual Donation Modal -->
<div id="manualDonationModal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md hidden flex items-center justify-center p-4">
    <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 sm:p-8 max-w-md w-full relative shadow-2xl space-y-4">
        <button onclick="closeManualDonationModal()" class="absolute top-4 right-4 p-2 text-gray-400 hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div>
            <h3 class="text-xl font-extrabold text-white">Record Manual Donation</h3>
            <p class="text-xs text-gray-400 mt-1">Record a cash, bank, or offline donor contribution.</p>
        </div>

        <form method="POST" action="{{ route('admin.donations.store') }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Donor Name</label>
                    <input type="text" name="donor_name" placeholder="e.g. Kwamboka" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Donor Email</label>
                    <input type="email" name="donor_email" placeholder="kwamboka@example.com" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Amount <span class="text-rose-500">*</span></label>
                    <input type="number" step="0.01" name="amount" required placeholder="1000" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs font-mono">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Currency</label>
                    <select name="currency" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs font-mono">
                        <option value="KES">KES</option>
                        <option value="USD">USD</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Gateway</label>
                    <select name="gateway" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
                        <option value="mpesa">M-Pesa</option>
                        <option value="stripe">Stripe</option>
                        <option value="manual" selected>Manual / Cash</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs">
                        <option value="completed" selected>Completed</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Transaction Ref / Code</label>
                <input type="text" name="transaction_reference" placeholder="e.g. QKH789231" class="w-full px-3 py-2 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-xs">
            </div>

            <button type="submit" class="w-full py-3 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs transition">
                Record Donation Entry
            </button>
        </form>
    </div>
</div>

<script>
    function openManualDonationModal() { document.getElementById('manualDonationModal').classList.remove('hidden'); }
    function closeManualDonationModal() { document.getElementById('manualDonationModal').classList.add('hidden'); }
</script>
@endsection
