<!DOCTYPE html>
<html>
<head>
    <title>Tambah User</title>
</head>
<body>
    <h1>Tambah User Baru</h1>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <label>Nama Lengkap:</label><br>
        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email') }}"><br><br>

        <label>Password:</label><br>
        <input type="password" name="password"><br><br>

        <label>Konfirmasi Password:</label><br>
        <input type="password" name="password_confirmation"><br><br>

        <label>Role:</label><br>
        <select name="role_id">
            @foreach ($roles as $role)
                <option value="{{ $role->id }}">{{ $role->nama_role }}</option>
            @endforeach
        </select><br><br>

        <label>Aktif:</label>
        <input type="checkbox" name="is_active" value="1" checked><br><br>

        <button type="submit">Simpan</button>
    </form>

    <a href="{{ route('admin.users.index') }}">← Kembali</a>
</body>
</html>
