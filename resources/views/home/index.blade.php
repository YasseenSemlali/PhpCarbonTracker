@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="col-sm-offset-2 col-sm-8">
    <!-- Display the weather here -->
      	<div class="panel-heading">
						The current temperature is TBD
					</div>

			<!-- Display this panel only if the user is authenticated -->
			@if (Auth::check())
				<div class="panel panel-default">
					<div class="panel-heading">
						New Story
					</div>

					<div class="panel-body">
						<!-- Display Validation Errors -->
						@include('common.errors')

					</div>
				</div>
			@endif

		</div>
	</div>
@endsection
