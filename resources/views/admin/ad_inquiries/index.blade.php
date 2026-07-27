@extends('layouts.admin')

@section('title', 'Manage Ad Booking Inquiries - Admin')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-extrabold text-white">✉️ Contact & Ad Inquiries</h1>
            <p class="text-xs text-gray-400 mt-1">Review contact us form submissions, advertiser proposals, and music promotion inquiries.</p>
        </div>
        <div class="flex items-center gap-2 text-xs">
            <span class="px-3 py-1.5 rounded-xl bg-amber-500/20 text-amber-300 font-bold border border-amber-500/30">
                Pending: {{ $pendingCount }}
            </span>
            <span class="px-3 py-1.5 rounded-xl bg-emerald-500/20 text-emerald-300 font-bold border border-emerald-500/30">
                Contact Form Messages: {{ $contactMessagesCount }}
            </span>
        </div>
    </div>

    <!-- Category Filter Tabs Bar -->
    <div class="flex flex-wrap items-center gap-2 text-xs pb-2 border-b border-gray-800">
        <a href="{{ route('admin.ad-inquiries.index') }}" class="px-3 py-1.5 rounded-xl font-bold transition {{ !request('spot') ? 'bg-emerald-500 text-slate-950' : 'bg-gray-900 text-gray-400 hover:text-white' }}">
            All Messages
        </a>
        <a href="{{ route('admin.ad-inquiries.index', ['spot' => 'contact_us']) }}" class="px-3 py-1.5 rounded-xl font-bold transition {{ request('spot') === 'contact_us' ? 'bg-emerald-500 text-slate-950' : 'bg-gray-900 text-gray-400 hover:text-white' }}">
            ✉️ Contact Us Submissions
        </a>
        <a href="{{ route('admin.ad-inquiries.index', ['spot' => 'music_promotion']) }}" class="px-3 py-1.5 rounded-xl font-bold transition {{ request('spot') === 'music_promotion' ? 'bg-emerald-500 text-slate-950' : 'bg-gray-900 text-gray-400 hover:text-white' }}">
            🚀 Music Promotions
        </a>
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
                            @if(!empty($inq->email))
                                <button type="button" onclick="openDirectEmailModal('{{ addslashes($inq->email) }}', '{{ addslashes($inq->advertiser_name) }}', 'Re: {{ addslashes($inq->company_name) }}')" class="px-2.5 py-1 rounded-lg bg-emerald-500/20 text-emerald-300 hover:bg-emerald-500/30 text-[10px] font-bold">
                                    ✉️ Email Reply
                                </button>
                            @endif
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

<!-- Direct Email Composer Modal -->
<div id="directEmailModal" class="hidden fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4">
    <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 sm:p-8 max-w-lg w-full relative shadow-2xl space-y-4">
        <button onclick="document.getElementById('directEmailModal').classList.add('hidden')" class="absolute top-4 right-4 p-2 text-gray-400 hover:text-white text-xl font-bold">
            &times;
        </button>

        <div>
            <h3 class="text-xl font-extrabold text-white">Send Direct Email Response</h3>
            <p class="text-xs text-gray-400 mt-1">Dispatches a branded HTML email directly to the inquirer.</p>
        </div>

        <form method="POST" action="{{ route('admin.send-custom-email') }}" class="space-y-4 text-xs">
            @csrf
            <input type="hidden" name="recipient_name" id="modalRecipientName" value="">

            <div>
                <label class="block font-bold text-gray-300 mb-1">Recipient Email *</label>
                <input type="email" name="recipient_email" id="modalRecipientEmail" required class="w-full px-3.5 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block font-bold text-gray-300 mb-1">Email Subject *</label>
                <input type="text" name="subject" id="modalSubject" required class="w-full px-3.5 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block font-bold text-gray-300 mb-1">Message Content *</label>
                <textarea name="message_body" rows="5" required placeholder="Type your response to the inquirer here..." class="w-full px-3.5 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white focus:outline-none focus:border-emerald-500"></textarea>
            </div>

            <div class="pt-2 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('directEmailModal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-gray-800 text-gray-300 font-bold">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold shadow">
                    Send Email &rarr;
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openDirectEmailModal(email, name, subject) {
    document.getElementById('modalRecipientEmail').value = email;
    document.getElementById('modalRecipientName').value = name;
    document.getElementById('modalSubject').value = subject;
    document.getElementById('directEmailModal').classList.remove('hidden');
}
</script>
@endsection
