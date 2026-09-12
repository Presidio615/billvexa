@if(in_array($transaction->status, ['successful', 'success']))
    <a href="{{ route('transaction.receipt', $transaction) }}"
       class="btn btn-sm btn-outline-primary"
       target="_blank">

        <i class="bi bi-file-earmark-pdf"></i>
        Download Receipt

    </a>
@endif