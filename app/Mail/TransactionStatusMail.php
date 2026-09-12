<?php

namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransactionStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public Transaction $transaction;
    public string $action;

    /**
     * Create a new message instance.
     */
    public function __construct(Transaction $transaction, string $action)
    {
        $this->transaction = $transaction;
        $this->action = $action;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject(
            'BillVexa Transaction ' . ucfirst($this->action)
        )->view('emails.transaction-status');
    }
}