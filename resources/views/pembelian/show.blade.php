@extends('layouts.app')

@section('title', 'Detail Pembelian')

@section('content')
<div class="container mt-4">
    <h3>Detail Pembelian</h3>

    <table class="table table-bordered">
        <tr><th>No Faktur</th><td>{{ $pembelian->no_faktur }}</td></tr>
        <tr><th>Nama Pengirim</th><td>{{ $pembelian->nama_pengirim }}</td></tr>
        <tr><th>No Telepon</th><td>{{ $pembelian->no_telepon_pengirim ?? '-' }}</td></tr>
        <tr><th>Metode Pembayaran</th><td>{{ ucfirst($pembelian->metode_pembayaran) }}</td></tr>
        <tr><th>Total Harga</th><td>Rp {{ number_format($pembelian->total_harga, 0, ',', '.') }}</td></tr>
        <tr><th>Tanggal Pembelian</th><td>{{ $pembelian->tgl_pembelian->format('Y-m-d H:i') }}</td></tr>
        <tr><th>Dibuat oleh</th><td>{{ $pembelian->user->nama_lengkap ?? $pembelian->user->name ?? '-' }}</td></tr>
    </table>

    <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">← Kembali</a>
</div>
@endsection
