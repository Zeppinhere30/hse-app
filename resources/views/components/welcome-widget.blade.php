@php
    $user = auth()->user();
    $roleName = $user?->roles->first()?->name ?? 'User';
    $roleLabel = str($roleName)->replace('_', ' ')->title();
    $tip = $this->getTipOfTheDay();
@endphp

<x-filament-widgets::widget>
    <x-filament::section>

        {{-- ── HEADER: Profil & Tombol Keluar ── --}}
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem;">

            {{-- Kiri: Avatar & Info --}}
            <div style="display: flex; align-items: center; gap: 1.25rem;">

                {{-- Avatar Premium Blue --}}
                <div style="width: 56px; height: 56px; border-radius: 16px; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: bold; box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3); flex-shrink: 0;">
                    {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                </div>

                {{-- Teks Info --}}
                <div style="display: flex; flex-direction: column; justify-content: center;">
                    <span class="text-gray-500 dark:text-gray-400" style="font-size: 0.85rem; margin-bottom: 4px; font-weight: 500;">
                        Selamat datang kembali,
                    </span>
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <span class="text-gray-950 dark:text-white" style="font-size: 1.25rem; font-weight: 800; line-height: 1;">
                            {{ $user?->name ?? 'Pengguna' }}
                        </span>
                        {{-- Badge Role --}}
                        <span class="text-gray-600 dark:text-gray-300" style="background-color: rgba(107, 114, 128, 0.12); border: 1px solid rgba(107, 114, 128, 0.2); padding: 4px 10px; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em;">
                            {{ $roleLabel }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Kanan: Tombol Keluar --}}
            <form action="{{ route('filament.admin.auth.logout') }}" method="POST" style="margin: 0;">
                @csrf
                <x-filament::button color="gray" icon="heroicon-o-arrow-right-on-rectangle" type="submit" style="box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    Keluar
                </x-filament::button>
            </form>
        </div>

        {{-- ── BODY: Panel Pengingat K3 (Safety Signage Style) ── --}}
        <div style="margin-top: 2rem; position: relative; border-radius: 18px; overflow: hidden; box-shadow: 0 4px 10px -2px rgba(0,0,0,0.08);">

            {{-- Hazard stripe accent (kuning-hitam khas rambu K3) --}}
            <div style="height: 7px; width: 100%; background-image: repeating-linear-gradient(135deg, #f59e0b 0 14px, #18181b 14px 28px);"></div>

            <div style="background-color: rgba(245, 158, 11, 0.08); border: 1px solid rgba(245, 158, 11, 0.2); border-top: none; padding: 1.5rem; display: flex; gap: 1.25rem; align-items: flex-start;">

                {{-- Icon Shield --}}
                <div style="width: 50px; height: 50px; flex-shrink: 0; border-radius: 14px; background-color: rgba(245, 158, 11, 0.18); display: flex; align-items: center; justify-content: center; color: #d97706; box-shadow: inset 0 0 0 1px rgba(245, 158, 11, 0.4);">
                    <svg style="width: 26px; height: 26px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12c0 4.556-3.04 8.453-7.21 9.685a2.25 2.25 0 01-1.58 0C7.04 20.453 4 16.556 4 12V6.741a2.25 2.25 0 011.21-1.995l6-3.149a2.25 2.25 0 012.08 0l6 3.149A2.25 2.25 0 0121 6.741V12z" />
                    </svg>
                </div>

                {{-- Teks Pengingat K3 --}}
                <div style="flex: 1; display: flex; flex-direction: column; justify-content: center; min-width: 0;">
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; margin-bottom: 0.45rem;">
                        <p style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: #d97706; margin: 0;">
                            ⚠ Pengingat K3 Hari Ini
                        </p>
                        <span style="font-size: 0.7rem; font-weight: 700; color: #d97706; background-color: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); padding: 2px 9px; border-radius: 9999px; white-space: nowrap;">
                            Tip #{{ $tip['number'] }} / {{ $tip['total'] }}
                        </span>
                    </div>
                    <p class="text-gray-800 dark:text-gray-100" style="font-size: 1.05rem; line-height: 1.6; margin: 0; font-weight: 600;">
                        "{{ $tip['text'] }}"
                    </p>
                    <p class="text-gray-500 dark:text-gray-400" style="font-size: 0.78rem; margin: 0.65rem 0 0 0; font-style: italic;">
                        Keselamatan kerja adalah tanggung jawab bersama — laporkan, jangan tunda.
                    </p>
                </div>
            </div>
        </div>

    </x-filament::section>
</x-filament-widgets::widget>