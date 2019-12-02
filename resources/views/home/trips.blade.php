<script src="{{ asset('js/index.js') }}" defer></script>
    
<!-- Styles -->
<link href="{{ asset('css/index.css') }}" rel="stylesheet">
@extends('layouts.app')
    
@section('content')
	<!-- All Trips with pagination-->
			@if (count($trips) > 0)
				<div class="panel panel-default">
					<div class="panel-heading">
						All trips
					</div>

					<div class="panel-body">
						<table class="table table-striped task-table" id = "tripTable">
							<thead>
								<th>Recent Trips</th>
								<th>&nbsp;</th>
							</thead>
							<tbody>
								<tr>
									<th class="table-text"> Transport Mode</th>
									<th class="table-text">Engine</th>
									<th class="table-text"> Distance Travelled</th>
									<th class="table-text"> Trip Date</th>
									<th class="table-text">Travel Time  </th>
									<th class="table-text">CO2 Emitted</th>
								</tr>
								@foreach ($trips as $trip)
									<tr>
										<td class="table-text">
											{{ $trip->mode }}</td>
						
										<td class="table-text">
											{{ $trip->engine }}</td>
											
								    	<td class="table-text">
											{{ $trip->distance }} Km</td>
											
										<td class="table-text">
											{{ $trip->created_at }}</td>
										
										<td class="table-text">
											{{ $trip->travelTime }}</td>
											
										<td class="table-text">
											{{ $trip->co2emissions }}</td>
											
									</tr>
									
									
								@endforeach
							</tbody>
						</table>{!! $trips->render() !!}
					</div>
				</div>

					@endif

            <svg class="line-chart"></svg>
<script src="https://cdn.jsdelivr.net/npm/chart.xkcd@1/dist/chart.xkcd.min.js"></script>
		</div>
@endsection