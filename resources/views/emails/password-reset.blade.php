@component('mail::message')
# Reset Password - SIAKRA

Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.

@component('mail::button', ['url' => $actionUrl])
Reset Password
@endcomponent

Link reset password ini akan berakhir dalam {{ $count }} menit.

Jika Anda tidak meminta reset password, tidak ada tindakan lebih lanjut yang diperlukan.

Terima kasih,<br>
Tim {{ config('app.name') }}

---

**Catatan Keamanan:**
- Jangan bagikan link ini kepada siapa pun
- Link ini hanya berlaku sekali pakai
- Jika Anda merasa email ini mencurigakan, jangan klik link dan hubungi administrator

@endcomponent