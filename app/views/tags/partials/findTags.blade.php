@if($tags->isEmpty())
<p>{{ $tagsNotFound }}</p>
@else
@foreach($tags as $tag)
<span class="tag-name">
	<a class="ss-tag tag-link" href="/tags/name/{{ $tag->slug }}">{{ $tag->name }} <span class="tags-times-used">[{{ $tag->getTagCount($tag->id) }}]</span></a>
</span>
@endforeach
@endif