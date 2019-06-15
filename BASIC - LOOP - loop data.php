<?php

/**
 * Basic Loop Data
 * > from controller
 */
public function services() {
	$data = array(
		'title'	=>	'Services Page',
		'services'	=> ['php', 'javascript', 'ruby', 'vue.js']
	);
	return view('pages.services')->with('data', $data);
}

@section('content')
    <h1>{{ $data['title'] }}</h1>
    <ul>
    	@if (count($data['services'] > 0))
			@foreach ($data['services'] as $service)
				<li>{{ $service }}</li>
			@endforeach
		@endif
    </ul>
@endsection