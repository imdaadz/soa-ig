@extends('template.main')

@section('content')
    @foreach ($data as $ig)
    	{!! $ig['html'] !!}
    	@php
	   		$i = 0
	   	@endphp
    	<div style="margin-bottom: 20px">
	    	@foreach ($ig['linked'] as $link)
	    		@if(!empty($source_list[$link['type']]))
	    			@if ($i == 0)
	    				<div class="row" style="margin-bottom: 20px">
	    			@endif
	    			@php
				   		$i++
				   	@endphp
	    			<div class="col-sm-4"> <button class="btn btn-{{ $source_list[$link['type']]['button'] }} btn-lg "  onclick="location.href='{{ $link['link'] }}' ">Buy From {{ $source_list[$link['type']]['from'] }} </button></div>
	    			@if ($i == 3)
	    				</div>
	    				@php
					   		$i = 0
					   	@endphp
	    			@endif
	    		@endif
	    	@endforeach
	    </div>
	@endforeach
@endsection
