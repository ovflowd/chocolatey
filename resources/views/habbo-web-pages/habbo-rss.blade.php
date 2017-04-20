<rss xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
    <channel>
        <title><![CDATA[{{$chocolatey->hotelName}} News]]></title>
        <description><![CDATA[{{$chocolatey->hotelName}} News]]></description>
        <link>{{$chocolatey->hotelUrl}}/</link>
        <generator>{{$chocolatey->hotelName}}</generator>
        <lastBuildDate>{{date('D, d M Y h:i:s e', time())}}</lastBuildDate>
        <atom:link href="{{$chocolatey->hotelUrl}}/rss.xml" rel="self" type="application/rss+xml"/>
        @foreach($articles as $article)
            <item>
                <title><![CDATA[{{$article->title}}]]></title>
                <description><![CDATA[{{$article->description}}]]></description>
                <link>{{$chocolatey->hotelUrl}}/community/article/{{$article->id}}/content</link>
                <guid isPermaLink="false">{{$article->id}}</guid>
                <pubDate>{{date('D, d M Y h:i:s e', strtotime($article->createdAt))}}</pubDate>
            </item>
        @endforeach
    </channel>
</rss>
