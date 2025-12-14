@extends('layouts.admin')

@section('title', 'Reports & Analytics')

@section('breadcrumb')
<span class="separator">/</span>
<span class="current">Reports</span>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">Reports & Analytics</h1>
    <p class="page-subtitle">Track your business performance and generate reports</p>
</div>

<!-- Summary Stats -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card primary">
            <div class="stat-card-icon">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-card-value">{{ $totalUsers ?? 0 }}</div>
            <div class="stat-card-label">Total Users</div>
            <a href="{{ route('admin.users.index') }}" class="stat-card-link">
                View details <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card success">
            <div class="stat-card-icon">
                <i class="bi bi-car-front"></i>
            </div>
            <div class="stat-card-value">{{ $totalCars ?? 0 }}</div>
            <div class="stat-card-label">Total Vehicles</div>
            <a href="{{ route('admin.cars.index') }}" class="stat-card-link">
                View details <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card warning">
            <div class="stat-card-icon">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="stat-card-value">{{ $totalReservations ?? 0 }}</div>
            <div class="stat-card-label">Total Reservations</div>
            <a href="{{ route('admin.reservations.index') }}" class="stat-card-link">
                View details <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card danger">
            <div class="stat-card-icon">
                <i class="bi bi-key"></i>
            </div>
            <div class="stat-card-value">{{ $totalRentals ?? 0 }}</div>
            <div class="stat-card-label">Total Rentals</div>
            <a href="{{ route('admin.rentals.index') }}" class="stat-card-link">
                View details <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="modern-card h-100">
            <div class="modern-card-header">
                <h3 class="modern-card-title">
                    <i class="bi bi-graph-up me-2 text-primary"></i>
                    Monthly Revenue
                </h3>
                <span class="modern-badge modern-badge-primary">2024</span>
            </div>
            <div class="modern-card-body">
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="modern-card h-100">
            <div class="modern-card-header">
                <h3 class="modern-card-title">
                    <i class="bi bi-pie-chart me-2 text-success"></i>
                    Reservation Status
                </h3>
            </div>
            <div class="modern-card-body d-flex align-items-center justify-content-center">
                <div class="chart-container" style="position: relative; height: 280px; width: 280px;">
                    <canvas id="reservationStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Export Section -->
<div class="modern-card">
    <div class="modern-card-header">
        <h3 class="modern-card-title">
            <i class="bi bi-download me-2 text-info"></i>
            Export Reports
        </h3>
        <span class="modern-badge modern-badge-primary">CSV Format</span>
    </div>
    <div class="modern-card-body">
        <div class="export-intro mb-4">
            <div class="d-flex align-items-center gap-3">
                <div class="export-intro-icon">
                    <i class="bi bi-file-earmark-spreadsheet"></i>
                </div>
                <div>
                    <h5 class="mb-1">Download Detailed Reports</h5>
                    <p class="text-muted mb-0">Export your data in CSV format for analysis, backup, or import into other systems.</p>
                </div>
            </div>
        </div>
        
        <div class="row g-4">
            <!-- Users Export -->
            <div class="col-lg-3 col-md-6">
                <div class="export-card" id="export-users">
                    <div class="export-icon" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);">
                        <i class="bi bi-people" style="color: #667eea;"></i>
                    </div>
                    <h5>Users Report</h5>
                    <p>All registered users with roles, contact info, and account status</p>
                    <div class="export-stats">
                        <span><i class="bi bi-database"></i> {{ $totalUsers }} records</span>
                    </div>
                    <a href="{{ route('admin.reports') }}?export=users" class="btn-modern btn-modern-primary btn-modern-sm w-100 export-btn" data-type="users">
                        <i class="bi bi-download"></i> <span>Download CSV</span>
                    </a>
                </div>
            </div>
            
            <!-- Vehicles Export -->
            <div class="col-lg-3 col-md-6">
                <div class="export-card" id="export-cars">
                    <div class="export-icon" style="background: rgba(16, 185, 129, 0.12);">
                        <i class="bi bi-car-front" style="color: #10b981;"></i>
                    </div>
                    <h5>Vehicles Report</h5>
                    <p>Complete fleet inventory with specs, rates, and availability</p>
                    <div class="export-stats">
                        <span><i class="bi bi-database"></i> {{ $totalCars }} records</span>
                    </div>
                    <a href="{{ route('admin.reports') }}?export=cars" class="btn-modern btn-modern-success btn-modern-sm w-100 export-btn" data-type="cars">
                        <i class="bi bi-download"></i> <span>Download CSV</span>
                    </a>
                </div>
            </div>
            
            <!-- Reservations Export -->
            <div class="col-lg-3 col-md-6">
                <div class="export-card" id="export-reservations">
                    <div class="export-icon" style="background: rgba(245, 158, 11, 0.12);">
                        <i class="bi bi-calendar-check" style="color: #f59e0b;"></i>
                    </div>
                    <h5>Reservations Report</h5>
                    <p>All bookings with customer info, dates, and payment details</p>
                    <div class="export-stats">
                        <span><i class="bi bi-database"></i> {{ $totalReservations }} records</span>
                    </div>
                    <a href="{{ route('admin.reports') }}?export=reservations" class="btn-modern btn-modern-sm w-100 export-btn" data-type="reservations" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.35);">
                        <i class="bi bi-download"></i> <span>Download CSV</span>
                    </a>
                </div>
            </div>
            
            <!-- Rentals Export -->
            <div class="col-lg-3 col-md-6">
                <div class="export-card" id="export-rentals">
                    <div class="export-icon" style="background: rgba(239, 68, 68, 0.12);">
                        <i class="bi bi-key" style="color: #ef4444;"></i>
                    </div>
                    <h5>Rentals Report</h5>
                    <p>Rental history with return status and overdue information</p>
                    <div class="export-stats">
                        <span><i class="bi bi-database"></i> {{ $totalRentals }} records</span>
                    </div>
                    <a href="{{ route('admin.reports') }}?export=rentals" class="btn-modern btn-modern-danger btn-modern-sm w-100 export-btn" data-type="rentals">
                        <i class="bi bi-download"></i> <span>Download CSV</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Export All Section -->
        <div class="export-all-section mt-4">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 p-4 rounded-3" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border: 1px solid #bae6fd;">
                <div class="d-flex align-items-center gap-3">
                    <div class="export-all-icon">
                        <i class="bi bi-cloud-download"></i>
                    </div>
                    <div>
                        <h5 class="mb-1" style="color: #0369a1;">Export All Data</h5>
                        <p class="text-muted mb-0 small">Download all reports at once as separate CSV files</p>
                    </div>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn-modern btn-modern-sm" id="exportAllBtn" style="background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); color: white; box-shadow: 0 4px 15px rgba(14, 165, 233, 0.35);">
                        <i class="bi bi-download"></i> Export All Reports
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Export Toast Notification -->
<div class="export-toast" id="exportToast">
    <div class="export-toast-content">
        <i class="bi bi-check-circle-fill text-success"></i>
        <span>Export started! Your download will begin shortly.</span>
    </div>
</div>

@push('styles')
<style>
    .export-intro {
        padding: 20px 24px;
        background: #f9fafb;
        border-radius: 14px;
    }

    .export-intro-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
    }

    .export-intro h5 {
        font-size: 16px;
        font-weight: 600;
        color: #111827;
    }

    .export-card {
        padding: 24px;
        background: #f9fafb;
        border-radius: 16px;
        text-align: center;
        height: 100%;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .export-card:hover {
        background: #f3f4f6;
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .export-card.exporting {
        pointer-events: none;
    }

    .export-card.exporting::after {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .export-icon {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin: 0 auto 16px;
    }

    .export-card h5 {
        font-size: 16px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 8px;
    }

    .export-card p {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 12px;
        line-height: 1.5;
        min-height: 40px;
    }

    .export-stats {
        margin-bottom: 16px;
    }

    .export-stats span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        background: white;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        color: #6b7280;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .export-stats span i {
        font-size: 14px;
    }

    .export-btn {
        position: relative;
    }

    .export-btn.loading i {
        animation: spin 1s linear infinite;
    }

    .export-btn.loading span {
        opacity: 0.7;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .export-all-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 22px;
    }

    .export-toast {
        position: fixed;
        bottom: 24px;
        right: 24px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        padding: 16px 24px;
        z-index: 9999;
        transform: translateY(100px);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .export-toast.show {
        transform: translateY(0);
        opacity: 1;
    }

    .export-toast-content {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        font-weight: 500;
        color: #374151;
    }

    .export-toast-content i {
        font-size: 20px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const gradient = revenueCtx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(102, 126, 234, 0.3)');
        gradient.addColorStop(1, 'rgba(102, 126, 234, 0)');

        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Revenue',
                    data: {{ json_encode($monthlyRevenue ?? [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]) }},
                    borderColor: '#667eea',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#667eea',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1e1e2d',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        borderRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return '$' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6b7280',
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        grid: {
                            color: '#f3f4f6'
                        },
                        ticks: {
                            color: '#6b7280',
                            font: {
                                size: 12
                            },
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Reservation Status Chart
        const reservationCtx = document.getElementById('reservationStatusChart').getContext('2d');
        new Chart(reservationCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Confirmed', 'Cancelled', 'Completed'],
                datasets: [{
                    data: {{ json_encode($reservationStatusCounts ?? [0, 0, 0, 0]) }},
                    backgroundColor: [
                        '#f59e0b',
                        '#10b981',
                        '#ef4444',
                        '#667eea'
                    ],
                    borderWidth: 0,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 16,
                            color: '#374151',
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e1e2d',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        borderRadius: 8
                    }
                }
            }
        });

        // Export functionality
        const exportButtons = document.querySelectorAll('.export-btn');
        const exportToast = document.getElementById('exportToast');
        const exportAllBtn = document.getElementById('exportAllBtn');

        function showToast(message, isSuccess = true) {
            const toastContent = exportToast.querySelector('.export-toast-content');
            toastContent.innerHTML = `
                <i class="bi bi-${isSuccess ? 'check-circle-fill text-success' : 'exclamation-circle-fill text-danger'}"></i>
                <span>${message}</span>
            `;
            exportToast.classList.add('show');
            setTimeout(() => {
                exportToast.classList.remove('show');
            }, 3000);
        }

        // Handle individual export buttons
        exportButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                const type = this.getAttribute('data-type');
                const card = document.getElementById('export-' + type);
                const icon = this.querySelector('i');
                const span = this.querySelector('span');
                
                // Add loading state
                this.classList.add('loading');
                icon.className = 'bi bi-arrow-repeat';
                span.textContent = 'Exporting...';
                card.classList.add('exporting');
                
                // Show toast
                showToast(`Exporting ${type} report...`);
                
                // Reset after download starts (small delay)
                setTimeout(() => {
                    this.classList.remove('loading');
                    icon.className = 'bi bi-download';
                    span.textContent = 'Download CSV';
                    card.classList.remove('exporting');
                    showToast(`${type.charAt(0).toUpperCase() + type.slice(1)} report downloaded successfully!`);
                }, 1500);
            });
        });

        // Handle export all button
        exportAllBtn.addEventListener('click', function() {
            const types = ['users', 'cars', 'reservations', 'rentals'];
            const icon = this.querySelector('i');
            const originalText = this.innerHTML;
            
            this.innerHTML = '<i class="bi bi-arrow-repeat" style="animation: spin 1s linear infinite;"></i> Exporting...';
            this.disabled = true;
            
            showToast('Starting bulk export...');
            
            // Download each file with a small delay
            types.forEach((type, index) => {
                setTimeout(() => {
                    // Create a temporary link to trigger download
                    const link = document.createElement('a');
                    link.href = '{{ route("admin.reports") }}?export=' + type;
                    link.download = type + '_export.csv';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    
                    if (index === types.length - 1) {
                        // Reset button after all downloads
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.disabled = false;
                            showToast('All reports exported successfully!');
                        }, 500);
                    }
                }, index * 800);
            });
        });
    });
</script>
@endpush
@endsection
