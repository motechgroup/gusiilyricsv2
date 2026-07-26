@extends('layouts.admin')

@section('title', 'Manage Ad Booking Inquiries - Admin')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-extrabold text-white">📢 Ad Booking Inquiries</h1>
            <p class="text-xs text-gray-400 mt-1">Review advertiser proposals, banner artwork uploads, and campaign bookings.</p>
        </div>
        <div class="flex items-center gap-2 text-xs">
            <span class="px-3 py-1.5 rounded-xl bg-amber-500/20 text-amber-300 font-bold border border-amber-500/30">
                Pending Requests: {{ $pendingCount }}
            </span>
        </div>
    </div>

    <!-- Inquiries Table (Completely Un-enclosed) -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-gray-300">
            <thead class="bg-gray-950 text-gray-400 uppercase tracking-wider text-[10px] border-b border-gray-800">
                <tr>
                    <th class="py-3 px-4">Advertiser & Company</th>
                    <th class="py-3 px-4">Contact Info</th>
                    <th class="py-3 px-4">Placement Spot</th>
                    <th class="py-3 px-4">Duration/Budget</th>
                    <th class="py-3 px-4">Artwork</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/80">
                @forelse($inquiries as $inq)
                    <tr class="hover:bg-gray-900/40 transition">
                        <td class="py-4 px-4 font-medium text-white">
                            <strong class="block text-sm text-white">{{ $inq->advertiser_name }}</strong>
                            <span class="text-gray-400 text-[11px]">{{ $inq->company_name ?? 'Individual' }}</span>
                        </td>

                        <td class="py-4 px-4 font-mono text-[11px]">
                            <a href="mailto:{{ $inq->email }}" class="text-emerald-400 hover:underline block">{{ $inq->email }}</a>
                            <a href="tel:{{ $inq->phone }}" class="text-gray-300 hover:underline block mt-0.5">{{ $inq->phone }}</a>
                        </td>

                        <td class="py-4 px-4">
                            <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-bold uppercase text-[10px]">
                                {{ str_replace('_', ' ', $inq->placement_spot) }}
                            </span>
                        </td>

                        <td class="py-4 px-4 font-mono">
                            {{ str_replace('_', ' ', $inq->budget_range ?? 'Standard') }}
                        </td>

                        <td class="py-4 px-4">
                            @if($inq->banner_image)
                                <a href="{{ $inq->banner_url }}" target="_blank">
                                    <img src="{{ $inq->banner_url }}" class="w-12 h-12 rounded-lg object-cover border border-gray-800 hover:scale-110 transition">
                                </a>
                            @else
                                <span class="text-[10px] text-gray-500 italic">No Upload</span>
                            @endif
                        </td>

                        <td class="py-4 px-4">
                            <form method="POST" action="{{ route('admin.ad-inquiries.status', $inq->id) }}">
                                @csrf
                                <select name="status" onchange="this.form.submit()" class="px-2.5 py-1 rounded-xl bg-gray-950 border border-gray-800 text-[11px] font-bold uppercase text-white">
                                    <option value="pending" {{ $inq->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="contacted" {{ $inq->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                                    <option value="approved" {{ $inq->status === 'approved' ? 'selected' : '' }}>Approved / Active</option>
                                    <option value="declined" {{ $inq->status === 'declined' ? 'selected' : '' }}>Declined</option>
                                </select>
                            </form>
                        </td>

                        <td class="py-4 px-4 text-right space-x-2">
                            <form method="POST" action="{{ route('admin.ad-inquiries.destroy', $inq->id) }}" class="inline" onsubmit="return confirm('Delete this ad inquiry?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2.5 py-1 rounded-lg bg-rose-500/20 text-rose-300 hover:bg-rose-500/30 text-[10px] font-bold">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @if($inq->message)
                        <tr>
                            <td colspan="7" class="px-4 py-2.5 text-[11px] text-gray-400 italic font-sans border-b border-gray-800/80">
                                💬 Message: "{{ $inq->message }}"
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-gray-500 text-xs">
                            No advertising inquiries received yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($inquiries->hasPages())
        <div class="pt-4 border-t border-gray-800/80">
            {{ $inquiries->links() }}
        </div>
    @endif

</div>
@endsection
