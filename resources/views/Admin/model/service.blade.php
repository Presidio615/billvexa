@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<!--Enable Modal-->
<div class="modal fade" id="enableModal{{ $service->id }}">

    <div class="modal-dialog">

        <div class="modal-content">

            <form method="POST"
            action="{{ route('admin.service.enable',$service) }}">

                @csrf

                <div class="modal-header">

                    <h5 class="modal-title">
                        Enable {{ $service->name }}
                    </h5>

                    <button
                    class="btn-close"
                    data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <p>

                        Enable

                        <strong>

                            {{ $service->name }}

                        </strong>?

                    </p>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-success">
                        Enable
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- Disable Modal-->
<div class="modal fade" id="disableModal{{ $service->id }}">

    <div class="modal-dialog">

        <div class="modal-content">

            <form method="POST"
            action="{{ route('admin.service.disable',$service) }}">

                @csrf

                <div class="modal-header">

                    <h5 class="modal-title">

                        Disable Service

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    Disable

                    <strong>

                        {{ $service->name }}

                    </strong>

                    ?

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-success">
                        Disable
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<!-- Profit Modal -->
<div class="modal fade"
    id="profitModal{{ $service->id }}">

    <div class="modal-dialog">

        <div class="modal-content">

            <form
            method="POST"
            action="{{ route('admin.service.profit',$service) }}">

             @csrf

                <div class="modal-header">

                    <h5 class="modal-title">

                        Profit Margin

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <label>

                        Profit %

                    </label>

                    <input
                    type="number"
                    step="0.01"
                    name="profit"
                    value="{{ $service->profit }}"
                    class="form-control"
                    required>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-warning">
                        Save Profit
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<!-- Charge Modal -->
<div class="modal fade"
    id="chargeModal{{ $service->id }}">

    <div class="modal-dialog">

        <div class="modal-content">

            <form
            method="POST"
            action="{{ route('admin.service.charge',$service) }}">

                @csrf

                <div class="modal-header">

                    <h5 class="modal-title">

                        Service Charge

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <input
                    type="number"
                    name="charge"
                    value="{{ $service->charge }}"
                    class="form-control"
                    required>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-success">
                        Update Charge
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- Limit Modal-->
<div class="modal fade"
    id="limitModal{{ $service->id }}">

    <div class="modal-dialog">

        <div class="modal-content">

            <form
            method="POST"
            action="{{ route('admin.service.limit',$service) }}">

                @csrf

                <div class="modal-header">

                    <h5 class="modal-title">

                        Transaction Limits

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <label>

                        Minimum

                    </label>

                    <input
                    type="number"
                    name="minimum"
                    value="{{ $service->minimum }}"
                    class="form-control mb-3"
                    required>

                    <label>

                        Maximum

                    </label>

                    <input
                    type="number"
                    name="maximum"
                    value="{{ $service->maximum }}"
                    class="form-control"
                    required>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-dark">
                        Save Limits
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<!-- Api Modal -->
<div class="modal fade"
    id="apiModal{{ $service->id }}">

    <div class="modal-dialog">

        <div class="modal-content">

            <form
            method="POST"
            action="{{ route('admin.service.api',$service) }}">

                @csrf

                <div class="modal-header">

                    <h5 class="modal-title">

                        API Configuration

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Provider</label>
                        <input type="text"
                            name="api_name"
                            value="{{ $service->api_name }}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>API Provider</label>

                        <input
                            type="text"
                            name="api_provider"
                            value="{{ $service->api_provider }}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>API Endpoint</label>

                        <input
                            type="text"
                            name="api_endpoint"
                            value="{{ $service->api_endpoint }}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Service Code</label>

                        <input
                            type="text"
                            name="service_code"
                            value="{{ $service->service_code }}"
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>API Key</label>

                        <input
                        type="password"
                        name="api_key"
                        class="form-control"
                        placeholder="Leave blank to keep existing key">
                    </div>

                    <div class="mb-3">
                        <label>API Secret</label>

                        <input
                            type="password"
                            name="api_secret"
                            class="form-control"
                            placeholder="Leave blank to keep current secret">
                    </div>

                    <div class="form-check">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="sandbox"
                            value="1"
                            {{ $service->sandbox ? 'checked' : '' }}>

                        <label class="form-check-label">
                            Sandbox Mode
                        </label>

                    </div>


                </div>

                <div class="modal-footer">

                    <button
                    type="submit"
                        class="btn btn-primary">

                        Save API

                    </button>

                </div>

            </form>

        </div>

    </div>

   
</div>

<!-- Edit service Modal-->
<div class="modal fade" id="editModal{{ $service->id }}">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form
            method="POST"
            action="{{ route('admin.service.update',$service) }}">

                @csrf
                @method('PUT')

                <div class="modal-header">

                    <h5 class="modal-title">Edit Service</h5>


                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <input
                    type="text"
                    name="name"
                    value="{{ $service->name }}"
                    class="form-control mb-3"
                    required>

                    <input
                    type="text"
                    name="provider"
                    value="{{ $service->provider }}"
                    class="form-control mb-3"
                    required>

                    <input
                    type="number"
                    name="charge"
                    value="{{ $service->charge }}"
                    min="0"
                    step="0.01"
                    class="form-control mb-3"
                    required>

                    <input
                    type="number"
                    name="profit"
                    value="{{ $service->profit }}"
                    class="form-control mb-3">

                    <input
                    type="number"
                    name="minimum"
                    value="{{ $service->minimum }}"
                    class="form-control mb-3">

                    <input
                    type="number"
                    name="maximum"
                    value="{{ $service->maximum }}"
                    class="form-control mb-3">

                    <input
                    type="text"
                    name="api_name"
                    value="{{ $service->api_name }}"
                    class="form-control">

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-success">
                        Update Service
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- Delete Model -->
<div class="modal fade"
id="deleteModal{{ $service->id }}">

    <div class="modal-dialog">

        <div class="modal-content">

            <form
            method="POST"
            action="{{ route('admin.service.delete',$service) }}">

                @csrf
                @method('DELETE')

                <div class="modal-header">

                    <h5 class="modal-title">

                        Delete Service

                    </h5>


                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <p>
                        Delete
                        <strong>{{ $service->name }}</strong>?
                    </p>

                    <div class="alert alert-danger mb-0">
                        This action cannot be undone.
                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button
                        type="submit"
                        class="btn btn-danger">

                        Delete

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- Test Api Model -->
<div class="modal fade"
    id="testApi{{ $service->id }}">

    <div class="modal-dialog">

        <div class="modal-content">

            <form
            method="POST"
            action="{{ route('admin.service.test',$service) }}">

                @csrf

                <div class="modal-header">

                    <h5 class="modal-title">

                        Test API

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    Run API connection test for

                    <strong>

                        {{ $service->name }}

                    </strong>

                    ?

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-success">
                        Update Service
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

