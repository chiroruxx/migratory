@php
/**
 * @var \App\Entities\Hatena\Post $post
 */
@endphp

{{ '<?xml version="1.0" encoding="utf-8"?>' }}
<entry xmlns="http://www.w3.org/2005/Atom"
       xmlns:app="http://www.w3.org/2007/app">
    <title>{{ $post->getTitle() }}</title>
    @if($post->hasAuthor())
        <author><name>{{ $post->getAuthor() }}</name></author>
    @endif
    <content type="text/plain">
        {{ $post->getContent() }}
    </content>
    @if($post->hasUpdated())
        <updated>{{ $post->getUpdated() }}</updated>
    @endif
    @foreach($post->getCategories() as $category)
        <category term="{{ $category }}" />
    @endforeach
    <app:control>
        <app:draft>{{ $post->isDraft() ? 'yes' : 'no' }}</app:draft>
    </app:control>
</entry>
