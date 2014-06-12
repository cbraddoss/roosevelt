@foreach($accounts as $account)
	<span value="{{ $account->id }}">{{ $account->name }}</span>
@endforeach