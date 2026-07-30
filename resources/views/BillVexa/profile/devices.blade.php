<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BillVexa | Active Devices</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>
    body{
        background:#f4f7fe;
        font-family:Arial,sans-serif
    }
    .page-title{
        font-weight:700
    }
    .device-card{
        border:none;
        border-radius:18px;
        box-shadow:0 8px 20px rgba(0,0,0,.08)
    }
    .device-icon{
        width:65px;
        height:65px;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:30px;
        background:linear-gradient(135deg,#5b21b6,#2563eb);
        color:#fff
    }
    .info-title{
        font-weight:600
    }
    .user-agent{
        word-break:break-word;
        color:#6b7280;
        font-size:14px
    }
    .empty-box{
        background:#fff;
        border-radius:20px;
        padding:50px;
        text-align:center;
        box-shadow:0 8px 20px rgba(0,0,0,.08)
    }
    @media(max-width:768px){
        .device-header{
            flex-direction:column!important;
            gap:15px
        }
        .device-icon{
            width:55px;
            height:55px;
            font-size:24px
        }
        .btn,
        .btn-danger,
        .btn-outline-secondary{
            width:100%;
            margin-top:10px
        }
    }
</style>
</head>
<body>

    <div class="container py-4 py-md-5">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                {{ $errors->first() }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <div>
                <h2 class="page-title"><i class="bi bi-laptop me-2"></i>Active Devices</h2>
                <p class="text-muted">These devices are currently signed into your account.</p>
            </div>
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        @forelse($devices as $device)
            <div class="card device-card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-start device-header">
                        <div class="device-icon me-4">
                            <i class="bi bi-pc-display"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="info-title">
                                        IP Address
                                    </div>{{ $device->ip_address }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="info-title">
                                        Last Active
                                    </div>{{ \Carbon\Carbon::createFromTimestamp($device->last_activity)->diffForHumans() }}
                                </div>
                                <div class="col-12">
                                    <div class="info-title mb-2">
                                        Browser / Device
                                    </div>
                                    <div class="user-agent">
                                    {{ $device->user_agent }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-box">
            <i class="bi bi-laptop" style="font-size:70px"></i>
            <h4 class="mt-3">No Active Devices</h4>
            <p class="text-muted">There are currently no active login sessions.</p>
        </div>
        @endforelse

        @if(count($devices))
            <div class="text-center mt-4">
                <button class="btn btn-danger px-4 py-2" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout Other Devices
                </button>
            </div>
        @endif
    </div>

    <div class="modal fade" id="logoutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-shield-lock-fill text-danger me-2"></i>
                        Logout Other Devices
                    </h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('profile.devices.logout') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p class="text-muted">Enter your current password to log out all other devices.</p>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" id="logoutBtn">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            Logout Other Devices
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const modal=document.getElementById('logoutModal');
        modal?.addEventListener('shown.bs.modal',()=>
            document.querySelector('#logoutModal input').focus()
        );
        document.querySelector('#logoutModal form')?.addEventListener('submit',function(){
            const b=document.getElementById('logoutBtn');
            b.disabled=true;
            b.innerHTML='<span class="spinner-border spinner-border-sm me-2"></span>Logging out...';
        });
    </script>
</body>
</html>
