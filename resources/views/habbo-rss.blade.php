<rss xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
    <channel>
        <title><![CDATA[{{$chocolatey['name']}} News]]></title>
        <description><![CDATA[{{$chocolatey['name']}} News]]></description>
        <link>{{$chocolatey['url']}}</link>
        <generator>Hablo</generator>
        <lastBuildDate>{{date('D, d M Y h:i:s e', time())}}</lastBuildDate>
        <atom:link href="{{$chocolatey['url']}}rss.xml" rel="self" type="application/rss+xml"/>
        @foreach($articles as $article)
            <item>
                <title><![CDATA[{{$article->name}}]]></title>
                <description><![CDATA[{{$article->description}}]]></description>
                <link>{{$chocolatey['url']}}community/article/{{$article->id}}/content</link>
                <guid isPermaLink="false">{{$article->id}}</guid>
                <pubDate>{{date('D, d M Y h:i:s e', strtotime($article->createdAt))}}</pubDate>
            </item>
        @endforeach
    </channel>
</rss>