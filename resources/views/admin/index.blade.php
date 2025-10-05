@extends('layouts.admin.app')

@section('title', 'Dashboard - Sidowaras App')

@section('breadcrumb')
<ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
  <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
  <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="ms-3">
    <h3 class="mb-0 h4 font-weight-bolder">Dashboard POS Apotek</h3>
    <p class="mb-4">Monitoring penjualan, stok obat, dan performa apotek hari ini.</p>
  </div>
  
  {{-- Sales Card: Penjualan Hari Ini --}}
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-header p-2 ps-3">
        <div class="d-flex justify-content-between">
          <div>
            <p class="text-sm mb-0 text-capitalize">Penjualan Hari Ini</p>
            <h4 class="mb-0">Rp 8.450.000</h4>
          </div>
          <div class="icon icon-md icon-shape bg-gradient-success shadow-success shadow text-center border-radius-lg">
            <i class="material-symbols-rounded opacity-10">payments</i>
          </div>
        </div>
      </div>
      <hr class="dark horizontal my-0">
      <div class="card-footer p-2 ps-3">
        <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+12.5% </span>dari kemarin</p>
      </div>
    </div>
  </div>

  {{-- Sales Card: Penjualan Minggu Ini --}}
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-header p-2 ps-3">
        <div class="d-flex justify-content-between">
          <div>
            <p class="text-sm mb-0 text-capitalize">Penjualan Minggu Ini</p>
            <h4 class="mb-0">Rp 52.300.000</h4>
          </div>
          <div class="icon icon-md icon-shape bg-gradient-info shadow-info shadow text-center border-radius-lg">
            <i class="material-symbols-rounded opacity-10">date_range</i>
          </div>
        </div>
      </div>
      <hr class="dark horizontal my-0">
      <div class="card-footer p-2 ps-3">
        <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+6% </span>dari minggu lalu</p>
      </div>
    </div>
  </div>

  {{-- Sales Card: Penjualan Bulan Ini --}}
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-header p-2 ps-3">
        <div class="d-flex justify-content-between">
          <div>
            <p class="text-sm mb-0 text-capitalize">Penjualan Bulan Ini</p>
            <h4 class="mb-0">Rp 287.500.000</h4>
          </div>
          <div class="icon icon-md icon-shape bg-gradient-warning shadow-warning shadow text-center border-radius-lg">
            <i class="material-symbols-rounded opacity-10">calendar_month</i>
          </div>
        </div>
      </div>
      <hr class="dark horizontal my-0">
      <div class="card-footer p-2 ps-3">
        <p class="mb-0 text-sm"><span class="text-success font-weight-bolder">+3% </span>dari bulan lalu</p>
      </div>
    </div>
  </div>

  {{-- Sales Card: Total Penjualan --}}
  <div class="col-xl-3 col-sm-6">
    <div class="card">
      <div class="card-header p-2 ps-3">
        <div class="d-flex justify-content-between">
          <div>
            <p class="text-sm mb-0 text-capitalize">Total Penjualan</p>
            <h4 class="mb-0">Rp 3.245.600.000</h4>
          </div>
          <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
            <i class="material-symbols-rounded opacity-10">summarize</i>
          </div>
        </div>
      </div>
      <hr class="dark horizontal my-0">
      <div class="card-footer p-2 ps-3">
        <p class="mb-0 text-sm"><span class="text-muted font-weight-bolder">Sejak awal tahun</span></p>
      </div>
    </div>
  </div>
</div>

<div class="row mt-4">
  {{-- Grafik Penjualan 7 Hari Terakhir --}}
  <div class="col-lg-5 col-md-6 mb-4">
    <div class="card">
      <div class="card-header p-3 pb-0">
        <div class="d-flex justify-content-between">
          <div>
            <h6 class="mb-0">Penjualan 7 Hari Terakhir</h6>
            <p class="text-sm mb-0">Trend penjualan harian</p>
          </div>
          <div class="text-end">
            <h6 class="mb-0 text-success">Rp 52.3 Jt</h6>
            <p class="text-xs mb-0">Total Minggu Ini</p>
          </div>
        </div>
      </div>
      <div class="card-body p-3">
        <div class="chart">
          <canvas id="chart-sales-daily" class="chart-canvas" height="200"></canvas>
        </div>
      </div>
    </div>
  </div>

  {{-- Grafik Penjualan Bulanan --}}
  <div class="col-lg-7 col-md-6 mb-4">
    <div class="card">
      <div class="card-header p-3 pb-0">
        <div class="d-flex justify-content-between">
          <div>
            <h6 class="mb-0">Penjualan Bulanan</h6>
            <p class="text-sm mb-0">Performa penjualan tahun ini</p>
          </div>
          <div class="text-end">
            <h6 class="mb-0 text-info">Rp 287.5 Jt</h6>
            <p class="text-xs mb-0">Total Tahun Ini</p>
          </div>
        </div>
      </div>
      <div class="card-body p-3">
        <div class="chart">
          <canvas id="chart-sales-monthly" class="chart-canvas" height="200"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mb-4">
  {{-- Tabel Obat Terlaris --}}
  <div class="col-lg-8 col-md-12 mb-md-0 mb-4">
    <div class="card">
      <div class="card-header pb-0">
        <div class="row">
          <div class="col-lg-6 col-7">
            <h6>Obat Terlaris Bulan Ini</h6>
            <p class="text-sm mb-0">
              <i class="fa fa-check text-success" aria-hidden="true"></i>
              <span class="font-weight-bold ms-1">Top 10</span> produk dengan penjualan tertinggi
            </p>
          </div>
          <div class="col-lg-6 col-5 my-auto text-end">
            <a href="#" class="btn btn-sm btn-outline-primary mb-0">Lihat Semua</a>
          </div>
        </div>
      </div>
      <div class="card-body px-0 pb-2">
        <div class="table-responsive">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Obat</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kategori</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Terjual</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stok</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pendapatan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div>
                      <div class="avatar avatar-sm me-3 bg-gradient-primary">
                        <i class="material-symbols-rounded opacity-10 text-white">medication</i>
                      </div>
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">Paracetamol 500mg</h6>
                      <p class="text-xs text-secondary mb-0">Tablet - Generik</p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">Analgesik</p>
                  <p class="text-xs text-secondary mb-0">Antipiretik</p>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge badge-sm bg-gradient-success">850 strip</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">450</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">Rp 8.5 Jt</span>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div>
                      <div class="avatar avatar-sm me-3 bg-gradient-info">
                        <i class="material-symbols-rounded opacity-10 text-white">vaccines</i>
                      </div>
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">Amoxicillin 500mg</h6>
                      <p class="text-xs text-secondary mb-0">Kapsul - Generik</p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">Antibiotik</p>
                  <p class="text-xs text-secondary mb-0">Beta-Laktam</p>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge badge-sm bg-gradient-success">720 strip</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">280</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">Rp 7.2 Jt</span>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div>
                      <div class="avatar avatar-sm me-3 bg-gradient-warning">
                        <i class="material-symbols-rounded opacity-10 text-white">water_drop</i>
                      </div>
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">OBH Combi Batuk</h6>
                      <p class="text-xs text-secondary mb-0">Sirup 100ml</p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">Antitusif</p>
                  <p class="text-xs text-secondary mb-0">Ekspektoran</p>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge badge-sm bg-gradient-success">580 botol</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">320</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">Rp 6.8 Jt</span>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div>
                      <div class="avatar avatar-sm me-3 bg-gradient-danger">
                        <i class="material-symbols-rounded opacity-10 text-white">healing</i>
                      </div>
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">Antasida DOEN</h6>
                      <p class="text-xs text-secondary mb-0">Tablet - Generik</p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">Antasida</p>
                  <p class="text-xs text-secondary mb-0">Maag</p>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge badge-sm bg-gradient-success">510 strip</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-warning text-xs font-weight-bold">85</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">Rp 5.1 Jt</span>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div>
                      <div class="avatar avatar-sm me-3 bg-gradient-success">
                        <i class="material-symbols-rounded opacity-10 text-white">emergency</i>
                      </div>
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">Vitamin C 1000mg</h6>
                      <p class="text-xs text-secondary mb-0">Tablet Effervescent</p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">Vitamin</p>
                  <p class="text-xs text-secondary mb-0">Suplemen</p>
                </td>
                <td class="align-middle text-center text-sm">
                  <span class="badge badge-sm bg-gradient-success">450 tube</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">560</span>
                </td>
                <td class="align-middle text-center">
                  <span class="text-secondary text-xs font-weight-bold">Rp 4.5 Jt</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  
  {{-- Alert & Transaksi Terbaru --}}
  <div class="col-lg-4 col-md-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Peringatan Stok</h6>
        <p class="text-sm">
          <i class="fa fa-exclamation-triangle text-warning" aria-hidden="true"></i>
          <span class="font-weight-bold ms-1">Perlu perhatian</span>
        </p>
      </div>
      <div class="card-body p-3">
        <div class="timeline timeline-one-side">
          <div class="timeline-block mb-3">
            <span class="timeline-step bg-warning">
              <i class="material-symbols-rounded text-white text-sm">inventory_2</i>
            </span>
            <div class="timeline-content">
              <h6 class="text-dark text-sm font-weight-bold mb-0">Stok Hampir Habis</h6>
              <p class="text-secondary text-xs mt-1 mb-0">Ibuprofen 400mg</p>
              <p class="text-xs text-warning mb-0"><strong>Stok: 15 strip</strong> (Min: 50)</p>
            </div>
          </div>
          <div class="timeline-block mb-3">
            <span class="timeline-step bg-warning">
              <i class="material-symbols-rounded text-white text-sm">inventory_2</i>
            </span>
            <div class="timeline-content">
              <h6 class="text-dark text-sm font-weight-bold mb-0">Stok Hampir Habis</h6>
              <p class="text-secondary text-xs mt-1 mb-0">CTM 4mg</p>
              <p class="text-xs text-warning mb-0"><strong>Stok: 8 strip</strong> (Min: 30)</p>
            </div>
          </div>
          <div class="timeline-block mb-3">
            <span class="timeline-step bg-danger">
              <i class="material-symbols-rounded text-white text-sm">warning</i>
            </span>
            <div class="timeline-content">
              <h6 class="text-dark text-sm font-weight-bold mb-0">Akan Kadaluarsa</h6>
              <p class="text-secondary text-xs mt-1 mb-0">Ambroxol Sirup</p>
              <p class="text-xs text-danger mb-0"><strong>Exp: 15 Nov 2025</strong> (22 hari lagi)</p>
            </div>
          </div>
          <div class="timeline-block mb-3">
            <span class="timeline-step bg-danger">
              <i class="material-symbols-rounded text-white text-sm">warning</i>
            </span>
            <div class="timeline-content">
              <h6 class="text-dark text-sm font-weight-bold mb-0">Akan Kadaluarsa</h6>
              <p class="text-secondary text-xs mt-1 mb-0">Cetirizine 10mg</p>
              <p class="text-xs text-danger mb-0"><strong>Exp: 28 Nov 2025</strong> (35 hari lagi)</p>
            </div>
          </div>
          <div class="timeline-block mb-0">
            <span class="timeline-step bg-warning">
              <i class="material-symbols-rounded text-white text-sm">inventory_2</i>
            </span>
            <div class="timeline-content">
              <h6 class="text-dark text-sm font-weight-bold mb-0">Stok Hampir Habis</h6>
              <p class="text-secondary text-xs mt-1 mb-0">Metformin 500mg</p>
              <p class="text-xs text-warning mb-0"><strong>Stok: 25 strip</strong> (Min: 100)</p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer text-center pt-0">
        <a href="#" class="btn btn-sm btn-outline-warning mb-0">Lihat Semua Peringatan</a>
      </div>
    </div>

    {{-- Transaksi Terbaru --}}
    <div class="card">
      <div class="card-header pb-0">
        <h6>Transaksi Terbaru</h6>
        <p class="text-sm">
          <i class="fa fa-clock text-info" aria-hidden="true"></i>
          <span class="font-weight-bold ms-1">Real-time</span> update
        </p>
      </div>
      <div class="card-body p-3">
        <div class="timeline timeline-one-side">
          <div class="timeline-block mb-3">
            <span class="timeline-step bg-success">
              <i class="material-symbols-rounded text-white text-sm">shopping_cart</i>
            </span>
            <div class="timeline-content">
              <h6 class="text-dark text-sm font-weight-bold mb-0">Rp 156.000</h6>
              <p class="text-secondary text-xs mt-1 mb-0">
                Paracetamol, Amoxicillin, Vitamin C<br>
                <strong>TRX#20251005127</strong>
              </p>
              <p class="text-xs text-secondary mb-0">2 menit yang lalu</p>
            </div>
          </div>
          <div class="timeline-block mb-3">
            <span class="timeline-step bg-success">
              <i class="material-symbols-rounded text-white text-sm">shopping_cart</i>
            </span>
            <div class="timeline-content">
              <h6 class="text-dark text-sm font-weight-bold mb-0">Rp 45.000</h6>
              <p class="text-secondary text-xs mt-1 mb-0">
                OBH Combi<br>
                <strong>TRX#20251005126</strong>
              </p>
              <p class="text-xs text-secondary mb-0">8 menit yang lalu</p>
            </div>
          </div>
          <div class="timeline-block mb-3">
            <span class="timeline-step bg-success">
              <i class="material-symbols-rounded text-white text-sm">shopping_cart</i>
            </span>
            <div class="timeline-content">
              <h6 class="text-dark text-sm font-weight-bold mb-0">Rp 328.000</h6>
              <p class="text-secondary text-xs mt-1 mb-0">
                Antibiotik, Antasida, CTM<br>
                <strong>TRX#20251005125</strong>
              </p>
              <p class="text-xs text-secondary mb-0">15 menit yang lalu</p>
            </div>
          </div>
          <div class="timeline-block mb-0">
            <span class="timeline-step bg-success">
              <i class="material-symbols-rounded text-white text-sm">shopping_cart</i>
            </span>
            <div class="timeline-content">
              <h6 class="text-dark text-sm font-weight-bold mb-0">Rp 89.500</h6>
              <p class="text-secondary text-xs mt-1 mb-0">
                Multivitamin, Paracetamol<br>
                <strong>TRX#20251005124</strong>
              </p>
              <p class="text-xs text-secondary mb-0">22 menit yang lalu</p>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer text-center pt-0">
        <a href="#" class="btn btn-sm btn-outline-info mb-0">Lihat Riwayat Lengkap</a>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
<script>
  var ctx = document.getElementById("chart-bars").getContext("2d");

  new Chart(ctx, {
    type: "bar",
    data: {
      labels: ["M", "T", "W", "T", "F", "S", "S"],
      datasets: [{
        label: "Views",
        tension: 0.4,
        borderWidth: 0,
        borderRadius: 4,
        borderSkipped: false,
        backgroundColor: "#43A047",
        data: [50, 45, 22, 28, 50, 60, 76],
        barThickness: 'flex'
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        }
      },
      interaction: {
        intersect: false,
        mode: 'index',
      },
      scales: {
        y: {
          grid: {
            drawBorder: false,
            display: true,
            drawOnChartArea: true,
            drawTicks: false,
            borderDash: [5, 5],
            color: '#e5e5e5'
          },
          ticks: {
            suggestedMin: 0,
            suggestedMax: 500,
            beginAtZero: true,
            padding: 10,
            font: {
              size: 14,
              lineHeight: 2
            },
            color: "#737373"
          },
        },
        x: {
          grid: {
            drawBorder: false,
            display: false,
            drawOnChartArea: false,
            drawTicks: false,
            borderDash: [5, 5]
          },
          ticks: {
            display: true,
            color: '#737373',
            padding: 10,
            font: {
              size: 14,
              lineHeight: 2
            },
          }
        },
      },
    },
  });

  var ctx2 = document.getElementById("chart-line").getContext("2d");

  new Chart(ctx2, {
    type: "line",
    data: {
      labels: ["J", "F", "M", "A", "M", "J", "J", "A", "S", "O", "N", "D"],
      datasets: [{
        label: "Sales",
        tension: 0,
        borderWidth: 2,
        pointRadius: 3,
        pointBackgroundColor: "#43A047",
        pointBorderColor: "transparent",
        borderColor: "#43A047",
        backgroundColor: "transparent",
        fill: true,
        data: [120, 230, 130, 440, 250, 360, 270, 180, 90, 300, 310, 220],
        maxBarThickness: 6
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          callbacks: {
            title: function(context) {
              const fullMonths = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
              return fullMonths[context[0].dataIndex];
            }
          }
        }
      },
      interaction: {
        intersect: false,
        mode: 'index',
      },
      scales: {
        y: {
          grid: {
            drawBorder: false,
            display: true,
            drawOnChartArea: true,
            drawTicks: false,
            borderDash: [4, 4],
            color: '#e5e5e5'
          },
          ticks: {
            display: true,
            color: '#737373',
            padding: 10,
            font: {
              size: 12,
              lineHeight: 2
            },
          }
        },
        x: {
          grid: {
            drawBorder: false,
            display: false,
            drawOnChartArea: false,
            drawTicks: false,
          },
          ticks: {
            display: true,
            color: '#737373',
            padding: 10,
            font: {
              size: 12,
              lineHeight: 2
            },
          }
        },
      },
    },
  });

  var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");

  new Chart(ctx3, {
    type: "line",
    data: {
      labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      datasets: [{
        label: "Tasks",
        tension: 0,
        borderWidth: 2,
        pointRadius: 3,
        pointBackgroundColor: "#43A047",
        pointBorderColor: "transparent",
        borderColor: "#43A047",
        backgroundColor: "transparent",
        fill: true,
        data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
        maxBarThickness: 6
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        }
      },
      interaction: {
        intersect: false,
        mode: 'index',
      },
      scales: {
        y: {
          grid: {
            drawBorder: false,
            display: true,
            drawOnChartArea: true,
            drawTicks: false,
            borderDash: [4, 4],
            color: '#e5e5e5'
          },
          ticks: {
            display: true,
            padding: 10,
            color: '#737373',
            font: {
              size: 14,
              lineHeight: 2
            },
          }
        },
        x: {
          grid: {
            drawBorder: false,
            display: false,
            drawOnChartArea: false,
            drawTicks: false,
            borderDash: [5, 5]
          },
          ticks: {
            display: true,
            color: '#737373',
            padding: 10,
            font: {
              size: 14,
              lineHeight: 2
            },
          }
        },
      },
    },
  });
</script>
@endpush
