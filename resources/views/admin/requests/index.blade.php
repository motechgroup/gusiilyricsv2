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

    <div class="glass-panel rounded-3xl overflow-hidden border border-gray-800">
        <table class="w-full text-left text-xs text-gray-300">
            <thead class="bg-gray-950 text-gray-400 font-bold uppercase tracking-wider border-b border-gray-800">
                <tr>
                    <th class="p-4">Song Title</th>
                    <th class="p-4">Artist</th>
                    <th class="p-4">Visitor Email</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @foreach($requests as $req)
                    <tr class="hover:bg-gray-800/40">
                        <td class="p-4 font-bold text-white">{{ $req->song_title }}</td>
                        <td class="p-4 text-gray-300">{{ $req->artist_name }}</td>
                        <td class="p-4 text-gray-400 font-mono">{{ $req->visitor_email ?? 'Anonymous' }}</td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded text-[10px] font-bold uppercase {{ $req->status === 'pending' ? 'bg-amber-500/20 text-amber-300' : ($req->status === 'fulfilled' ? 'bg-emerald-500/20 text-emerald-300' : 'bg-gray-800 text-gray-400') }}">
                                {{ $req->status }}
                            </span>
                        </td>
                        <td class="p-4 text-right space-x-2">
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
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $requests->links() }}
    </div>

</div>
@endsection
