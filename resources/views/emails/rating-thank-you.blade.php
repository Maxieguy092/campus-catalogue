<<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #f59e0b, #ffb347); color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .content { background: #f9f9f9; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .product-info { background: white; padding: 15px; border-left: 4px solid #f59e0b; margin: 15px 0; }
        .rating-stars { color: #f59e0b; font-size: 18px; }
        .footer { text-align: center; color: #999; font-size: 12px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Terima Kasih Atas Rating Anda!</h2>
            <p>Kami sangat menghargai feedback dari Anda</p>
        </div>

        <div class="content">
            <p>Halo {{ $rating->name }},</p>

            <p>Terima kasih telah memberikan rating dan komentar Anda untuk produk di Campus Marketplace!</p>

            <div class="product-info">
                <h3 style="margin: 0 0 10px 0;">{{ $product->name }}</h3>
                <p style="margin: 5px 0;"><strong>Kategori:</strong> {{ $product->category->name ?? '-' }}</p>
                <p style="margin: 5px 0;"><strong>Rating Anda:</strong> <span class="rating-stars">{{ str_repeat('⭐', $rating->rating) }}</span> ({{ $rating->rating }}/5)</p>
                <p style="margin: 5px 0;"><strong>Provinsi:</strong> {{ $rating->province }}</p>
                @if($rating->comment)
                <p style="margin: 5px 0;"><strong>Komentar:</strong> "{{ $rating->comment }}"</p>
                @endif
            </div>

            <p>Rating Anda membantu pembeli lain membuat keputusan yang tepat. Terima kasih telah berkontribusi dalam ekosistem Campus Marketplace!</p>

            <p>Jika Anda memiliki pertanyaan atau ingin memberikan feedback tambahan, jangan ragu untuk menghubungi kami.</p>

            <p>Salam hangat,<br>
            Tim Campus Marketplace</p>
        </div>

        <div class="footer">
            <p>Email ini dikirim dari Campus Marketplace. Jangan balas email ini.</p>
        </div>
    </div>
</body>
</html>
