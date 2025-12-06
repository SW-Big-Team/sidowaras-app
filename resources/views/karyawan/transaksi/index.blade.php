@extends('layouts.karyawan.app')

@section('title', 'Riwayat Transaksi - Sidowaras App')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
  <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Karyawan</a></li>
  <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Riwayat Transaksi</li>
</ol>
@endsection

@section('content')
{{-- Page Header --}}
<div class="row mb-4">
  <div class="col-12">
    <div class="page-header-banner">
      <div class="header-content">
        <div class="header-icon-wrap">
          <i class="material-symbols-rounded">history</i>
        </div>
        <div class="header-text">
          <h4 class="header-title">Riwayat Transaksi</h4>
          <p class="header-subtitle">Pantau semua transaksi yang telah Anda proses</p>
        </div>
      </div>
      <div class="header-actions">
        <button type="button" class="btn-filter" data-bs-toggle="modal" data-bs-target="#filterModal">
          <i class="material-symbols-rounded">filter_list</i>
          Filter
          @if(request('start_date') || request('end_date') || request('metode'))
            <span class="filter-badge">✓</span>
          @endif
        </button>
      </div>
    </div>
  </div>
</div>

{{-- Search Bar --}}
<div class="row mb-4">
  <div class="col-12">
    <div class="search-bar-pro">
      <form method="GET" action="{{ route('karyawan.transaksi.index') }}" class="d-flex align-items-center gap-3 w-100">
        @if(request('per_page'))<input type="hidden" name="per_page" value="{{ request('per_page') }}">@endif
        <div class="search-input-wrap">
          <i class="material-symbols-rounded">search</i>
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor transaksi..." class="search-input">
        </div>
        <button type="submit" class="btn-search">Cari</button>
        @if(request('start_date') || request('end_date') || request('metode') || request('search'))
          <div class="active-filters">
            @if(request('search'))
              <span class="filter-tag">
                <i class="material-symbols-rounded">search</i>
                {{ request('search') }}
              </span>
            @endif
            @if(request('start_date'))
              <span class="filter-tag">
                <i class="material-symbols-rounded">calendar_today</i>
                Dari: {{ \Carbon\Carbon::parse(request('start_date'))->format('d M') }}
              </span>
            @endif
            @if(request('end_date'))
              <span class="filter-tag">
                <i class="material-symbols-rounded">calendar_today</i>
                Sampai: {{ \Carbon\Carbon::parse(request('end_date'))->format('d M') }}
              </span>
            @endif
            @if(request('metode'))
              <span class="filter-tag">
                <i class="material-symbols-rounded">payments</i>
                {{ ucfirst(request('metode')) }}
              </span>
            @endif
            <a href="{{ route('karyawan.transaksi.index') }}" class="clear-filters">
              <i class="material-symbols-rounded">close</i>
              Reset
            </a>
          </div>
        @endif
      </form>
    </div>
  </div>
</div>

{{-- Transactions Table --}}
<div class="row">
  <div class="col-12">
    <div class="card pro-card">
      <div class="card-header pro-card-header">
        <div class="header-left">
          <div class="header-icon">
            <i class="material-symbols-rounded">receipt_long</i>
          </div>
          <div>
            <h6 class="header-title">Daftar Transaksi</h6>
            <p class="header-subtitle">{{ $transaksis->total() }} transaksi ditemukan</p>
          </div>
        </div>
        <div class="header-right">
          <form method="GET" action="{{ route('karyawan.transaksi.index') }}" class="per-page-form">
            @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
            @if(request('start_date'))<input type="hidden" name="start_date" value="{{ request('start_date') }}">@endif
            @if(request('end_date'))<input type="hidden" name="end_date" value="{{ request('end_date') }}">@endif
            @if(request('metode'))<input type="hidden" name="metode" value="{{ request('metode') }}">@endif
            <label class="per-page-label">Tampilkan</label>
            <select name="per_page" class="per-page-select" onchange="this.form.submit()">
              <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
              <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
              <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
              <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
            </select>
            <span class="per-page-label">baris</span>
          </form>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table pro-table mb-0">
            <thead>
              <tr>
                <th>No. Transaksi</th>
                <th>Waktu</th>
                <th>Total</th>
                <th>Metode</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($transaksis as $t)
              <tr>
                <td>
                  <div class="d-flex align-items-center gap-3">
                    <div class="trx-icon-wrap">
                      <i class="material-symbols-rounded">receipt</i>
                    </div>
                    <div class="trx-info">
                      <span class="transaction-id">{{ $t->no_transaksi }}</span>
                      <span class="trx-type">Penjualan</span>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="time-info">
                    <span class="time-date">{{ $t->created_at->format('d M Y') }}</span>
                    <span class="time-hour">{{ $t->created_at->format('H:i') }} WIB</span>
                  </div>
                </td>
                <td>
                  <span class="amount-value">Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</span>
                </td>
                <td>
                  @if($t->metode_pembayaran === 'tunai')
                    <span class="method-badge success">
                      <i class="material-symbols-rounded">payments</i>
                      Tunai
                    </span>
                  @else
                    <span class="method-badge info">
                      <i class="material-symbols-rounded">credit_card</i>
                      Non Tunai
                    </span>
                  @endif
                </td>
                <td class="text-center">
                  <a href="{{ route('karyawan.transaksi.show', $t->id) }}" class="action-btn-link">
                    Detail
                    <i class="material-symbols-rounded">chevron_right</i>
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center py-5">
                  <div class="empty-state">
                    <div class="empty-icon"><i class="material-symbols-rounded">receipt_long</i></div>
                    <h6>Belum Ada Transaksi</h6>
                    <p>Transaksi akan muncul di sini setelah checkout berhasil</p>
                  </div>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      
      @if($transaksis->hasPages())
        <div class="card-footer pro-card-footer">
          <div class="pagination-info">
            Menampilkan {{ $transaksis->firstItem() }} - {{ $transaksis->lastItem() }} dari {{ $transaksis->total() }} transaksi
          </div>
          <div class="pagination-controls">
            {{ $transaksis->links() }}
          </div>
        </div>
      @endif
    </div>
  </div>
</div>

{{-- Filter Modal --}}
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-pro">
      <div class="modal-header-pro">
        <div class="modal-icon">
          <i class="material-symbols-rounded">filter_list</i>
        </div>
        <div>
          <h5 class="modal-title-pro">Filter Transaksi</h5>
          <p class="modal-subtitle-pro">Atur filter untuk mempersempit hasil pencarian</p>
        </div>
        <button type="button" class="btn-modal-close" data-bs-dismiss="modal" aria-label="Close">
          <i class="material-symbols-rounded">close</i>
        </button>
      </div>
      <form method="GET" action="{{ route('karyawan.transaksi.index') }}">
        @if(request('search'))
          <input type="hidden" name="search" value="{{ request('search') }}">
        @endif
        @if(request('per_page'))
          <input type="hidden" name="per_page" value="{{ request('per_page') }}">
        @endif
        <div class="modal-body-pro">
          {{-- Date Range --}}
          <div class="filter-group">
            <label class="filter-label">Rentang Tanggal</label>
            <div class="date-range-inputs">
              <div class="date-input-wrap">
                <label class="date-input-label">Dari</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="date-input">
              </div>
              <div class="date-divider">
                <i class="material-symbols-rounded">arrow_forward</i>
              </div>
              <div class="date-input-wrap">
                <label class="date-input-label">Sampai</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="date-input">
              </div>
            </div>
          </div>

          {{-- Payment Method --}}
          <div class="filter-group">
            <label class="filter-label">Metode Pembayaran</label>
            <div class="method-options">
              <label class="method-option {{ !request('metode') ? 'active' : '' }}">
                <input type="radio" name="metode" value="" {{ !request('metode') ? 'checked' : '' }}>
                <span>Semua</span>
              </label>
              <label class="method-option {{ request('metode') == 'tunai' ? 'active' : '' }}">
                <input type="radio" name="metode" value="tunai" {{ request('metode') == 'tunai' ? 'checked' : '' }}>
                <span>💵 Tunai</span>
              </label>
              <label class="method-option {{ request('metode') == 'non tunai' ? 'active' : '' }}">
                <input type="radio" name="metode" value="non tunai" {{ request('metode') == 'non tunai' ? 'checked' : '' }}>
                <span>💳 Non Tunai</span>
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer-pro">
          <a href="{{ route('karyawan.transaksi.index') }}" class="btn-modal-secondary">
            <i class="material-symbols-rounded">refresh</i>
            Reset
          </a>
          <button type="submit" class="btn-modal-primary">
            <i class="material-symbols-rounded">check</i>
            Terapkan Filter
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('styles')
@push('styles')
<style>
/* ===== Variables ===== */
:root {
  --success: #10b981;
  --warning: #f59e0b;
  --danger: #ef4444;
  --info: #3b82f6;
  --primary: #8b5cf6;
  --secondary: #64748b;
}

/* ===== Page Header Banner ===== */
.page-header-banner {
  background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
  border-radius: 16px;
  padding: 1.5rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: white;
}

.header-content { display: flex; align-items: center; gap: 16px; }

.header-icon-wrap {
  width: 56px;
  height: 56px;
  background: rgba(255,255,255,0.2);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  backdrop-filter: blur(10px);
}
.header-icon-wrap i { font-size: 28px; color: white; }

.header-text .header-title { font-size: 1.5rem; font-weight: 700; margin: 0 0 4px; color: white; }
.header-text .header-subtitle { font-size: 0.9rem; opacity: 0.9; margin: 0; }

.btn-filter {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 10px 18px;
  background: rgba(255,255,255,0.2);
  border: none;
  border-radius: 10px;
  color: white;
  font-size: 0.9rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
  backdrop-filter: blur(10px);
}
.btn-filter:hover { background: rgba(255,255,255,0.3); }
.btn-filter i { font-size: 20px; }
.filter-badge { background: white; color: var(--primary); font-size: 0.65rem; padding: 2px 6px; border-radius: 10px; margin-left: 4px; }

/* ===== Search Bar ===== */
.search-bar-pro {
  background: white;
  border-radius: 12px;
  padding: 12px 16px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.04);
}

.search-input-wrap {
  display: flex;
  align-items: center;
  gap: 10px;
  background: #f8fafc;
  border-radius: 8px;
  padding: 10px 14px;
  flex: 1;
  max-width: 400px;
}
.search-input-wrap i { color: var(--secondary); font-size: 20px; }
.search-input { border: none; background: transparent; flex: 1; font-size: 0.9rem; color: #1e293b; outline: none; }

.btn-search {
  padding: 10px 20px;
  background: linear-gradient(135deg, #8b5cf6, #7c3aed);
  border: none;
  border-radius: 8px;
  color: white;
  font-size: 0.85rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
}
.btn-search:hover { box-shadow: 0 4px 12px rgba(139,92,246,0.3); }

.active-filters { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }

.filter-tag {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 6px 10px;
  background: rgba(139,92,246,0.1);
  color: var(--primary);
  border-radius: 6px;
  font-size: 0.75rem;
  font-weight: 500;
}
.filter-tag i { font-size: 14px; }

.clear-filters {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 6px 10px;
  background: rgba(239,68,68,0.1);
  color: var(--danger);
  border-radius: 6px;
  font-size: 0.75rem;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.2s;
}
.clear-filters:hover { background: var(--danger); color: white; }
.clear-filters i { font-size: 14px; }

/* ===== Pro Cards ===== */
.pro-card {
  background: white;
  border-radius: 16px;
  border: none;
  box-shadow: 0 4px 16px rgba(0,0,0,0.06);
  overflow: hidden;
}

.pro-card-header {
  padding: 1.25rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 1px solid #f1f5f9;
  background: white;
}

.header-left { display: flex; align-items: center; gap: 12px; }
.header-icon {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  background: linear-gradient(135deg, #8b5cf6, #7c3aed);
  display: flex;
  align-items: center;
  justify-content: center;
}
.header-icon i { color: white; font-size: 20px; }

.header-title { font-size: 1rem; font-weight: 600; color: #1e293b; margin: 0; }
.header-subtitle { font-size: 0.75rem; color: var(--secondary); margin: 2px 0 0; }

/* ===== Per Page Selector ===== */
.header-right { display: flex; align-items: center; }
.per-page-form { display: flex; align-items: center; gap: 8px; }
.per-page-label { font-size: 0.8rem; color: var(--secondary); }
.per-page-select {
  padding: 6px 10px;
  border: 1px solid #e2e8f0;
  border-radius: 6px;
  font-size: 0.8rem;
  color: #1e293b;
  background: white;
  cursor: pointer;
}
.per-page-select:focus { border-color: var(--primary); outline: none; }

/* ===== Pro Table ===== */
.pro-table { margin: 0; }
.pro-table thead { background: #f8fafc; }
.pro-table th {
  font-size: 0.7rem;
  font-weight: 600;
  color: var(--secondary);
  text-transform: uppercase;
  letter-spacing: 0.5px;
  padding: 12px 16px;
  border: none;
}
.pro-table td {
  padding: 14px 16px;
  border-bottom: 1px solid #f1f5f9;
  vertical-align: middle;
}
.pro-table tbody tr:hover { background: #f8fafc; }

.trx-icon-wrap {
  width: 40px;
  height: 40px;
  background: rgba(139,92,246,0.12);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.trx-icon-wrap i { font-size: 20px; color: var(--primary); }

.trx-info { display: flex; flex-direction: column; }
.transaction-id { font-family: monospace; font-weight: 600; color: #1e293b; font-size: 0.9rem; }
.trx-type { font-size: 0.7rem; color: var(--secondary); }

.time-info { display: flex; flex-direction: column; }
.time-date { font-size: 0.85rem; font-weight: 500; color: #1e293b; }
.time-hour { font-size: 0.7rem; color: var(--secondary); }

.amount-value { font-size: 0.95rem; font-weight: 700; color: #1e293b; }

.method-badge {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 5px 10px;
  border-radius: 6px;
  font-size: 0.75rem;
  font-weight: 500;
}
.method-badge.success { background: rgba(16,185,129,0.12); color: var(--success); }
.method-badge.info { background: rgba(59,130,246,0.12); color: var(--info); }
.method-badge i { font-size: 14px; }

.action-btn-link {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 6px 12px;
  background: #f1f5f9;
  border-radius: 6px;
  font-size: 0.8rem;
  font-weight: 500;
  color: #475569;
  text-decoration: none;
  transition: all 0.2s;
}
.action-btn-link:hover { background: var(--primary); color: white; }
.action-btn-link i { font-size: 16px; }

.empty-state { text-align: center; padding: 2rem; }
.empty-icon {
  width: 70px;
  height: 70px;
  border-radius: 50%;
  background: #f1f5f9;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 16px;
}
.empty-icon i { font-size: 32px; color: var(--secondary); }
.empty-state h6 { color: #1e293b; font-size: 1.1rem; margin-bottom: 6px; }
.empty-state p { font-size: 0.85rem; color: var(--secondary); margin: 0; }

.pro-card-footer {
  padding: 1rem 1.25rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-top: 1px solid #f1f5f9;
  background: #f8fafc;
}
.pagination-info { font-size: 0.8rem; color: var(--secondary); }

/* ===== Modal Pro ===== */
.modal-pro { border-radius: 16px; border: none; overflow: hidden; }

.modal-header-pro {
  display: flex;
  align-items: flex-start;
  gap: 14px;
  padding: 1.5rem;
  background: linear-gradient(135deg, #f8fafc, #f1f5f9);
  border-bottom: 1px solid #e2e8f0;
  position: relative;
}

.modal-icon {
  width: 48px;
  height: 48px;
  background: linear-gradient(135deg, #8b5cf6, #7c3aed);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.modal-icon i { color: white; font-size: 24px; }

.modal-title-pro { font-size: 1.1rem; font-weight: 600; color: #1e293b; margin: 0 0 2px; }
.modal-subtitle-pro { font-size: 0.8rem; color: var(--secondary); margin: 0; }

.btn-modal-close {
  position: absolute;
  right: 1rem;
  top: 1rem;
  background: none;
  border: none;
  color: var(--secondary);
  cursor: pointer;
  padding: 4px;
}
.btn-modal-close:hover { color: #1e293b; }

.modal-body-pro { padding: 1.5rem; }

.filter-group { margin-bottom: 20px; }
.filter-label { display: block; font-size: 0.8rem; font-weight: 600; color: #475569; margin-bottom: 10px; }

.date-range-inputs { display: flex; align-items: center; gap: 12px; }
.date-input-wrap { flex: 1; }
.date-input-label { display: block; font-size: 0.7rem; color: var(--secondary); margin-bottom: 4px; }
.date-input { width: 100%; padding: 10px 12px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.9rem; }
.date-input:focus { border-color: var(--primary); outline: none; }
.date-divider { color: var(--secondary); }
.date-divider i { font-size: 18px; }

.method-options { display: flex; gap: 10px; }

.method-option {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 12px;
  background: #f8fafc;
  border: 2px solid #e2e8f0;
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.2s;
}
.method-option input { display: none; }
.method-option.active { border-color: var(--primary); background: rgba(139,92,246,0.05); }
.method-option:hover { border-color: var(--primary); }
.method-option span { font-size: 0.85rem; font-weight: 500; color: #1e293b; }

.modal-footer-pro {
  padding: 1rem 1.5rem;
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  border-top: 1px solid #e2e8f0;
  background: #f8fafc;
}

.btn-modal-secondary {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 10px 18px;
  background: white;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  font-size: 0.85rem;
  font-weight: 500;
  color: #475569;
  text-decoration: none;
  transition: all 0.2s;
}
.btn-modal-secondary:hover { background: #f1f5f9; color: #1e293b; }
.btn-modal-secondary i { font-size: 18px; }

.btn-modal-primary {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 10px 18px;
  background: linear-gradient(135deg, #8b5cf6, #7c3aed);
  border: none;
  border-radius: 8px;
  font-size: 0.85rem;
  font-weight: 500;
  color: white;
  cursor: pointer;
  transition: all 0.2s;
}
.btn-modal-primary:hover { box-shadow: 0 4px 12px rgba(139,92,246,0.4); }
.btn-modal-primary i { font-size: 18px; }

@media (max-width: 768px) {
  .page-header-banner { flex-direction: column; gap: 16px; text-align: center; }
  .header-content { flex-direction: column; }
  .search-bar-pro { padding: 10px; }
  .search-input-wrap { max-width: 100%; }
  .active-filters { margin-top: 10px; }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Method option selection in modal
  document.querySelectorAll('.method-option').forEach(option => {
    option.addEventListener('click', function() {
      document.querySelectorAll('.method-option').forEach(o => o.classList.remove('active'));
      this.classList.add('active');
      this.querySelector('input').checked = true;
    });
  });
});
</script>
@endpush
@endsection
