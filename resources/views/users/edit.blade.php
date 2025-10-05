<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nama Lengkap:</label><br>
        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email', $user->email) }}"><br><br>

        <label>Password (kosongkan jika tidak diubah):</label><br>
        <input type="password" name="password"><br><br>

        <label>Konfirmasi Password:</label><br>
        <input type="password" name="password_confirmation"><br><br>

        <label>Role:</label><br>
        <select name="role_id">
            @foreach ($roles as $role)
                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                    {{ $role->nama_role }}
                </option>
            @endforeach
        </select><br><br>

        <label>Aktif:</label>
        <input type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}><br><br>

        <button type="submit">Update</button>
    </form>

    <a href="{{ route('users.index') }}">← Kembali</a>
</body>
</html>
