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
				     <label  class="col-md-4 col-form-label text-md-right">{{$username}}</label>
				      <label  class="col-md-4 col-form-label text-md-right">Date Started {{$dateStarted}}</label>
				       <label  class="col-md-4 col-form-label text-md-right">Total Distance In Commute {{$dateStarted}}</label>
				       <label  class="col-md-4 col-form-label text-md-right">Amount of CO2 emissions {{$dateStarted}}</label>
				         <label  class="col-md-4 col-form-label text-md-right">Cost To Offset your Emission {{$dateStarted}}</label>
				       <label  class="col-md-4 col-form-label text-md-right">Date Started {{$dateStarted}}</label>
				     
					<div class="panel-heading">
					 	<h4>Plan A Trip</h4>
					</div>
					
					
					<div class="panel-body">
						<!-- Display Validation Errors -->
						@include('common.errors')

					</div>
				</div>
				
			   <div class="form-group row">
			  
                    <label  class="col-md-4 col-form-label text-md-right">Starting Position</label>
                          <input type="text" name="other" >
                                <select name = 'start'>
                                       <option value="none"></option>
                                  <option value="Dawson">Dawson</option>
                                  <option value="Home">Home</option>
                                  <option value="house">FriendHouse</option>
                                </select>
                    <label  class="col-md-4 col-form-label text-md-right">Destination</label>
                <input type="text" name="other" >
                     <select name = 'destination'>
                          <option value="none"></option>
                        <option value="Dawson">Dawson</option>
                        <option value="Home">Home</option>
                        <option value="house">FriendHouse</option>
                   </select>
                   <div class="">
                    <label  class="col-md-4 col-form-label text-md-right">Transportation Mode</label>
                     <select name = 'transportationMode'>
                        <option value="drive">Drive</option>
                        <option value="carpool">CarPool with 2 other people</option>
                        <option value="publicTransport">Take Public Transport</option>
                        <option value="bike">Bike</option>
                         <option value="walk">Walk</option>
                   </select>
                   </div>
                     <div>
                         <button type="submit" class="btn btn-primary">
                                   Go 
                                </button>  
                     </div>                                     
               </div> 
			@endif

		</div>
	</div>
@endsection
