@extends('layouts.lens')

@section('content')
<div class="section">
    <div class="container">
        <div class="row">

            <<div class="col-md-3">
    @include('partials.sidebar')
</div>

            <div class="col-md-9">
                <div class="product" style="padding:30px;">
                    <h2>Verifikasi User</h2>
                    <p>Admin dapat mengecek SIM, selfie, dan portofolio pengguna.</p>
                    <hr>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>SIM</th>
                                    <th>Selfie</th>
                                    <th>Portofolio</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($verifications as $verification)
                                    <tr>
                                        <td>{{ $verification->user->name }}</td>
                                        <td>{{ $verification->user->email }}</td>

                                        <td>
                                            @if($verification->sim_photo)
                                                <a href="{{ asset('storage/' . $verification->sim_photo) }}" target="_blank">
                                                    Lihat SIM
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td>
                                            @if($verification->selfie_photo)
                                                <a href="{{ asset('storage/' . $verification->selfie_photo) }}" target="_blank">
                                                    Lihat Selfie
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td>
                                            @if($verification->portfolio_link)
                                                <a href="{{ $verification->portfolio_link }}" target="_blank">
                                                    Buka Link
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td>
                                            @if($verification->status == 'pending')
                                                <span class="label label-warning">PENDING</span>
                                            @elseif($verification->status == 'approved')
                                                <span class="label label-success">APPROVED</span>
                                            @else
                                                <span class="label label-danger">REJECTED</span>
                                            @endif
                                        </td>

                                        <td>
                                            <form action="{{ route('admin.verifications.approve', $verification->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                            </form>

                                            <form action="{{ route('admin.verifications.reject', $verification->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada data verifikasi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection