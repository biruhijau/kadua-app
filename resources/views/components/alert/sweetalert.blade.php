@props([
    'type' => null,
    'status' => null,
    'title' => null,
    'text' => null,
    'confirm' => false,
    'confirmText' => null,
    'cancelText' => null,
    'danger' => false,
])

@php
    /**
     * Map the Laravel flash `status` value to an alert type and message.
     *
     * @var array<string, array{type: string, text: string}>
     */
    $statusMap = [
        'user-created' => ['type' => 'success', 'text' => __('Pengguna berhasil dibuat.')],
        'user-updated' => ['type' => 'success', 'text' => __('Pengguna berhasil diperbarui.')],
        'user-deleted' => ['type' => 'success', 'text' => __('Pengguna berhasil dihapus.')],
        'role-created' => ['type' => 'success', 'text' => __('Peran berhasil dibuat.')],
        'role-updated' => ['type' => 'success', 'text' => __('Peran berhasil diperbarui.')],
        'role-deleted' => ['type' => 'success', 'text' => __('Peran berhasil dihapus.')],
        'profile-updated' => ['type' => 'success', 'text' => __('Profil berhasil diperbarui.')],
        'password-updated' => ['type' => 'success', 'text' => __('Kata sandi berhasil diperbarui.')],
        'session-revoked' => ['type' => 'success', 'text' => __('Perangkat berhasil dikeluarkan.')],
        'sessions-revoked' => ['type' => 'success', 'text' => __('Semua perangkat lain berhasil dikeluarkan.')],
        'verification-link-sent' => ['type' => 'info', 'text' => __('Tautan verifikasi baru telah dikirim ke email Anda.')],
    ];

    $mapped = $status !== null ? ($statusMap[$status] ?? null) : null;

    $resolvedType = $type ?? $mapped['type'] ?? null;
    $resolvedText = $text ?? $mapped['text'] ?? null;

    $shouldRender = $confirm || $resolvedType !== null;

    if ($shouldRender && $resolvedText === null && $title === null && ! $confirm) {
        $shouldRender = false;
    }

    if ($shouldRender && $resolvedType === null) {
        $resolvedType = 'info';
    }

    $payload = [
        'type' => $resolvedType,
        'title' => $title,
        'text' => $resolvedText,
        'confirm' => (bool) $confirm,
        'confirmText' => $confirmText,
        'cancelText' => $cancelText,
        'danger' => (bool) $danger,
    ];

    $payload = array_filter($payload, fn ($value) => $value !== null && $value !== false);
@endphp

@if ($shouldRender)
    <span data-swal="{{ json_encode($payload, JSON_UNESCAPED_UNICODE) }}" hidden></span>
@endif
