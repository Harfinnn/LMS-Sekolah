<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<title>Reset Password</title>
<style>
    body { margin:0; padding:0; background:#f4f7f9; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial; }
    .email-wrap { width:100%; padding:30px 16px; box-sizing:border-box; }
    .card { max-width:600px; margin:0 auto; background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 6px 18px rgba(12,12,12,0.06); }
    .header { padding:20px 28px; display:flex; align-items:center; gap:16px; }
    .logo { height:40px; width:auto; }
    .hero { padding:28px; }
    .title { font-size:20px; font-weight:700; margin:0 0 8px 0; color:#111827; }
    .lead { margin:0 0 18px 0; color:#374151; font-size:15px; line-height:1.5; }
    .btn-wrap { text-align:center; margin:18px 0; }
    .btn {
        display:inline-block;
        padding:12px 22px;
        text-decoration:none;
        border-radius:10px;
        font-weight:600;
        color:#ffffff;
        background: {{ $brand_color }};
        box-shadow:0 6px 14px rgba(76, 175, 80, 0.18);
    }
    .note { font-size:13px; color:#6b7280; margin-top:12px; }
    .footer { padding:20px 28px; font-size:13px; color:#9ca3af; text-align:center; background:#fbfdfe; }
    @media only screen and (max-width:420px) {
        .header, .hero, .footer { padding-left:16px; padding-right:16px; }
        .title { font-size:18px; }
    }
</style>
</head>
<body>
<div class="email-wrap">
    <div class="card">
        <div class="header">
            <div style="flex:1">
                <div style="font-size:14px; color:#111827; font-weight:700;">{{ $sender_name }}</div>
                <div style="font-size:12px; color:#6b7280;">Tindakan penting untuk akun Anda</div>
            </div>
        </div>

        <div class="hero">
            <h1 class="title">Reset Password</h1>
            <p class="lead">
                Halo {{ $user->name ?? 'Pengguna' }},<br>
                Kami menerima permintaan untuk mereset password akun Anda. Klik tombol di bawah untuk membuat password baru.
            </p>

            <div class="btn-wrap">
                <a href="{{ $url }}" class="btn" target="_blank" rel="noopener">Reset Password</a>
            </div>

            <p class="note">
                Jika tombol tidak bekerja, salin dan tempel link ini di browser Anda:<br>
                <a href="{{ $url }}" style="color:{{ $brand_color }}; word-break:break-all;">{{ $url }}</a>
            </p>

            <p style="margin-top:18px; color:#374151; font-size:14px;">
                Jika Anda tidak meminta reset password, abaikan email ini. Link reset hanya berlaku sementara.
            </p>
        </div>

        <div class="footer">
            © {{ date('Y') }} {{ $sender_name }} — Semua hak dilindungi.
        </div>
    </div>
</div>
</body>
</html>
