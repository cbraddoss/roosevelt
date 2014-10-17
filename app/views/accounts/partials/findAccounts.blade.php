@foreach($accounts as $account)
<div id="account-{{ $account->id }}" class="account-entry office-post">
	<h3>{{ link_to('/accounts/'.$account->link, $account->name) }}</h3>
	<div class="post activity">
		<p class="ss-users"><a></a></p>
	</div>

</div>
@endforeach