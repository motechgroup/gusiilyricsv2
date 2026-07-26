@extends('layouts.admin')

@section('title', 'Lyric Requests - Admin')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-extrabold text-white">Visitor Lyric Requests</h1>
            <p class="text-xs text-gray-400 mt-1">Review songs requested by visitors.</p>
        </div>
    </div>

    <!-- Requests Table (Completely Un-enclosed) -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs text-gray-300">
            <thead class="bg-gray-950 text-gray-400 font-bold uppercase tracking-wider border-b border-gray-800">
                <tr>
                    <th class="py-3 px-4">Song Title</th>
                    <th class="py-3 px-4">Artist</th>
                    <th class="py-3 px-4">Visitor Email</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800/80">
                @forelse($requests as $req)
                    <tr class="hover:bg-gray-900/40 transition">
                        <td class="py-4 px-4 font-bold text-white">{{ $req->song_title }}</td>
                        <td class="py-4 px-4 text-gray-300">{{ $req->artist_name }}</td>
                        <td class="py-4 px-4 text-gray-400 font-mono">{{ $req->visitor_email ?? 'Anonymous' }}</td>
                        <td class="py-4 px-4">
                            <span class="px-2.5 py-1 rounded text-[10px] font-bold uppercase {{ $req->status === 'pending' ? 'bg-amber-500/20 text-amber-300' : ($req->status === 'fulfilled' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-gray-800 text-gray-400') }}">
                                {{ $req->status }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-right space-x-2">
                            <form method="POST" action="{{ route('admin.requests.status', $req->id) }}" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="fulfilled">
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 font-semibold">
                                    Mark Fulfilled
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.requests.status', $req->id) }}" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-semibold">
                                    Reject
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500 text-xs">
                            No visitor lyric requests submitted yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($requests->hasPages())
        <div class="pt-4 border-t border-gray-800/80">
            {{ $requests->links() }}
        </div>
    @endif

</div>
@endsection
