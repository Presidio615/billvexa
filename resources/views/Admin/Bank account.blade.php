<form action="{{ route('bank-accounts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Bank Name</label>
    <input type="text" name="bank_name">

    <label>Account Name</label>
    <input type="text" name="account_name">

    <label>Account Number</label>
    <input type="text" name="account_number">

    <label>Type</label>
    <select name="type">
        <option>Bank</option>
        <option>GCash</option>
        <option>Maya</option>
    </select>

    <label>QR Code</label>
    <input type="file" name="qr_code">

    <button type="submit">Save</button>
</form>