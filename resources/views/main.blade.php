@extends('template.main')

@section('content')
    @foreach ($data as $ig)
    	{!! $ig['html'] !!}
    	<div style="margin-bottom: 20px">
	    	@foreach ($ig['linked'] as $link)
	    		@if ($link['type'] == 'tokopedia')
	    			<button class="btn btn-success btn-lg btn-block"  onclick="location.href='{{ $link['link'] }}' ">Buy From Tokopedia </button>
	    		@elseif ($link['type'] == 'shopee')
	    			<button class="btn btn-warning btn-lg btn-block"  onclick="location.href='{{ $link['link'] }}' ">Buy From Shopee </button>
	    		@endif
	    	@endforeach
	    </div>
	@endforeach
@endsection
