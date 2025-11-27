<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Seller;

class SellerStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $seller;
    public $status;
    public $reason;

    /**
     * Create a new message instance.
     */
    public function __construct(Seller $seller, string $status, ?string $reason = null)
    {
        $this->seller = $seller;
        // normalisasi ke lowercase agar perbandingan konsisten ('accepted' / 'rejected')
        $this->status = strtolower($status);
        $this->reason = $reason;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Tentukan subject otomatis
        if ($this->status === 'accepted') {
            $subject = 'Akun Penjual Anda Telah Disetujui';
        } elseif ($this->status === 'rejected') {
            $subject = 'Pendaftaran Penjual Anda Ditolak';
        } else {
            $subject = 'Perubahan Status Akun Penjual';
        }

        return $this->subject($subject)
                    ->view('emails.seller_status_changed');
    }
}

