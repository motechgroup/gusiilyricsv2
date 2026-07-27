@extends('layouts.admin')

@section('title', 'Manage System Mail Templates - Admin')

@section('content')
<div class="space-y-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-gray-800">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white">✉️ Outgoing Mail Templates & Branding</h1>
            <p class="text-xs text-gray-400 mt-1">Manage system transactional email templates, live browser previews, custom footers, and dispatch test notifications.</p>
        </div>
        <a href="{{ route('admin.settings.index') }}#smtp" class="px-5 py-2.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 font-bold text-xs shadow-md border border-gray-700">
            ⚙️ SMTP Server Settings
        </a>
    </div>

    <!-- Email Footer & Identity Settings Form -->
    <form method="POST" action="{{ route('admin.settings.update') }}" class="p-6 rounded-3xl bg-gray-950/80 border border-emerald-500/30 space-y-6">
        @csrf
        <input type="hidden" name="section" value="smtp">

        <div class="flex items-center justify-between border-b border-gray-800 pb-4">
            <div>
                <h3 class="text-base font-extrabold text-white flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-emerald-400"></span> Global Email Identity & Branded Footer
                </h3>
                <p class="text-xs text-gray-400 mt-0.5">Customize the email header branding, sender info, and footer identity included on every outgoing email.</p>
            </div>
            <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold text-xs shadow">
                Save Mail Identity
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Default Sender Name</label>
                <input type="text" name="mail_from_name" value="{{ $settings['mail_from_name'] ?? 'Gusii Lyrics' }}" required class="w-full px-3.5 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500 font-semibold">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Default Sender Address</label>
                <input type="email" name="mail_from_address" value="{{ $settings['mail_from_address'] ?? 'info@gusiilyrics.com' }}" required class="w-full px-3.5 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500 font-mono">
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Custom Email Footer Disclaimer / Brand Note</label>
                <textarea name="email_footer_text" rows="2" class="w-full px-3.5 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500" placeholder="Preserving Gusii music heritage, song lyrics, translations, and official streaming links for Omogusii worldwide.">{{ $settings['email_footer_text'] ?? '' }}</textarea>
                <span class="text-[10px] text-gray-500 mt-1 block">Appears at the very bottom of all HTML email templates alongside the site copyright and quick portal links.</span>
            </div>
        </div>
    </form>

    <!-- Templates Gallery Grid -->
    <div class="space-y-4">
        <h3 class="text-lg font-extrabold text-white">System Email Templates</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($templates as $tpl)
                <div class="p-6 rounded-3xl bg-gray-950/80 border border-gray-800 flex flex-col justify-between gap-6 hover:border-gray-700 transition">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[10px] font-bold font-mono uppercase tracking-wider">
                                {{ $tpl['id'] }}
                            </span>
                            <span class="text-[11px] text-gray-400 font-mono">View: {{ $tpl['view'] }}</span>
                        </div>

                        <h4 class="text-base font-bold text-white">{{ $tpl['name'] }}</h4>
                        <p class="text-xs text-gray-400 leading-relaxed">{{ $tpl['description'] }}</p>

                        <div class="p-3 rounded-xl bg-gray-900 border border-gray-800 text-[11px] font-mono text-gray-300">
                            <strong class="text-gray-500">Subject:</strong> {{ $tpl['subject'] }}
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-800/80 flex flex-wrap items-center justify-between gap-3">
                        <button onclick="previewMailTemplate('{{ $tpl['id'] }}', '{{ addslashes($tpl['name']) }}')" class="px-4 py-2 rounded-xl bg-gray-800 hover:bg-gray-700 text-emerald-400 font-bold text-xs border border-gray-700 flex items-center gap-1.5">
                            👁️ Live Preview
                        </button>

                        <button onclick="openTestModal('{{ $tpl['id'] }}', '{{ addslashes($tpl['name']) }}')" class="px-4 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs shadow flex items-center gap-1.5">
                            📨 Send Test Email
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>

<!-- Live Email Preview Modal -->
<div id="emailPreviewModal" class="hidden fixed inset-0 z-50 bg-slate-950/90 backdrop-blur-md flex items-center justify-center p-4">
    <div class="bg-gray-950 border border-gray-800 rounded-3xl w-full max-w-4xl max-h-[90vh] flex flex-col shadow-2xl overflow-hidden">
        <div class="flex items-center justify-between p-4 sm:p-6 border-b border-gray-800 bg-gray-900/60">
            <div>
                <h3 id="previewTitle" class="text-lg font-extrabold text-white">Email Preview</h3>
                <p class="text-xs text-gray-400">Live HTML rendering with branded header & footer.</p>
            </div>
            <button onclick="document.getElementById('emailPreviewModal').classList.add('hidden')" class="p-2 text-gray-400 hover:text-white text-xl font-bold">
                &times;
            </button>
        </div>
        <div class="p-4 flex-grow overflow-auto bg-gray-950">
            <iframe id="previewIframe" src="about:blank" class="w-full h-[65vh] rounded-2xl border border-gray-800 bg-white"></iframe>
        </div>
    </div>
</div>

<!-- Send Test Email Modal -->
<div id="sendTestModal" class="hidden fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4">
    <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 sm:p-8 max-w-md w-full relative shadow-2xl space-y-4">
        <button onclick="document.getElementById('sendTestModal').classList.add('hidden')" class="absolute top-4 right-4 p-2 text-gray-400 hover:text-white text-xl font-bold">
            &times;
        </button>

        <div>
            <h3 class="text-xl font-extrabold text-white">Dispatch Test Email</h3>
            <p id="testModalSubtitle" class="text-xs text-gray-400 mt-1">Send a test notification to verify delivery.</p>
        </div>

        <form method="POST" action="{{ route('admin.mail-templates.send-test') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="template" id="testTemplateInput" value="">

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-300 mb-1">Recipient Email Address *</label>
                <input type="email" name="recipient" required placeholder="admin@gusiilyrics.com" value="{{ auth()->user()->email ?? '' }}" class="w-full px-3.5 py-2.5 bg-gray-950 border border-gray-800 rounded-xl text-white text-xs font-mono focus:outline-none focus:border-emerald-500">
            </div>

            <div class="pt-2 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('sendTestModal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-gray-800 text-gray-300 font-bold text-xs">
                    Cancel
                </button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-extrabold text-xs shadow">
                    Send Test Now &rarr;
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewMailTemplate(templateId, templateName) {
    document.getElementById('previewTitle').innerText = 'Preview: ' + templateName;
    document.getElementById('previewIframe').src = '/admin/mail-templates/' + templateId + '/preview';
    document.getElementById('emailPreviewModal').classList.remove('hidden');
}

function openTestModal(templateId, templateName) {
    document.getElementById('testTemplateInput').value = templateId;
    document.getElementById('testModalSubtitle').innerText = 'Send a test email for "' + templateName + '".';
    document.getElementById('sendTestModal').classList.remove('hidden');
}
</script>
@endsection
