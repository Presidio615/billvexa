@foreach($accounts as $account)
    <div class="card mb-3 p-3">
        <h5>{{ $account->bank_name }}</h5>
        <p><strong>Account Name:</strong> {{ $account->account_name }}</p>
        <p><strong>Account Number:</strong> {{ $account->account_number }}</p>

        @if($account->qr_code)
            <img src="{{ asset('storage/' . $account->qr_code) }}" width="200">
        @endif
    </div>
@endforeach