{{-- AI Writing Assistant Panel --}}
<style>
@keyframes aiMagicalPulse {
    0% { box-shadow: 0 0 0 0 rgba(26, 137, 23, 0.15); }
    70% { box-shadow: 0 0 0 6px rgba(26, 137, 23, 0); }
    100% { box-shadow: 0 0 0 0 rgba(26, 137, 23, 0); }
}

.ai-trigger {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 14px;
    font-size: 13px;
    font-weight: 500;
    border: 1px solid var(--lighter-gray);
    background: var(--white);
    color: var(--off-black);
    border-radius: var(--radius-full);
    cursor: pointer;
    transition: var(--transition);
    font-family: var(--font-sans);
}

.ai-trigger svg {
    transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.ai-trigger:hover {
    border-color: var(--accent);
    color: var(--accent);
    background: #fdfefd;
    transform: translateY(-1px);
    animation: aiMagicalPulse 1.5s infinite;
}

.ai-trigger:hover svg {
    transform: scale(1.15) rotate(15deg);
}

.ai-trigger.active {
    background: var(--off-black);
    color: var(--white);
    border-color: var(--off-black);
    animation: none;
}

.ai-panel {
    display: none;
    background: var(--white);
    border: 1px solid var(--lighter-gray);
    border-radius: var(--radius-lg);
    padding: 24px;
    margin-bottom: 24px;
    animation: aiSlideDown 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: var(--shadow-lg);
}

.ai-panel.open { display: block; }

.ai-panel-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
}

.ai-panel-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 15px;
    font-weight: 600;
    color: var(--off-black);
}

.ai-panel-close {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--light-gray);
    padding: 4px;
    border-radius: var(--radius-sm);
    transition: var(--transition);
    display: flex;
    align-items: center;
}

.ai-panel-close:hover { 
    color: var(--danger); 
    background: #fef2f2; 
    transform: rotate(90deg);
}

.ai-actions {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}

@media (max-width: 640px) {
    .ai-actions {
        grid-template-columns: 1fr;
    }
}

.ai-action-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    background: var(--white);
    border: 1px solid var(--lighter-gray);
    border-radius: var(--radius-md);
    cursor: pointer;
    transition: var(--transition-slow);
    text-align: left;
    font-family: var(--font-sans);
    width: 100%;
}

.ai-action-btn:hover {
    border-color: var(--accent);
    box-shadow: 0 4px 16px rgba(26, 137, 23, 0.08); /* subtle accent glow */
    transform: translateY(-2px);
    background: #fdfefd;
}

.ai-action-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
    border-color: var(--lighter-gray);
}

.ai-action-icon {
    width: 36px;
    height: 36px;
    border-radius: var(--radius-sm);
    background: var(--off-white);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: var(--off-black);
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.ai-action-btn:hover .ai-action-icon {
    transform: scale(1.15) rotate(3deg);
    color: var(--accent);
    background: #edf8ed; /* extremely faint green */
}

.ai-action-text {
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.ai-action-text strong {
    font-size: 13px;
    font-weight: 600;
    color: var(--off-black);
}

.ai-action-text span {
    font-size: 12px;
    color: var(--medium-gray);
}

.ai-feedback {
    margin-top: 16px;
    padding: 12px 16px;
    border-radius: var(--radius-md);
    font-size: 13px;
    display: none;
    align-items: center;
    gap: 10px;
    animation: aiSlideDown 0.2s ease-out;
}

.ai-feedback.show { display: flex; }

.ai-feedback.loading {
    background: var(--off-white);
    color: var(--off-black);
    border: 1px solid var(--lighter-gray);
}

.ai-feedback.success {
    background: #f0fdf4;
    color: #16a34a;
    border: 1px solid #bbf7d0;
}

.ai-feedback.error {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

@keyframes aiSpin {
    to { transform: rotate(360deg); }
}

@keyframes aiSlideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.ai-spinner {
    width: 14px;
    height: 14px;
    border: 2px solid var(--lighter-gray);
    border-top-color: var(--off-black);
    border-radius: 50%;
    animation: aiSpin 0.6s linear infinite;
    flex-shrink: 0;
}
</style>
<div class="ai-panel" id="ai-panel">
    <div class="ai-panel-header">
        <div class="ai-panel-title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
            AI Assistant
        </div>
        <button type="button" class="ai-panel-close" onclick="toggleAiPanel()">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>

    <div class="ai-actions">
        {{-- Generate Excerpt --}}
        <button type="button" class="ai-action-btn" onclick="aiGenerateExcerpt()" id="ai-btn-excerpt">
            <div class="ai-action-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            </div>
            <div class="ai-action-text">
                <strong>Generate Excerpt</strong>
                <span>Auto-summarize your post</span>
            </div>
        </button>

        {{-- Suggest Category --}}
        <button type="button" class="ai-action-btn" onclick="aiSuggestCategory()" id="ai-btn-category">
            <div class="ai-action-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
            </div>
            <div class="ai-action-text">
                <strong>Suggest Category</strong>
                <span>Find the best fit</span>
            </div>
        </button>

        {{-- Improve Writing --}}
        <button type="button" class="ai-action-btn" onclick="aiImproveWriting()" id="ai-btn-improve">
            <div class="ai-action-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            </div>
            <div class="ai-action-text">
                <strong>Improve Writing</strong>
                <span>Fix grammar &amp; flow</span>
            </div>
        </button>

        {{-- Generate Outline --}}
        <button type="button" class="ai-action-btn" onclick="aiGenerateOutline()" id="ai-btn-outline">
            <div class="ai-action-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
            </div>
            <div class="ai-action-text">
                <strong>Generate Outline</strong>
                <span>Create structure from title</span>
            </div>
        </button>
    </div>

    <div class="ai-feedback" id="ai-feedback"></div>
</div>

<script>
    const AI_ROUTES = {
        excerpt:  '{{ route("ai.excerpt") }}',
        category: '{{ route("ai.category") }}',
        improve:  '{{ route("ai.improve") }}',
        outline:  '{{ route("ai.outline") }}',
    };
    const CSRF_TOKEN = '{{ csrf_token() }}';

    function toggleAiPanel() {
        const panel = document.getElementById('ai-panel');
        const trigger = document.getElementById('ai-trigger');
        panel.classList.toggle('open');
        if (trigger) trigger.classList.toggle('active');
    }

    function showFeedback(type, message) {
        const fb = document.getElementById('ai-feedback');
        fb.className = 'ai-feedback show ' + type;
        if (type === 'loading') {
            fb.innerHTML = '<span class="ai-spinner"></span> ' + message;
        } else {
            fb.innerHTML = message;
        }
    }

    function hideFeedback() {
        const fb = document.getElementById('ai-feedback');
        fb.className = 'ai-feedback';
    }

    function setButtonsDisabled(disabled) {
        document.querySelectorAll('.ai-action-btn').forEach(btn => btn.disabled = disabled);
    }

    async function aiRequest(url, body) {
        const res = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
            },
            body: JSON.stringify(body),
        });

        let data;
        try {
            data = await res.json();
        } catch(e) {
            throw new Error('Server returned an invalid response (Error ' + res.status + '). Check your connection or API key.');
        }

        if (!res.ok || !data.success) {
            throw new Error(data.error || data.message || 'Something went wrong');
        }

        return data;
    }

    async function aiGenerateExcerpt() {
        const body = document.querySelector('[name="body"]').value;
        if (!body || body.length < 50) {
            showFeedback('error', '⚠️ Write at least 50 characters in the body first.');
            return;
        }

        setButtonsDisabled(true);
        showFeedback('loading', 'Generating excerpt...');

        try {
            const data = await aiRequest(AI_ROUTES.excerpt, { body });
            document.querySelector('[name="excerpt"]').value = data.excerpt;
            showFeedback('success', '✅ Excerpt generated and filled in!');
        } catch (e) {
            showFeedback('error', '❌ ' + e.message);
        } finally {
            setButtonsDisabled(false);
        }
    }

    async function aiSuggestCategory() {
        const title = document.querySelector('[name="title"]').value;
        const body = document.querySelector('[name="body"]').value;

        if (!title || title.length < 3) {
            showFeedback('error', '⚠️ Enter a title first (at least 3 characters).');
            return;
        }

        setButtonsDisabled(true);
        showFeedback('loading', 'Analyzing content for best category...');

        try {
            const data = await aiRequest(AI_ROUTES.category, { title, body: body || '' });
            if (data.category_id) {
                document.querySelector('[name="category_id"]').value = data.category_id;
                showFeedback('success', '✅ Category set to "' + data.category + '"');
            } else {
                showFeedback('success', '💡 Suggested: "' + data.category + '" (not found in your categories)');
            }
        } catch (e) {
            showFeedback('error', '❌ ' + e.message);
        } finally {
            setButtonsDisabled(false);
        }
    }

    async function aiImproveWriting() {
        const bodyEl = document.querySelector('[name="body"]');
        if (!bodyEl.value || bodyEl.value.length < 50) {
            showFeedback('error', '⚠️ Write at least 50 characters in the body first.');
            return;
        }

        if (!confirm('This will replace your current body text with an improved version. Continue?')) {
            return;
        }

        setButtonsDisabled(true);
        showFeedback('loading', 'Improving your writing — this may take a moment...');

        try {
            const data = await aiRequest(AI_ROUTES.improve, { body: bodyEl.value });
            bodyEl.value = data.body;
            showFeedback('success', '✅ Writing improved! Review the changes.');
        } catch (e) {
            showFeedback('error', '❌ ' + e.message);
        } finally {
            setButtonsDisabled(false);
        }
    }

    async function aiGenerateOutline() {
        const title = document.querySelector('[name="title"]').value;
        const bodyEl = document.querySelector('[name="body"]');

        if (!title || title.length < 3) {
            showFeedback('error', '⚠️ Enter a title first (at least 3 characters).');
            return;
        }

        if (bodyEl.value && bodyEl.value.length > 20) {
            if (!confirm('This will replace your current body text with a generated outline. Continue?')) {
                return;
            }
        }

        setButtonsDisabled(true);
        showFeedback('loading', 'Generating outline from your title...');

        try {
            const data = await aiRequest(AI_ROUTES.outline, { title });
            bodyEl.value = data.outline;
            showFeedback('success', '✅ Outline generated! Start filling in the sections.');
        } catch (e) {
            showFeedback('error', '❌ ' + e.message);
        } finally {
            setButtonsDisabled(false);
        }
    }

    // Auto-hide success feedback after 5 seconds
    const observer = new MutationObserver(() => {
        const fb = document.getElementById('ai-feedback');
        if (fb.classList.contains('success')) {
            setTimeout(() => { fb.className = 'ai-feedback'; }, 5000);
        }
    });
    observer.observe(document.getElementById('ai-feedback'), { attributes: true });
</script>
