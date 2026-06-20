@php
    $user = auth()->user();
    $roleName = $user?->roles->first()?->name ?? 'User';
    $roleLabel = str($roleName)->replace('_', ' ')->title();
@endphp

{{--
    Catatan: warna-warna penting di bawah ini sengaja ditulis sebagai CSS
    biasa (bukan utility class Tailwind seperti bg-orange-500/10 dll).
    Ini karena class warna dengan opacity-modifier sering ter-purge oleh
    Tailwind kalau file blade ini tidak terdaftar di content path build kamu,
    hasilnya ring/badge jadi default biru polos. Dengan CSS manual, tampilan
    dijamin konsisten tanpa tergantung konfigurasi build.
--}}
<style>
    .hse-card {
        background: #f9fafb;
        box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.06);
    }
    .dark .hse-card {
        background: rgba(255, 255, 255, 0.05);
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.1);
    }

    .hse-avatar {
        background: linear-gradient(135deg, #0b1c36, #000000);
        box-shadow: 0 1px 3px rgba(37, 99, 235, 0.35);
    }

    .hse-online-dot {
        background: #10b981;
        box-shadow: 0 0 0 2px #f9fafb;
    }
    .dark .hse-online-dot {
        box-shadow: 0 0 0 2px #111827;
    }

    .hse-badge {
        background: #eff6ff;
        color: #ffffff;
        box-shadow: inset 0 0 0 1px rgba(37, 99, 235, 0.12);
    }
    .dark .hse-badge {
        background: rgba(0, 0, 0, 0.12);
        color: #ffffff;
        box-shadow: inset 0 0 0 1px rgba(96, 165, 250, 0.2);
    }

    .hse-btn-logout {
        color: #dc2626;
        background: #fef2f2;
        box-shadow: inset 0 0 0 1px rgba(220, 38, 38, 0.12);
        transition: background-color 0.15s ease;
    }
    .hse-btn-logout:hover {
        background: #fee2e2;
    }
    .dark .hse-btn-logout {
        color: #f87171;
        background: rgba(239, 68, 68, 0.1);
        box-shadow: inset 0 0 0 1px rgba(248, 113, 113, 0.2);
    }
    .dark .hse-btn-logout:hover {
        background: rgba(239, 68, 68, 0.18);
    }

    .hse-modal-backdrop {
        position: fixed;
        inset: 0;
        z-index: 999998;
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        background: rgba(3, 7, 18, 0.5);
    }
    .dark .hse-modal-backdrop {
        background: rgba(3, 7, 18, 0.75);
    }

    .hse-modal-wrapper {
        position: fixed;
        inset: 0;
        z-index: 999999;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
        padding: 1rem;
    }

    .hse-modal-panel {
        background: #ffffff;
        box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.08), 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .dark .hse-modal-panel {
        background: #111827;
        box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.1), 0 20px 25px -5px rgba(0, 0, 0, 0.4);
    }

    .hse-icon-circle {
        background: #fef2f2;
        box-shadow: 0 0 0 8px rgba(254, 242, 242, 0.5);
    }
    .dark .hse-icon-circle {
        background: rgba(239, 68, 68, 0.1);
        box-shadow: 0 0 0 8px rgba(239, 68, 68, 0.05);
    }

    .hse-btn-cancel {
        color: #030712;
        background: #ffffff;
        box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.1);
        transition: background-color 0.15s ease;
    }
    .hse-btn-cancel:hover {
        background: #f9fafb;
    }
    .dark .hse-btn-cancel {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.05);
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.1);
    }
    .dark .hse-btn-cancel:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .hse-btn-confirm {
        color: #ffffff;
        background: #dc2626;
        box-shadow: 0 1px 3px rgba(220, 38, 38, 0.3);
        transition: background-color 0.15s ease;
    }
    .hse-btn-confirm:hover {
        background: #ef4444;
    }
</style>

<div
    x-data="{ showLogoutModal: false }"
    @keydown.escape.window="showLogoutModal = false"
    class="mt-auto px-3 pb-6"
>
    {{-- ── Garis Pemisah Halus ── --}}
    <div class="h-px w-full bg-gray-950/5 dark:bg-white/10 mb-4"></div>

    {{-- ── Kartu Profil Pengguna ── --}}
    <div class="hse-card flex items-center gap-3 rounded-xl px-3 py-2.5 mb-4">

        {{-- Avatar Gradasi Oranye + Indikator Online --}}
        <div class="relative shrink-0">
            <div class="hse-avatar flex h-9 w-9 items-center justify-center rounded-full text-white font-bold text-sm">
                {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
            </div>
            <span class="hse-online-dot absolute -bottom-0.5 -right-0.5 h-2.5 w-2.5 rounded-full"></span>
        </div>

        {{-- Info Teks --}}
        <div class="flex flex-col flex-1 min-w-0">
            <span class="text-sm font-semibold text-gray-950 dark:text-white truncate">
                {{ $user?->name ?? 'Pengguna' }}
            </span>
            <span class="hse-badge mt-0.5 inline-flex w-fit items-center rounded-md px-1.5 py-0.5 text-[10px] font-bold uppercase tracking-wide">
                {{ $roleLabel }}
            </span>
        </div>
    </div>

    {{-- ── Tombol Keluar ── --}}
    <button
        type="button"
        @click="showLogoutModal = true"
        class="hse-btn-logout w-full flex items-center justify-center gap-2 rounded-lg px-3 py-2.5 text-sm font-semibold"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        Keluar
    </button>

    {{-- ── Modal Konfirmasi Keluar ── --}}
    <template x-teleport="body">
        <div x-show="showLogoutModal" x-cloak style="display: none;">

            {{-- Backdrop --}}
            <div
                class="hse-modal-backdrop"
                x-show="showLogoutModal"
                x-transition.opacity
                @click="showLogoutModal = false"
            ></div>

            {{-- Wrapper Tengah Layar --}}
            <div class="hse-modal-wrapper">

                {{-- Panel Modal --}}
                <div
                    class="hse-modal-panel relative w-full max-w-sm rounded-xl p-6 pointer-events-auto"
                    x-show="showLogoutModal"
                    x-transition:enter="ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                >
                    <div class="flex flex-col items-center text-center">

                        {{-- Ikon Peringatan --}}
                        <div class="hse-icon-circle h-12 w-12 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </div>

                        <h3 class="text-base font-semibold text-gray-950 dark:text-white mb-1.5">
                            Konfirmasi Keluar
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                            Apakah Anda yakin ingin mengakhiri sesi untuk
                            <span class="font-semibold text-gray-950 dark:text-white">{{ $user?->name }}</span>?
                        </p>

                        {{-- Tombol Aksi --}}
                        <div class="flex w-full gap-2">
                            <button
                                type="button"
                                @click="showLogoutModal = false"
                                class="hse-btn-cancel flex-1 px-4 py-2 text-sm font-semibold rounded-lg"
                            >
                                Batal
                            </button>
                            <form action="{{ route('filament.admin.auth.logout') }}" method="POST" class="flex-1">
                                @csrf
                                <button
                                    type="submit"
                                    class="hse-btn-confirm w-full px-4 py-2 text-sm font-semibold rounded-lg"
                                >
                                    Ya, Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>