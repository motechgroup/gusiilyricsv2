<!-- Interactive Song Structure Block Builder Partial -->
<div class="space-y-4">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-2 border-b border-gray-800">
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-emerald-400">
                🎼 Song Structure & Lyrics Blocks Builder
            </label>
            <p class="text-[11px] text-gray-400">Add verses, chorus, intro, outro, and bridges to create structured song lyrics.</p>
        </div>

        <!-- Mode Toggle Tabs -->
        <div class="flex items-center gap-1 bg-gray-950 p-1 rounded-xl border border-gray-800 shrink-0">
            <button type="button" id="tabBuilderBtn" onclick="switchLyricsEditorMode('builder')" class="px-3 py-1.5 rounded-lg text-xs font-bold transition bg-emerald-500 text-slate-950 shadow">
                🧩 Block Builder
            </button>
            <button type="button" id="tabRawBtn" onclick="switchLyricsEditorMode('raw')" class="px-3 py-1.5 rounded-lg text-xs font-bold transition text-gray-400 hover:text-white">
                📝 Raw Text
            </button>
        </div>
    </div>

    <!-- Interactive Block Builder UI Canvas -->
    <div id="lyricsBuilderContainer" class="space-y-4">
        <!-- Quick Add Section Badges Bar -->
        <div class="p-3.5 rounded-2xl bg-gray-950/80 border border-gray-800/80 space-y-2">
            <span class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400 block">
                ➕ Quick Add Lyrics Block / Stanza
            </span>
            <div class="flex flex-wrap items-center gap-2">
                <button type="button" onclick="addLyricsBlock('Intro')" class="px-2.5 py-1 rounded-lg bg-purple-500/15 hover:bg-purple-500/25 text-purple-400 border border-purple-500/30 text-xs font-bold transition">
                    + Intro
                </button>
                <button type="button" onclick="addLyricsBlock('Verse 1')" class="px-2.5 py-1 rounded-lg bg-emerald-500/15 hover:bg-emerald-500/25 text-emerald-400 border border-emerald-500/30 text-xs font-bold transition">
                    + Verse 1
                </button>
                <button type="button" onclick="addLyricsBlock('Chorus')" class="px-2.5 py-1 rounded-lg bg-amber-500/15 hover:bg-amber-500/25 text-amber-300 border border-amber-500/30 text-xs font-bold transition">
                    + Chorus
                </button>
                <button type="button" onclick="addLyricsBlock('Verse 2')" class="px-2.5 py-1 rounded-lg bg-emerald-500/15 hover:bg-emerald-500/25 text-emerald-400 border border-emerald-500/30 text-xs font-bold transition">
                    + Verse 2
                </button>
                <button type="button" onclick="addLyricsBlock('Pre-Chorus')" class="px-2.5 py-1 rounded-lg bg-sky-500/15 hover:bg-sky-500/25 text-sky-400 border border-sky-500/30 text-xs font-bold transition">
                    + Pre-Chorus
                </button>
                <button type="button" onclick="addLyricsBlock('Verse 3')" class="px-2.5 py-1 rounded-lg bg-emerald-500/15 hover:bg-emerald-500/25 text-emerald-400 border border-emerald-500/30 text-xs font-bold transition">
                    + Verse 3
                </button>
                <button type="button" onclick="addLyricsBlock('Bridge 1')" class="px-2.5 py-1 rounded-lg bg-indigo-500/15 hover:bg-indigo-500/25 text-indigo-400 border border-indigo-500/30 text-xs font-bold transition">
                    + Bridge 1
                </button>
                <button type="button" onclick="addLyricsBlock('Verse 4')" class="px-2.5 py-1 rounded-lg bg-emerald-500/15 hover:bg-emerald-500/25 text-emerald-400 border border-emerald-500/30 text-xs font-bold transition">
                    + Verse 4
                </button>
                <button type="button" onclick="addLyricsBlock('Outro')" class="px-2.5 py-1 rounded-lg bg-rose-500/15 hover:bg-rose-500/25 text-rose-400 border border-rose-500/30 text-xs font-bold transition">
                    + Outro
                </button>
                <button type="button" onclick="addLyricsBlock('Spoken Word')" class="px-2.5 py-1 rounded-lg bg-cyan-500/15 hover:bg-cyan-500/25 text-cyan-400 border border-cyan-500/30 text-xs font-bold transition">
                    + Spoken Word
                </button>
                <button type="button" onclick="addLyricsBlock('Refrain')" class="px-2.5 py-1 rounded-lg bg-amber-500/15 hover:bg-amber-500/25 text-amber-300 border border-amber-500/30 text-xs font-bold transition">
                    + Refrain
                </button>
            </div>
        </div>

        <!-- Dynamic List of Blocks -->
        <div id="blocksList" class="space-y-4"></div>
    </div>

    <!-- Raw Textarea Container (Hidden by default or synced) -->
    <div id="lyricsRawContainer" class="hidden">
        <textarea id="lyrics_raw_input" name="lyrics_raw" rows="14" required placeholder="Paste full song lyrics line by line..." class="w-full px-4 py-3 bg-gray-950 border border-gray-800 rounded-xl text-white font-mono text-sm leading-relaxed focus:outline-none focus:border-emerald-500">{{ old('lyrics_raw', $song->lyrics_raw ?? '') }}</textarea>
    </div>
</div>

<script>
let lyricsBlocksState = [];

document.addEventListener('DOMContentLoaded', function() {
    initLyricsBlocks();
});

function initLyricsBlocks() {
    const rawTextarea = document.getElementById('lyrics_raw_input');
    const initialText = rawTextarea ? rawTextarea.value.trim() : '';

    if (initialText) {
        parseRawTextToBlocks(initialText);
    } else {
        // Default starting template
        lyricsBlocksState = [
            { type: 'Intro', text: '' },
            { type: 'Verse 1', text: '' },
            { type: 'Chorus', text: '' },
            { type: 'Verse 2', text: '' },
            { type: 'Outro', text: '' }
        ];
    }
    renderBlocks();
}

function parseRawTextToBlocks(text) {
    lyricsBlocksState = [];
    const chunks = text.split(/\n\s*\n/);

    chunks.forEach(chunk => {
        const trimmed = chunk.trim();
        if (!trimmed) return;

        // Check if starts with [Section] or Section:
        const headerMatch = trimmed.match(/^\[?(Intro|Verse \d+|Verse|Chorus|Pre-Chorus|Bridge \d+|Bridge|Outro|Refrain|Hook|Spoken Word)\]?:?\s*\n?/i);

        if (headerMatch) {
            const type = headerMatch[1].trim();
            const textContent = trimmed.replace(headerMatch[0], '').trim();
            lyricsBlocksState.push({ type: type, text: textContent });
        } else {
            lyricsBlocksState.push({ type: 'Verse', text: trimmed });
        }
    });

    if (lyricsBlocksState.length === 0) {
        lyricsBlocksState.push({ type: 'Verse 1', text: text });
    }
}

function addLyricsBlock(type) {
    lyricsBlocksState.push({ type: type, text: '' });
    renderBlocks();
    compileBlocksToRawText();
}

function removeLyricsBlock(index) {
    lyricsBlocksState.splice(index, 1);
    renderBlocks();
    compileBlocksToRawText();
}

function moveLyricsBlock(index, direction) {
    const targetIndex = index + direction;
    if (targetIndex < 0 || targetIndex >= lyricsBlocksState.length) return;
    
    const temp = lyricsBlocksState[index];
    lyricsBlocksState[index] = lyricsBlocksState[targetIndex];
    lyricsBlocksState[targetIndex] = temp;
    
    renderBlocks();
    compileBlocksToRawText();
}

function updateBlockText(index, val) {
    lyricsBlocksState[index].text = val;
    compileBlocksToRawText();
}

function updateBlockType(index, val) {
    lyricsBlocksState[index].type = val;
    renderBlocks();
    compileBlocksToRawText();
}

function getBadgeColor(type) {
    const t = type.toLowerCase();
    if (t.includes('intro')) return 'bg-purple-500/10 border-purple-500/30 text-purple-400';
    if (t.includes('chorus') || t.includes('refrain') || t.includes('hook')) return 'bg-amber-500/15 border-amber-500/40 text-amber-300 font-bold';
    if (t.includes('bridge')) return 'bg-indigo-500/10 border-indigo-500/30 text-indigo-400';
    if (t.includes('pre-chorus')) return 'bg-sky-500/10 border-sky-500/30 text-sky-400';
    if (t.includes('outro')) return 'bg-rose-500/10 border-rose-500/30 text-rose-400';
    if (t.includes('spoken')) return 'bg-cyan-500/10 border-cyan-500/30 text-cyan-400';
    return 'bg-emerald-500/10 border-emerald-500/30 text-emerald-400';
}

function renderBlocks() {
    const container = document.getElementById('blocksList');
    if (!container) return;

    container.innerHTML = '';

    lyricsBlocksState.forEach((block, index) => {
        const badgeColor = getBadgeColor(block.type);
        const cardHtml = `
            <div class="p-4 sm:p-5 rounded-2xl bg-gray-950 border border-gray-800 space-y-3 relative group">
                <div class="flex items-center justify-between gap-2 border-b border-gray-800/60 pb-3">
                    <div class="flex items-center gap-2">
                        <select onchange="updateBlockType(${index}, this.value)" class="px-3 py-1 rounded-xl text-xs font-bold ${badgeColor} bg-gray-900 border focus:outline-none cursor-pointer">
                            <option value="Intro" ${block.type === 'Intro' ? 'selected' : ''}>[Intro]</option>
                            <option value="Verse 1" ${block.type === 'Verse 1' ? 'selected' : ''}>[Verse 1]</option>
                            <option value="Verse 2" ${block.type === 'Verse 2' ? 'selected' : ''}>[Verse 2]</option>
                            <option value="Verse 3" ${block.type === 'Verse 3' ? 'selected' : ''}>[Verse 3]</option>
                            <option value="Verse 4" ${block.type === 'Verse 4' ? 'selected' : ''}>[Verse 4]</option>
                            <option value="Chorus" ${block.type === 'Chorus' ? 'selected' : ''}>[Chorus]</option>
                            <option value="Pre-Chorus" ${block.type === 'Pre-Chorus' ? 'selected' : ''}>[Pre-Chorus]</option>
                            <option value="Bridge 1" ${block.type === 'Bridge 1' ? 'selected' : ''}>[Bridge 1]</option>
                            <option value="Bridge 2" ${block.type === 'Bridge 2' ? 'selected' : ''}>[Bridge 2]</option>
                            <option value="Refrain" ${block.type === 'Refrain' ? 'selected' : ''}>[Refrain]</option>
                            <option value="Outro" ${block.type === 'Outro' ? 'selected' : ''}>[Outro]</option>
                            <option value="Spoken Word" ${block.type === 'Spoken Word' ? 'selected' : ''}>[Spoken Word]</option>
                        </select>
                        <span class="text-[10px] text-gray-500 font-mono">Block #${index + 1}</span>
                    </div>

                    <div class="flex items-center gap-1.5">
                        <button type="button" onclick="moveLyricsBlock(${index}, -1)" ${index === 0 ? 'disabled' : ''} class="p-1.5 rounded-lg bg-gray-900 text-gray-400 hover:text-white disabled:opacity-30 text-xs">▲</button>
                        <button type="button" onclick="moveLyricsBlock(${index}, 1)" ${index === lyricsBlocksState.length - 1 ? 'disabled' : ''} class="p-1.5 rounded-lg bg-gray-900 text-gray-400 hover:text-white disabled:opacity-30 text-xs">▼</button>
                        <button type="button" onclick="removeLyricsBlock(${index})" class="px-2 py-1 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 text-xs font-bold transition">✕ Remove</button>
                    </div>
                </div>

                <textarea rows="4" oninput="updateBlockText(${index}, this.value)" placeholder="Enter lyrics lines for ${block.type}..." class="w-full px-3.5 py-2.5 bg-gray-900 border border-gray-800 rounded-xl text-white font-mono text-sm leading-relaxed focus:outline-none focus:border-emerald-500">${block.text}</textarea>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', cardHtml);
    });
}

function compileBlocksToRawText() {
    const lines = [];
    lyricsBlocksState.forEach(block => {
        const txt = block.text.trim();
        if (txt) {
            lines.push(`[${block.type}]\n${txt}`);
        }
    });

    const rawTextarea = document.getElementById('lyrics_raw_input');
    if (rawTextarea) {
        rawTextarea.value = lines.join('\n\n');
    }
}

function switchLyricsEditorMode(mode) {
    const builderCanvas = document.getElementById('lyricsBuilderContainer');
    const rawCanvas = document.getElementById('lyricsRawContainer');
    const btnBuilder = document.getElementById('tabBuilderBtn');
    const btnRaw = document.getElementById('tabRawBtn');

    if (mode === 'builder') {
        const rawTextarea = document.getElementById('lyrics_raw_input');
        if (rawTextarea) parseRawTextToBlocks(rawTextarea.value);
        renderBlocks();

        builderCanvas.classList.remove('hidden');
        rawCanvas.classList.add('hidden');
        btnBuilder.className = 'px-3 py-1.5 rounded-lg text-xs font-bold transition bg-emerald-500 text-slate-950 shadow';
        btnRaw.className = 'px-3 py-1.5 rounded-lg text-xs font-bold transition text-gray-400 hover:text-white';
    } else {
        compileBlocksToRawText();
        builderCanvas.classList.add('hidden');
        rawCanvas.classList.remove('hidden');
        btnRaw.className = 'px-3 py-1.5 rounded-lg text-xs font-bold transition bg-emerald-500 text-slate-950 shadow';
        btnBuilder.className = 'px-3 py-1.5 rounded-lg text-xs font-bold transition text-gray-400 hover:text-white';
    }
}
</script>
