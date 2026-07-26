document.addEventListener('DOMContentLoaded', () => {
    // --- 1. Global Audio Dock Player ---
    const audioElement = document.getElementById('mainAudioElement');
    const playBtn = document.getElementById('playerPlayBtn');
    const playIcon = document.getElementById('playIcon');
    const pauseIcon = document.getElementById('pauseIcon');
    const coverImg = document.getElementById('playerCover');
    const titleEl = document.getElementById('playerTitle');
    const artistEl = document.getElementById('playerArtist');
    const currentTimeEl = document.getElementById('playerCurrentTime');
    const durationEl = document.getElementById('playerDuration');
    const seeker = document.getElementById('playerSeeker');
    const lyricsLink = document.getElementById('playerLyricsLink');

    let isPlaying = false;

    function formatTime(seconds) {
        if (isNaN(seconds)) return '0:00';
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
    }

    function playTrack(audioUrl, title, artist, coverUrl, detailUrl) {
        if (!audioElement) return;

        if (audioUrl && audioElement.src !== audioUrl) {
            audioElement.src = audioUrl;
        }

        if (title) titleEl.textContent = title;
        if (artist) artistEl.textContent = artist;
        if (coverUrl) coverImg.src = coverUrl;
        if (detailUrl && lyricsLink) lyricsLink.href = detailUrl;

        audioElement.play().then(() => {
            isPlaying = true;
            updatePlayPauseUI();
        }).catch(err => {
            console.log('Audio playback waiting for user action', err);
        });
    }

    function togglePlayPause() {
        if (!audioElement || !audioElement.src) return;

        if (audioElement.paused) {
            audioElement.play();
            isPlaying = true;
        } else {
            audioElement.pause();
            isPlaying = false;
        }
        updatePlayPauseUI();
    }

    function updatePlayPauseUI() {
        if (audioElement.paused) {
            playIcon.classList.remove('hidden');
            pauseIcon.classList.add('hidden');
        } else {
            playIcon.classList.add('hidden');
            pauseIcon.classList.remove('hidden');
        }
    }

    if (playBtn) {
        playBtn.addEventListener('click', togglePlayPause);
    }

    // Bind all play buttons on song cards
    document.querySelectorAll('.play-song-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const audio = btn.dataset.audio;
            const title = btn.dataset.title;
            const artist = btn.dataset.artist;
            const cover = btn.dataset.cover;
            const url = btn.dataset.url;
            playTrack(audio, title, artist, cover, url);
        });
    });

    if (audioElement) {
        audioElement.addEventListener('timeupdate', () => {
            const current = audioElement.currentTime;
            const duration = audioElement.duration || 0;
            
            currentTimeEl.textContent = formatTime(current);
            durationEl.textContent = formatTime(duration);

            if (duration > 0) {
                seeker.value = (current / duration) * 100;
            }

            // Sync Karaoke Lyrics highlighting
            highlightLyricsLine(current);
        });

        audioElement.addEventListener('ended', () => {
            isPlaying = false;
            updatePlayPauseUI();
        });
    }

    if (seeker) {
        seeker.addEventListener('input', () => {
            if (!audioElement || !audioElement.duration) return;
            const seekTo = (seeker.value / 100) * audioElement.duration;
            audioElement.currentTime = seekTo;
        });
    }


    // --- 2. Synchronized Karaoke Lyrics Lines ---
    const lyricLines = document.querySelectorAll('.lyric-line');

    function highlightLyricsLine(currentTime) {
        if (lyricLines.length === 0) return;

        let activeIdx = -1;
        lyricLines.forEach((line, idx) => {
            const lineTime = parseFloat(line.dataset.time || 0);
            if (currentTime >= lineTime) {
                activeIdx = idx;
            }
        });

        lyricLines.forEach((line, idx) => {
            if (idx === activeIdx) {
                if (!line.classList.contains('active-line')) {
                    line.classList.add('active-line');
                    line.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            } else {
                line.classList.remove('active-line');
            }
        });
    }

    // Click lyric line to jump audio
    lyricLines.forEach(line => {
        line.addEventListener('click', () => {
            const targetTime = parseFloat(line.dataset.time || 0);
            if (audioElement) {
                audioElement.currentTime = targetTime;
                if (audioElement.paused) {
                    audioElement.play();
                    isPlaying = true;
                    updatePlayPauseUI();
                }
            }
        });
    });


    // --- 3. Translation Mode Tabs ---
    const tabBtns = document.querySelectorAll('.translation-tab-btn');
    const lyricsContainer = document.getElementById('lyricsContainer');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            tabBtns.forEach(b => {
                b.classList.remove('active', 'bg-emerald-500', 'text-slate-950');
                b.classList.add('text-gray-400', 'hover:text-white', 'hover:bg-gray-800');
            });
            btn.classList.add('active', 'bg-emerald-500', 'text-slate-950');
            btn.classList.remove('text-gray-400', 'hover:text-white', 'hover:bg-gray-800');

            const mode = btn.dataset.mode;
            document.querySelectorAll('.lyric-en').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.lyric-sw').forEach(el => el.classList.add('hidden'));

            if (mode === 'split-english') {
                document.querySelectorAll('.lyric-en').forEach(el => el.classList.remove('hidden'));
            } else if (mode === 'split-swahili') {
                document.querySelectorAll('.lyric-sw').forEach(el => el.classList.remove('hidden'));
            }
        });
    });


    // --- 4. Font Size Adjuster ---
    const decreaseBtn = document.getElementById('fontDecrease');
    const increaseBtn = document.getElementById('fontIncrease');
    const displayEl = document.getElementById('fontSizeDisplay');
    let currentFontSize = 16;

    if (decreaseBtn && increaseBtn && lyricsContainer) {
        decreaseBtn.addEventListener('click', () => {
            if (currentFontSize > 12) {
                currentFontSize -= 2;
                lyricsContainer.style.fontSize = `${currentFontSize}px`;
                displayEl.textContent = `${currentFontSize}px`;
            }
        });

        increaseBtn.addEventListener('click', () => {
            if (currentFontSize < 28) {
                currentFontSize += 2;
                lyricsContainer.style.fontSize = `${currentFontSize}px`;
                displayEl.textContent = `${currentFontSize}px`;
            }
        });
    }


    // --- 5. Instant Live Search Overlay ---
    const openSearchBtn = document.getElementById('openSearchBtn');
    const closeSearchBtn = document.getElementById('closeSearchBtn');
    const searchModal = document.getElementById('searchModal');
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');

    function openSearch() {
        if (searchModal) {
            searchModal.classList.remove('hidden');
            if (searchInput) searchInput.focus();
        }
    }

    function closeSearch() {
        if (searchModal) {
            searchModal.classList.add('hidden');
        }
    }

    if (openSearchBtn) openSearchBtn.addEventListener('click', openSearch);
    if (closeSearchBtn) closeSearchBtn.addEventListener('click', closeSearch);

    document.addEventListener('keydown', (e) => {
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
            e.preventDefault();
            openSearch();
        }
        if (e.key === 'Escape') {
            closeSearch();
        }
    });

    let debounceTimer;
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            const query = searchInput.value.trim();

            if (query.length < 2) {
                searchResults.innerHTML = `
                    <div class="text-center py-10 text-gray-500 text-sm">
                        Type a song title, artist name, or word (e.g. <i>Nyasae</i>, <i>Fenny Kerubo</i>) to search instant lyrics.
                    </div>
                `;
                return;
            }

            debounceTimer = setTimeout(() => {
                fetch(`/api/search?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length === 0) {
                            searchResults.innerHTML = `
                                <div class="text-center py-8 text-gray-400 text-sm">
                                    No Ekegusii lyrics found matching "<strong>${query}</strong>".
                                </div>
                            `;
                            return;
                        }

                        let html = '';
                        data.forEach(song => {
                            html += `
                                <a href="${song.url}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-800/80 transition group border border-gray-800/50">
                                    <img src="${song.cover}" class="w-12 h-12 rounded-lg object-cover border border-gray-700">
                                    <div>
                                        <h4 class="font-bold text-white text-sm group-hover:text-emerald-400 transition">${song.title}</h4>
                                        <p class="text-xs text-gray-400">${song.artist}</p>
                                    </div>
                                </a>
                            `;
                        });
                        searchResults.innerHTML = html;
                    }).catch(err => {
                        console.error('Search error', err);
                    });
            }, 300);
        });
    }


    // --- 6. Copy Lyrics Action ---
    const copyBtn = document.getElementById('copyLyricsBtn');
    if (copyBtn && lyricsContainer) {
        copyBtn.addEventListener('click', () => {
            const textToCopy = lyricsContainer.innerText;
            navigator.clipboard.writeText(textToCopy).then(() => {
                copyBtn.innerHTML = `
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Copied!</span>
                `;
                setTimeout(() => {
                    copyBtn.innerHTML = `
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        <span>Copy Lyrics</span>
                    `;
                }, 2000);
            });
        });
    }


    // --- 7. Like Song AJAX ---
    const likeBtn = document.getElementById('likeBtn');
    const likeCount = document.getElementById('likeCount');
    if (likeBtn && likeCount) {
        likeBtn.addEventListener('click', () => {
            const songId = likeBtn.dataset.songId;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/api/songs/${songId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    likeCount.textContent = data.likes_count;
                    likeBtn.classList.add('bg-rose-500/20', 'border-rose-500/40', 'text-rose-300');
                }
            });
        });
    }

    // --- 8. Mobile Menu Toggle ---
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }
});
