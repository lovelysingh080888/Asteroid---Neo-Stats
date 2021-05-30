@extends('layouts.master')

@section('content')
 {{-- get neo feeds --}}
<form method="post" action="{{ route('/') }}">
	<div class="row pt-3">
		<div class="col-sm-5">
			<label>Choose Date</label>
			<input type="text" name="date" class="form-control" required="">
		</div>
		<div class="col-sm-5 pt-4">
			<button class="btn btn-sm btn-success">Submit</button>
		</div>
	</div>
	@csrf
</form>

{{-- showing results and bar chart --}}
@isset($velocity)
<div class="row">
	<div class="col-sm-12"><h4>Results</h4></div>
	<div class="col-sm-6">

         @foreach($velocity as $item)
           <h6>{{ $item['date'] }}</h6>
           <p>Fastest speed: {{ $item['velocity'] }}</p>
         @endforeach
		
	</div>
	<div class="col-sm-6">
		<canvas id="myChart"></canvas>
	</div>
</div>
@endisset
{{-- pushing chart dynamic to master page --}}
@push('chart')
<script>
	var ctx = document.getElementById('myChart');
	var myChart = new Chart(ctx, {
	    type: 'bar',
	    data: {
	        labels: [@isset($label)
                       @foreach($label as $item)
                        '{{ $item }}',
                       @endforeach
	                  @endisset],
	        datasets: [{
	            label: '# ',
	            data: [@isset($data)
                       @foreach($data as $item)
                        {{ $item }},
                       @endforeach
	                  @endisset],
	            backgroundColor: [
	                'rgba(255, 99, 132, 0.2)',
	                'rgba(54, 162, 235, 0.2)',
	                'rgba(255, 206, 86, 0.2)',
	                'rgba(75, 192, 192, 0.2)',
	                'rgba(153, 102, 255, 0.2)',
	                'rgba(255, 159, 64, 0.2)'
	            ],
	            borderColor: [
	                'rgba(255, 99, 132, 1)',
	                'rgba(54, 162, 235, 1)',
	                'rgba(255, 206, 86, 1)',
	                'rgba(75, 192, 192, 1)',
	                'rgba(153, 102, 255, 1)',
	                'rgba(255, 159, 64, 1)'
	            ],
	            borderWidth: 1
	        }]
	    },
	    options: {
	        scales: {
	            y: {
	                beginAtZero: true
	            }
	        }
	    }
	});
</script>
@endpush
@endsection