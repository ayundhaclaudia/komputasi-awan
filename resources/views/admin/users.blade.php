@extends('layouts.app')

@section('content')
<h3 class="fw-bold mb-3">👤 Daftar User</h3>

<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Terdaftar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : 'bg-secondary' }}">
                    {{ ucfirst($user->role) }}
                </span>
            </td>
            <td>
                <span class="badge {{ $user->is_premium ? 'bg-warning text-dark' : 'bg-light text-dark' }}">
                    {{ $user->is_premium ? 'Premium' : 'Free' }}
                </span>
            </td>
            <td>{{ $user->created_at->format('d M Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
