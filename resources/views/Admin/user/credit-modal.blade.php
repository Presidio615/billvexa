<div class="modal fade" id="creditModal{{ $user->id }}">

<div class="modal-dialog">

<form method="POST"
      action="{{ route('admin.user.credit',$user->id) }}">

@csrf

<div class="modal-content">

<div class="modal-header">

<h5>Credit Wallet</h5>

<button class="btn-close"
data-bs-dismiss="modal"></button>

</div>

<div class="modal-body">

<label>Amount</label>

<input
type="number"
name="amount"
class="form-control"
required>

</div>

<div class="modal-footer">

<button class="btn btn-success">

Credit Wallet

</button>

</div>

</div>

</form>

</div>

</div>