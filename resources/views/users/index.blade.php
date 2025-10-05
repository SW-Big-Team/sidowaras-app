<!DOCTYPE html>
<html>
<head>
    <title>Daftar User</title>
</head>
<body>
    <h1>Daftar User</h1>

    <a href="{{ route('users.create') }}">+ Tambah User</a>

    @if (session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p style="color:red;">{{ session('error') }}</p>
    @endif

    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aktif</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->nama_lengkap }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->nama_role ?? '-' }}</td>
                    <td>{{ $user->is_active ? 'Ya' : 'Tidak' }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}">Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
