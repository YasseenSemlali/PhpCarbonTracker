<!-- Scripts -->
<script src="{{ asset('js/index.js') }}" defer></script>
    
<!-- Styles -->
<link href="{{ asset('css/index.css') }}" rel="stylesheet">
@extends('layouts.app')
    
@section('content')
	<div class="container">
		<div class="col-sm-offset-2 col-sm-8">
    <!-- Display the weather here -->
      	<div class="panel-heading">
			
		</div>

			<!-- Display this panel only if the user is authenticated -->
			@if (Auth::check())
				<div class="panel panel-default">
				     <label  class="">Welcome <strong>{{$username}}</strong></label></br>
				     <label  class="">Date Started <strong>{{$dateStarted}}</strong></label></br>
				     <label  class="">Total Distance In Commute <strong>{{$totalDistance}} Km</strong></label></br>
				     <label  class="">Amount of CO2 emissions <strong>{{$emissionAmount}}</strong></label></br>
				     <label  class="">Cost To Offset your Emission <strong>{{$cost}}</strong></label></br>
				     
					<div class="panel-heading">
					 	<h4>Plan A Trip</h4>
					</div>
					
					
					<div class="panel-body">
						<!-- Display Validation Errors -->
						@include('common.errors')

					</div>
				</div>
				
			   <div class="form-group row">
			      <form action = "/home" method= "POST" class = "form-horizontal">
			          {{csrf_field() }}
			     
                        <label  class="col-md-4 col-form-label text-md-right">Starting Position</label>
                                   <select name ='start' id="origin">      
                                   	<option value = "home"> Home</option>
                                   	<option value = "school"> School</option>
                                   	   	@foreach ($locations as $location)
				     						<option value = "{{$location->name}}"> {{$location->name}}</option>
				     					@endforeach
                          
                                      <option value="other">other</option>
                                    </select>
                        <div id = "fillOrigin">
                       	
                       </div>
                       
                        <label  class="col-md-4 col-form-label text-md-right">Destination</label>
                         <select name = 'destination' id = "destination">

                                   	<option value = "home"> Home</option>
                                   	<option value = "school"> School</option>
                               	@foreach ($locations as $location)
				     				<option value = "{{$location->name}}"> {{$location->name}}</option>
		  						@endforeach
		  						
                            <option value="other">other</option>
                       </select>
                       <div id = "fillDest"></div>
                       <div class="">
                           
                            <label  class="col-md-4 col-form-label text-md-right">Transportation Mode</label>
                            
                            <select name = 'transportationMode'>
                            
                            	@if($hasCarInfo)
                               		 <option value="car">Drive</option>
                                	<option value="carpool">CarPool with 2 other people</option>
                            	@endif
                            	
                                <option value="publicTransport">Take Public Transport</option>
                                <option value="bicycle">Bike</option>
                                 <option value="pedestrian">Walk</option>
                           </select>
                           
                       </div>
                         <div>
                             <Button type="submit" name="">Go</Button>
                         </div> 
                     </form>
               </div> 
			@endif
			
			<!-- All Trips with pagination-->
			@if (count($trips) > 0)
				<div class="panel panel-default" >
					<div class="panel-heading"  style="background: rgba(122, 130, 136, 0.3)!important;">
						<h3 class="panel-title">All trips</h3>
					</div>

					<div class="panel-body" style="background: rgba(200,200,200, 0.5)!important;">
						<table class="table table-striped task-table" id = "tripTable">
							<thead>
								<th>Recent Trips</th>
								<th>&nbsp;</th>
							</thead>
							<tbody>
								<tr>
									<th class="table-text"> Transport Mode</th>
									<th class="table-text">Engine</th>
									<th class="table-text"> Distance Travelled in KM</th>
									<th class="table-text"> Trip Date</th>
									<th class="table-text">Travel Time in Minutes </th>
									<th class="table-text">CO2 Emitted in KG</th>
								</tr>
								@foreach ($trips as $trip)
									<tr>
										<td class="table-text">
											{{ $trip->mode }}</td>
						
										<td class="table-text">
											{{ $trip->engine }}</td>
											
								    	<td class="table-text">
											{{ $trip->distance/1000  }}</td>
											
										<td class="table-text">
											{{ $trip->created_at }}</td>
										
										<td class="table-text">
											{{ number_format($trip->travelTime / 60, 2) }}</td>
											
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
	</div>
@endsection
