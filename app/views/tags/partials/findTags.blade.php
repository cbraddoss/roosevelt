@foreach($tags as $tag)
<span class="tag-name">
	<a class="ss-tag tag-link" href="/tags/type/{{ $tag->slug }}">{{ $tag->name }} <span class="tags-times-used">[{{ $tag->times_used }}]</span></a>
</span>
@endforeach