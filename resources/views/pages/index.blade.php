@extends('app')



@section('content')


<div class="container">
	@foreach($carts as $cart) 
				<h4>				 
					<a href="{{ action('PagesController@product', [$cart->id]) }}">{{ $cart->cart_name }}</a>
				</h4>
	@endforeach

	{!! $carts->render() !!}
</div>


@endsection

