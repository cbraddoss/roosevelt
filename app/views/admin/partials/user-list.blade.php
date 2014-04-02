@foreach($users as $u)
<tr class="user-list user-list-{{ $u->id }}">
	<td class="user-name" fieldvalfirst="{{ $u->first_name }}" fieldvallast="{{ $u->last_name }}"><div>{{ $u->first_name }} {{ $u->last_name }} <small class="last-login">{{ user_last_login($u->last_login) }}</small></div></td>
	<td class="user-email" fieldval="{{ $u->email }}">{{ $u->email }}</td>
	<td class="user-password">********</td>
	<td class="user-userrole" fieldval="{{ $u->userrole }}">{{ $u->userrole }}</td>
	<td class="user-extension" fieldval="{{ $u->extension }}">{{ $u->extension }}</td>
	<td class="user-cell-phone" fieldval="{{ $u->cell_phone }}">{{ $u->cell_phone }}</td>
	<td class="user-status" fieldval="{{ $u->status }}">@if( $u->status == "active") <span class="ss-check"></span> @else <span class="ss-delete"></span> @endif</td>
	<td class="user-edit">
		<button id="{{ $u->id }}" class="edit ss-write"></button>
	</td>
</tr>
@endforeach