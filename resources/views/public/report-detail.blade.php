@extends('layouts.app')

@section('title', $report->title . ' - ' . $siteSettings['site_name'])

@section('content')
<article class="pb-16" id="report-detail"
    data-like-url="{{ route('reports.like', $report) }}"
    data-comment-url="{{ route('reports.comments.store', $report) }}"
    data-liked="{{ $liked ? '1' : '0' }}">
    {{-- Header ringkas --}}
    <div class="border-b border-stone-200 bg-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 py-8 sm:py-10">
            <a href="{{ route('timeline') }}" class="inline-flex items-center gap-1.5 text-sm text-emerald-700 hover:text-emerald-800 font-medium mb-5">
                <span aria-hidden="true">&larr;</span> Timeline
            </a>

            <h1 class="text-3xl sm:text-4xl font-bold text-stone-900 tracking-tight leading-tight">
                {{ $report->title }}
            </h1>

            <div class="mt-5 flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-stone-500">
                <time datetime="{{ $report->activity_date->format('Y-m-d') }}">
                    {{ $report->activity_date->translatedFormat('d F Y') }}
                </time>
                @if($report->location)
                    <span class="hidden sm:inline text-stone-300" aria-hidden="true">|</span>
                    <span>{{ $report->location }}</span>
                @endif
            </div>

            <a href="{{ route('members.show', $report->member) }}"
               class="mt-5 inline-flex items-center gap-3 rounded-full bg-stone-50 hover:bg-emerald-50 border border-stone-200 hover:border-emerald-200 pl-1.5 pr-4 py-1.5 transition">
                <img src="{{ $report->member->photoUrl() }}" alt="" class="w-9 h-9 rounded-full object-cover">
                <div class="leading-tight">
                    <p class="text-sm font-semibold text-stone-800">{{ $report->member->user->name }}</p>
                    <p class="text-xs text-stone-500">{{ $report->member->jabatan ?: 'Anggota KKN' }}</p>
                </div>
            </a>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6">
        {{-- Media --}}
        <div class="mt-8">
            @if($report->youtubeEmbedUrl())
                <div class="aspect-video rounded-2xl overflow-hidden bg-stone-900 shadow-md ring-1 ring-black/5">
                    <iframe
                        src="{{ $report->youtubeEmbedUrl() }}"
                        title="{{ $report->title }}"
                        class="w-full h-full"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen
                        loading="lazy">
                    </iframe>
                </div>
            @else
                <div class="aspect-video rounded-2xl overflow-hidden bg-stone-100 shadow-md ring-1 ring-black/5">
                    <img src="{{ $report->coverUrl() }}" alt="{{ $report->title }}" class="w-full h-full object-cover">
                </div>
            @endif
        </div>

        {{-- Deskripsi --}}
        <div class="mt-8 text-stone-700 text-base sm:text-[1.05rem] leading-8 whitespace-pre-line">
            {{ $report->description }}
        </div>

        {{-- Aksi suka --}}
        <div class="mt-8 flex flex-wrap items-center justify-between gap-3 rounded-2xl bg-white border border-stone-200 px-4 py-3.5 shadow-sm">
            <div class="flex items-center gap-4 text-sm text-stone-600">
                <span>
                    <span id="likes-count" class="font-semibold text-stone-900">{{ $report->likes_count }}</span> suka
                </span>
                <span class="text-stone-300">|</span>
                <span>
                    <span id="comments-count" class="font-semibold text-stone-900">{{ $report->comments_count }}</span> komentar
                </span>
            </div>

            @auth
                <button type="button" id="like-btn"
                    class="inline-flex items-center gap-2 text-sm font-medium px-4 py-2 rounded-full transition {{ $liked ? 'bg-emerald-600 text-white hover:bg-emerald-700' : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100' }}">
                    <span id="like-icon" aria-hidden="true">{{ $liked ? '♥' : '♡' }}</span>
                    <span id="like-label">{{ $liked ? 'Disukai' : 'Suka' }}</span>
                </button>
            @else
                <a href="{{ route('login') }}"
                   class="inline-flex items-center text-sm font-medium text-emerald-700 hover:text-emerald-800">
                    Login untuk berinteraksi &rarr;
                </a>
            @endauth
        </div>

        {{-- Dokumentasi Foto --}}
        @if($report->photos->isNotEmpty())
            <section class="mt-12">
                <div class="flex items-end justify-between gap-3 mb-5">
                    <div>
                        <h2 class="text-lg font-bold text-stone-900">Dokumentasi Foto</h2>
                        <p class="text-sm text-stone-500 mt-0.5">{{ $report->photos->count() }} foto kegiatan</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 sm:gap-3">
                    @foreach($report->photos as $photo)
                        <a href="{{ $photo->url() }}" target="_blank" rel="noopener"
                           class="group relative aspect-square rounded-xl overflow-hidden bg-stone-100 ring-1 ring-stone-200/80">
                            <img src="{{ $photo->url() }}" alt="Dokumentasi foto"
                                 class="w-full h-full object-cover transition duration-300 group-hover:scale-105">
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Komentar --}}
        <section id="komentar" class="mt-12">
            <h2 class="text-lg font-bold text-stone-900 mb-1">Komentar</h2>
            <p id="comments-subtitle" class="text-sm text-stone-500 mb-5">
                @if($report->comments_count > 0)
                    {{ $report->comments_count }} komentar dari anggota
                @else
                    Belum ada komentar
                @endif
            </p>

            @auth
                <form id="comment-form" class="mb-8 rounded-2xl bg-white border border-stone-200 p-4 shadow-sm">
                    <label for="comment-body" class="sr-only">Tulis komentar</label>
                    <textarea id="comment-body" name="body" rows="3" required maxlength="1000"
                        placeholder="Bagikan tanggapan atau apresiasi untuk kegiatan ini..."
                        class="w-full rounded-xl border border-stone-200 bg-stone-50 px-3.5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white resize-y min-h-[88px]"></textarea>
                    <p id="comment-error" class="hidden text-red-600 text-xs mt-1.5"></p>
                    <div class="mt-3 flex justify-end">
                        <button type="submit" id="comment-submit"
                            class="bg-emerald-600 text-white text-sm font-medium px-5 py-2 rounded-full hover:bg-emerald-700 transition disabled:opacity-60">
                            Kirim
                        </button>
                    </div>
                </form>
            @else
                <div class="mb-8 rounded-2xl border border-dashed border-stone-300 bg-stone-50 px-5 py-6 text-center">
                    <p class="text-sm text-stone-600">
                        <a href="{{ route('login') }}" class="font-medium text-emerald-700 hover:underline">Login</a>
                        dulu untuk menulis komentar.
                    </p>
                </div>
            @endauth

            <div id="comments-list" class="space-y-3">
                @forelse($report->comments as $comment)
                    <div class="comment-item rounded-2xl bg-white border border-stone-200 px-4 py-4" data-comment-id="{{ $comment->id }}">
                        <div class="flex items-start gap-3">
                            <div class="shrink-0 inline-flex h-9 w-9 items-center justify-center rounded-full bg-emerald-100 text-emerald-800 text-sm font-semibold">
                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-semibold text-stone-800">{{ $comment->user->name }}</p>
                                        <p class="text-xs text-stone-400 mt-0.5">{{ $comment->created_at->diffForHumans() }}</p>
                                    </div>
                                    @auth
                                        @if(auth()->user()->isAdmin() || auth()->id() === $comment->user_id)
                                            <button type="button"
                                                class="comment-delete text-xs text-stone-400 hover:text-red-600 transition"
                                                data-delete-url="{{ route('reports.comments.destroy', $comment) }}">
                                                Hapus
                                            </button>
                                        @endif
                                    @endauth
                                </div>
                                <p class="text-sm text-stone-700 mt-2 leading-relaxed whitespace-pre-line">{{ $comment->body }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p id="comments-empty" class="text-sm text-stone-500 text-center py-6">Jadilah yang pertama berkomentar.</p>
                @endforelse
            </div>
        </section>

        <div class="mt-12 pt-6 border-t border-stone-200">
            <a href="{{ route('timeline') }}" class="text-sm font-medium text-emerald-700 hover:text-emerald-800">
                &larr; Kembali ke timeline kegiatan
            </a>
        </div>
    </div>
</article>
@endsection

@push('scripts')
<script>
(function () {
    const root = document.getElementById('report-detail');
    if (!root) return;

    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    if (!csrf) return;

    const likesCountEl = document.getElementById('likes-count');
    const commentsCountEl = document.getElementById('comments-count');
    const commentsSubtitle = document.getElementById('comments-subtitle');
    const commentsList = document.getElementById('comments-list');
    const likeBtn = document.getElementById('like-btn');
    const likeIcon = document.getElementById('like-icon');
    const likeLabel = document.getElementById('like-label');
    const commentForm = document.getElementById('comment-form');

    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    async function request(url, options = {}) {
        const { headers: extraHeaders, ...rest } = options;
        const res = await fetch(url, {
            credentials: 'same-origin',
            ...rest,
            headers: {
                'X-CSRF-TOKEN': csrf,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                ...(extraHeaders || {}),
            },
        });

        const data = await res.json().catch(() => ({}));

        if (res.status === 401 || res.status === 419) {
            window.location.href = '{{ route('login') }}';
            throw new Error('Unauthenticated');
        }

        if (!res.ok) {
            const message = data.message
                || (data.errors ? Object.values(data.errors).flat().join(' ') : null)
                || 'Terjadi kesalahan. Coba lagi.';
            throw new Error(message);
        }

        if (typeof data.likes_count === 'undefined' && typeof data.comments_count === 'undefined' && typeof data.liked === 'undefined' && !data.comment) {
            throw new Error('Respons server tidak valid. Coba refresh halaman.');
        }

        return data;
    }

    function setLikedUi(liked) {
        if (!likeBtn) return;
        likeBtn.classList.toggle('bg-emerald-600', liked);
        likeBtn.classList.toggle('text-white', liked);
        likeBtn.classList.toggle('hover:bg-emerald-700', liked);
        likeBtn.classList.toggle('bg-emerald-50', !liked);
        likeBtn.classList.toggle('text-emerald-800', !liked);
        likeBtn.classList.toggle('hover:bg-emerald-100', !liked);
        if (likeIcon) likeIcon.textContent = liked ? '♥' : '♡';
        if (likeLabel) likeLabel.textContent = liked ? 'Disukai' : 'Suka';
        root.dataset.liked = liked ? '1' : '0';
    }

    function updateCommentsMeta(count) {
        if (commentsCountEl) commentsCountEl.textContent = count;
        if (commentsSubtitle) {
            commentsSubtitle.textContent = count > 0
                ? count + ' komentar dari anggota'
                : 'Belum ada komentar';
        }
        const empty = document.getElementById('comments-empty');
        if (empty && count > 0) empty.remove();
        if (count === 0 && commentsList && !document.getElementById('comments-empty')) {
            const p = document.createElement('p');
            p.id = 'comments-empty';
            p.className = 'text-sm text-stone-500 text-center py-6';
            p.textContent = 'Jadilah yang pertama berkomentar.';
            commentsList.appendChild(p);
        }
    }

    function bindDeleteButtons(scope = document) {
        scope.querySelectorAll('.comment-delete').forEach((btn) => {
            if (btn.dataset.bound) return;
            btn.dataset.bound = '1';
            btn.addEventListener('click', async () => {
                if (!confirm('Hapus komentar ini?')) return;
                btn.disabled = true;
                try {
                    const data = await request(btn.dataset.deleteUrl, {
                        method: 'POST',
                        body: formBody({ _method: 'DELETE' }),
                    });
                    const item = btn.closest('.comment-item');
                    item?.remove();
                    updateCommentsMeta(data.comments_count);
                } catch (e) {
                    alert(e.message);
                    btn.disabled = false;
                }
            });
        });
    }

    function renderComment(comment) {
        const wrap = document.createElement('div');
        wrap.className = 'comment-item rounded-2xl bg-white border border-stone-200 px-4 py-4';
        wrap.dataset.commentId = comment.id;
        wrap.innerHTML = `
            <div class="flex items-start gap-3">
                <div class="shrink-0 inline-flex h-9 w-9 items-center justify-center rounded-full bg-emerald-100 text-emerald-800 text-sm font-semibold">
                    ${escapeHtml(comment.user_initial)}
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-stone-800">${escapeHtml(comment.user_name)}</p>
                            <p class="text-xs text-stone-400 mt-0.5">${escapeHtml(comment.created_at)}</p>
                        </div>
                        ${comment.can_delete ? `<button type="button" class="comment-delete text-xs text-stone-400 hover:text-red-600 transition" data-delete-url="${escapeHtml(comment.delete_url)}">Hapus</button>` : ''}
                    </div>
                    <p class="text-sm text-stone-700 mt-2 leading-relaxed whitespace-pre-line">${escapeHtml(comment.body)}</p>
                </div>
            </div>
        `;
        return wrap;
    }

    function formBody(fields = {}) {
        const fd = new FormData();
        fd.append('_token', csrf);
        Object.entries(fields).forEach(([key, value]) => fd.append(key, value));
        return fd;
    }

    if (likeBtn) {
        likeBtn.addEventListener('click', async () => {
            likeBtn.disabled = true;
            try {
                const data = await request(root.dataset.likeUrl, {
                    method: 'POST',
                    body: formBody(),
                });
                setLikedUi(!!data.liked);
                if (likesCountEl && typeof data.likes_count !== 'undefined') {
                    likesCountEl.textContent = data.likes_count;
                }
            } catch (e) {
                alert(e.message);
            } finally {
                likeBtn.disabled = false;
            }
        });
    }

    if (commentForm) {
        commentForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const textarea = document.getElementById('comment-body');
            const errorEl = document.getElementById('comment-error');
            const submitBtn = document.getElementById('comment-submit');
            const body = (textarea?.value || '').trim();

            if (errorEl) {
                errorEl.classList.add('hidden');
                errorEl.textContent = '';
            }

            if (body.length < 2) {
                if (errorEl) {
                    errorEl.textContent = 'Komentar minimal 2 karakter.';
                    errorEl.classList.remove('hidden');
                }
                return;
            }

            submitBtn.disabled = true;
            try {
                const data = await request(root.dataset.commentUrl, {
                    method: 'POST',
                    body: formBody({ body }),
                });

                if (!data.comment || !data.comment.id) {
                    throw new Error(data.message || 'Gagal memuat komentar. Coba refresh halaman.');
                }

                document.getElementById('comments-empty')?.remove();
                const node = renderComment(data.comment);
                commentsList.prepend(node);
                bindDeleteButtons(node);
                updateCommentsMeta(data.comments_count);
                textarea.value = '';
            } catch (err) {
                if (errorEl) {
                    errorEl.textContent = err.message;
                    errorEl.classList.remove('hidden');
                } else {
                    alert(err.message);
                }
            } finally {
                submitBtn.disabled = false;
            }
        });
    }

    bindDeleteButtons();
})();
</script>
@endpush
