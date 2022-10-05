@extends('backend.layouts.app')

@section('title', 'Dashboard Nasabah')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            @if (session('info'))
                <div class="alert alert-danger">
                    <strong><i class="fas fa-exclamation-triangle"></i></strong>
                    {!! session('info') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ $title }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $produk }}</h3>
                            <p>Produk</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-cart-plus" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $pesanan }}</h3>
                            <p>Pemesanan</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-chart-bar" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ count($terlaris) }}</h3>
                            <p>Produk Terlaris</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-chart-line" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>


            </div>


            {{-- Chart --}}
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="card card-dark">
                        <!-- /.card-header -->
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold"><i class="fas fa-chart-bar"></i> <span
                                    id="chart_title"></span> Grafik Penjualan Tahun {{ date('Y') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="barChart"
                                    style="min-height: 350px; height: 350px; max-height: 350px;max-width: 100%;"></canvas>
                            </div>
                        </div>
                        <!-- ./card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->

                <div class="col-12 col-md-4">
                    <div class="card card-dark">
                        <!-- /.card-header -->
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold"><i class="fas fa-chart-pie"></i> <span
                                    id="chart_title"></span> Presentase Barang Terlaris
                                {{ date('Y') }}</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="Chart2"
                                style="min-height: 350px; height: 350px; max-height: 350px;max-width: 100%;"></canvas>
                        </div>
                        <!-- ./card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        <!--/. container-fluid -->
    </section>
@endsection

@section('script')
    <!-- ChartJS -->
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var url = "{{ url('admin/chart') }}";
            var Total = [];
            var Bulan = [];
            var Title = [];
            $.get(url, function(response) {
                $.each(response, function(index, data) {
                    Total.push(data.total);
                    Bulan.push(data.bulan);
                    Title.push(data.title);
                });

                var areaChartData = {
                    labels: Bulan[0],
                    datasets: [{
                        label: Title[0],
                        backgroundColor: '#ffbf62',
                        borderColor: '#ffbf62',
                        pointRadius: false,
                        pointColor: '#ffbf62',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: '(220,220,220,1)',
                        data: Total[0]
                    }]
                }
                //-------------
                //- BAR CHART -
                //-------------
                var barChartCanvas = $('#barChart').get(0).getContext('2d');
                var barChartData = $.extend(true, {}, areaChartData);
                var temp0 = areaChartData.datasets[0]
                barChartData.datasets[0] = temp0

                var barChartOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    datasetFill: false,
                    // tooltips: {
                    //     callbacks: {
                    //         label: function(tooltipItem, data) {
                    //             return tooltipItem.yLabel.toFixed(2).replace(/\d(?=(\d{3})+\.)/g,
                    //                 '$&,');
                    //         }
                    //     }
                    // }

                }
                Chart.scaleService.updateScaleDefaults('linear', {
                    ticks: {
                        callback: function(tick) {
                            return 'Rp ' + tick.toLocaleString();
                        }
                    }
                });
                Chart.defaults.global.tooltips.callbacks.label = function(tooltipItem, data) {
                    var dataset = data.datasets[tooltipItem.datasetIndex];
                    var datasetLabel = dataset.label || '';
                    return datasetLabel + ": Rp " + dataset.data[tooltipItem.index].toLocaleString();
                };

                new Chart(barChartCanvas, {
                    type: 'bar',
                    data: barChartData,
                    options: barChartOptions
                });

            });
        });
    </script>
    <script>
        $.getJSON("{{ route('chart2') }}", function(data) {
            //array untuk chart label dan chart data
            var isi_labels = [];
            var isi_data = [];
            var TotalJml = 0;
            //menghitung total jumlah item
            data.forEach(function(obj) {
                TotalJml += Number(obj["total_qty"]);
            });


            //push ke dalam array isi label dan isi data
            var JmlItem = 0;
            $(data).each(function(i) {
                isi_labels.push(data[i].produk.nama_produk);
                //jml item dalam persentase
                isi_data.push(((data[i].total_qty / TotalJml) * 100).toFixed(2));

            });




            //deklarasi chartjs untuk membuat grafik 2d di id mychart   
            var ctx = document.getElementById('Chart2').getContext('2d');

            var myPieChart = new Chart(ctx, {
                //chart akan ditampilkan sebagai pie chart
                type: 'pie',
                data: {
                    //membuat label chart
                    labels: isi_labels,
                    datasets: [{
                        label: 'Data Produk',
                        //isi chart
                        data: isi_data,
                        //membuat warna pada chart
                        backgroundColor: [
                            '#1abc9c',
                            '#2980b9',
                            '#8e44ad',
                            '#2c3e50',
                            '#e74c3c',
                            '#e67e22',
                        ],
                        //borderWidth: 0, //this will hide border
                    }]
                },
                options: {
                    //konfigurasi tooltip
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var dataset = data.datasets[tooltipItem.datasetIndex];
                                var labels = data.labels[tooltipItem.index];
                                var currentValue = dataset.data[tooltipItem.index];
                                return labels + ": " + currentValue + " %";
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
