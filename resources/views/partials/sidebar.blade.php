<div class="product" style="padding:20px;">
    @if(auth()->user()->role == 'admin')
        <h3>Dashboard Admin</h3>
        <p>Halo, Admin</p>
    @elseif(auth()->user()->role == 'pemilik_alat')
        <h3>Dashboard Pemilik</h3>
        <p>Halo, {{ auth()->user()->name }}</p>
    @else
        <h3>Dashboard Penyewa</h3>
        <p>Halo, {{ auth()->user()->name }}</p>
    @endif

    <hr>

    <ul style="list-style:none; padding:0; line-height:38px;">

        @if(auth()->user()->role == 'penyewa')
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
            <li><a href="{{ route('my.profile') }}"><i class="fa fa-user"></i> Profil Saya</a></li>
            <li><a href="{{ route('booking.my') }}"><i class="fa fa-list"></i> Pesanan Saya</a></li>
            <li><a href="{{ route('booking.history') }}"><i class="fa fa-history"></i> Riwayat Penyewaan</a></li>

        @elseif(auth()->user()->role == 'pemilik_alat')
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
            <li><a href="{{ route('my.profile') }}"><i class="fa fa-user"></i> Profil Saya</a></li>
            <li><a href="{{ route('equipments.index') }}"><i class="fa fa-camera"></i> Alat Saya</a></li>
            <li><a href="{{ route('equipments.create') }}"><i class="fa fa-plus"></i> Tambah Alat</a></li>
            <li><a href="{{ route('booking.requests') }}"><i class="fa fa-list"></i> Permintaan Booking</a></li>
            <li><a href="{{ route('booking.owner.history') }}"><i class="fa fa-history"></i> Riwayat Transaksi</a></li>
        

        @elseif(auth()->user()->role == 'admin')
            <li><a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.verifications') }}"><i class="fa fa-id-card"></i> Verifikasi Pengguna</a></li>
            <li><a href="{{ route('payment.requests') }}"><i class="fa fa-money"></i> Konfirmasi Pembayaran</a></li>
            <li><a href="{{ route('admin.transactions') }}"><i class="fa fa-list"></i> Monitoring Transaksi</a></li>
            <li><a href="{{ route('admin.reports') }}"><i class="fa fa-file"></i> Laporan Sistem</a></li>
            <a href="{{ route('admin.platform.settings') }}" class="nav-link {{ Request::routeIs('admin.platform.settings') ? 'active' : '' }}">
        <i class="fa fa-cogs"></i> Pengaturan Platform
    </a>
            @endif

        <hr style="margin: 10px 0;">
        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" style="border:none;background:none;padding:0;color:#d9534f;cursor:pointer;">
                    <i class="fa fa-sign-out"></i> Logout
                </button>
            </form>
        </li>
    </ul>
</div>