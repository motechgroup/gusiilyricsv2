@extends('layouts.admin')

@section('title', 'Edit ' . $page['title'] . ' - Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-gray-800">
        <div>
            <h1 class="text-2xl font-extrabold text-white">Edit {{ $page['title'] }}</h1>
            <p class="text-xs text-gray-400 mt-1">Full formatting editor for public {{ $page['title'] }} ({{ $page['url'] }}).</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.pages.index') }}" class="text-xs font-semibold text-gray-400 hover:text-emerald-400">&larr; Back to Legal Pages List</a>
            <a href="{{ $page['url'] }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-gray-900 hover:bg-gray-800 text-emerald-400 font-bold text-xs border border-gray-800 transition flex items-center gap-1">
                <span>Live View &nearr;</span>
            </a>
        </div>
    </div>

    <!-- Formatting Toolbar & Editor Form -->
    <form method="POST" action="{{ route('pages.update', $page['slug']) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Rich Formatting Toolbar -->
        <div class="flex flex-wrap items-center gap-1.5 p-2 bg-gray-950 rounded-2xl border border-gray-800 text-xs">
            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-500 px-2 font-mono">Format Tools:</span>
            
            <button type="button" onclick="insertFormat('## ')" class="px-2.5 py-1.5 rounded-lg bg-gray-900 hover:bg-gray-800 text-emerald-400 font-bold font-mono transition" title="Heading 2">H2</button>
            <button type="button" onclick="insertFormat('### ')" class="px-2.5 py-1.5 rounded-lg bg-gray-900 hover:bg-gray-800 text-emerald-400 font-bold font-mono transition" title="Heading 3">H3</button>
            <button type="button" onclick="insertFormat('**', '**')" class="px-2.5 py-1.5 rounded-lg bg-gray-900 hover:bg-gray-800 text-white font-black transition" title="Bold Text">B</button>
            <button type="button" onclick="insertFormat('*', '*')" class="px-2.5 py-1.5 rounded-lg bg-gray-900 hover:bg-gray-800 text-gray-300 italic font-serif transition" title="Italic Text">I</button>
            <button type="button" onclick="insertFormat('- ')" class="px-2.5 py-1.5 rounded-lg bg-gray-900 hover:bg-gray-800 text-amber-400 transition" title="Bullet List">• List</button>
            <button type="button" onclick="insertFormat('1. ')" class="px-2.5 py-1.5 rounded-lg bg-gray-900 hover:bg-gray-800 text-amber-400 transition" title="Numbered List">1. List</button>
            <button type="button" onclick="insertFormat('> ')" class="px-2.5 py-1.5 rounded-lg bg-gray-900 hover:bg-gray-800 text-indigo-400 font-mono transition" title="Blockquote">&ldquo; Quote</button>
            <button type="button" onclick="insertFormat('[', '](https://)')" class="px-2.5 py-1.5 rounded-lg bg-gray-900 hover:bg-gray-800 text-sky-400 transition" title="Insert Link">🔗 Link</button>
            
            <div class="ml-auto flex items-center gap-2">
                <button type="button" onclick="togglePreviewTab('editor')" id="tabEditorBtn" class="px-3 py-1 rounded-lg bg-emerald-500 text-slate-950 font-bold text-xs">Edit</button>
                <button type="button" onclick="togglePreviewTab('preview')" id="tabPreviewBtn" class="px-3 py-1 rounded-lg bg-gray-900 text-gray-400 hover:text-white font-bold text-xs">Preview</button>
            </div>
        </div>

        <!-- Raw Textarea Editor -->
        <div id="editorArea">
            <textarea id="pageContentArea" name="content" rows="18" required class="w-full px-5 py-4 bg-gray-950 border border-gray-800 rounded-2xl text-white font-mono text-xs focus:outline-none focus:border-emerald-500 leading-relaxed shadow-xl">{{ old('content', $page['content']) }}</textarea>
        </div>

        <!-- Live Formatted Preview Container -->
        <div id="previewArea" class="hidden p-6 bg-gray-950 rounded-2xl border border-gray-800 min-h-[350px] space-y-4 text-xs leading-relaxed text-gray-300">
            <div id="formattedPreview" class="prose prose-invert max-w-none"></div>
        </div>

        <div class="flex items-center justify-between pt-2">
            <span class="text-[11px] text-gray-400">Formatting supports Markdown headings, lists, bold text, and hyperlinks.</span>
            <button type="submit" class="px-8 py-3.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold text-xs shadow-lg transition">
                💾 Save & Publish {{ $page['title'] }} &rarr;
            </button>
        </div>
    </form>

</div>

<script>
    function insertFormat(startTag, endTag = '') {
        const textarea = document.getElementById('pageContentArea');
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const text = textarea.value;
        const selected = text.substring(start, end);
        const replacement = startTag + (selected || 'text') + endTag;
        
        textarea.value = text.substring(0, start) + replacement + text.substring(end);
        textarea.focus();
        textarea.setSelectionRange(start + startTag.length, start + startTag.length + (selected.length || 4));
    }

    function togglePreviewTab(tab) {
        const editor = document.getElementById('editorArea');
        const preview = document.getElementById('previewArea');
        const btnEdit = document.getElementById('tabEditorBtn');
        const btnPrev = document.getElementById('tabPreviewBtn');

        if (tab === 'preview') {
            editor.classList.add('hidden');
            preview.classList.remove('hidden');
            btnEdit.className = 'px-3 py-1 rounded-lg bg-gray-900 text-gray-400 hover:text-white font-bold text-xs';
            btnPrev.className = 'px-3 py-1 rounded-lg bg-emerald-500 text-slate-950 font-bold text-xs';
            renderFormattedPreview();
        } else {
            editor.classList.remove('hidden');
            preview.classList.add('hidden');
            btnEdit.className = 'px-3 py-1 rounded-lg bg-emerald-500 text-slate-950 font-bold text-xs';
            btnPrev.className = 'px-3 py-1 rounded-lg bg-gray-900 text-gray-400 hover:text-white font-bold text-xs';
        }
    }

    function renderFormattedPreview() {
        const raw = document.getElementById('pageContentArea').value;
        let html = raw
            .replace(/^### (.*$)/gim, '<h3 class="text-base font-bold text-emerald-400 mt-4 mb-1">$1</h3>')
            .replace(/^## (.*$)/gim, '<h2 class="text-lg font-black text-white mt-5 mb-2 border-b border-gray-800 pb-1">$1</h2>')
            .replace(/^\> (.*$)/gim, '<blockquote class="border-l-2 border-indigo-500 pl-3 italic text-gray-400">$1</blockquote>')
            .replace(/\*\*(.*)\*\*/gim, '<strong class="font-bold text-white">$1</strong>')
            .replace(/\*(.*)\*/gim, '<em class="italic text-gray-300">$1</em>')
            .replace(/\[(.*?)\]\((.*?)\)/gim, '<a href="$2" target="_blank" class="text-emerald-400 underline">$1</a>')
            .replace(/\n$/gim, '<br />');

        document.getElementById('formattedPreview').innerHTML = html;
    }
</script>
@endsection
