<?php echo '<?xml version="1.0" encoding="UTF-8"?>'."\n"; ?>
<rss version="2.0"
     xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title>{{ config('app.name') }} — последние публикации</title>
        <link>{{ url('/') }}</link>
        <description>Честные обзоры, инсайды и разборы игровых механик.</description>
        <language>ru</language>
        <atom:link href="{{ url()->current() }}" rel="self" type="application/rss+xml"/>
        <lastBuildDate>{{ now()->toRssString() }}</lastBuildDate>

        @foreach($posts as $post)
            <item>
                <title>{{ $post->title }}</title>
                <link>{{ route('posts.show', $post) }}</link>
                <guid isPermaLink="true">{{ route('posts.show', $post) }}</guid>
                <pubDate>{{ $post->created_at->toRssString() }}</pubDate>
                <author>{{ $post->user?->email ?? 'anonymous' }} ({{ $post->user?->name ?? 'Аноним' }})</author>
                <category>{{ $post->category?->name ?? 'Без категории' }}</category>
                <description><![CDATA[{{ $post->description ?? '' }}]]></description>
            </item>
        @endforeach
    </channel>
</rss>