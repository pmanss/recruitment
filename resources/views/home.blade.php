@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Grafik Pemasukan</div>

                <div class="card-body">
                 <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Grafik Pemasukan {{$awal ?? ''}} s/d {{$akhir}}</h3>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="Chart" style="height: 250px;"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
@endsection
@push('scripts')
<script src="{{asset('js/Chart.min.js')}}"></script>
<script type="text/javascript">
    $(function () {
      var salesChartCanvas = $("#Chart").get(0).getContext("2d");
      var salesChart = new Chart(salesChartCanvas);

      var salesChartData = {
        labels: {{ json_encode($data_tanggal) }},
        datasets: [
        {
            label: "Pemasukan",
            fillColor: "rgba(60,141,188,0.9)",
            strokeColor: "rgb(210, 214, 222)",
            pointColor: "rgb(210, 214, 222)",
            pointStrokeColor: "#c1c7d1",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgb(220,220,220)",
            data: {{ json_encode($data_pendapatan) }}
        },
        {
            label: "Pengeluaran",
            fillColor: "rgba(220,220,220,0)",
            strokeColor: "rgb(210, 214, 222)",
            pointColor: "rgb(210, 214, 222)",
            pointStrokeColor: "#c1c7d1",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgb(220,220,220)",
            fillOpacity: .3,
            data: {{ json_encode($data_pengeluaran) }}
        }
        ]
    };

    var salesChartOptions = {
        pointDot: false,
        responsive: true
    };

  //Create the line chart
  salesChart.Line(salesChartData, salesChartOptions);
});
</script>

@endpush
