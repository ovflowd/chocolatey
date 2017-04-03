<h1>{!! trans('playing_habbo/help.title', ['hotelName' => $chocolatey->hotelName]) !!}</h1>
<p>{!! trans('playing_habbo/help.may', ['hotelName' => $chocolatey->hotelName]) !!}</p>
<h2>{!! trans('playing_habbo/help.room_title') !!}</h2>
<p>{!! trans('playing_habbo/help.room', ['hotelName' => $chocolatey->hotelName]) !!}</p>
<h4>{!! trans('playing_habbo/help.ignoring_title', ['hotelName' => $chocolatey->hotelName]) !!}</h4>
<p>{!! trans('playing_habbo/help.ignoring', ['hotelName' => $chocolatey->hotelName]) !!}</p>
<p>
    <img src="{{$chocolatey->hotelUrl}}habbo-web/assets/web-images/report_4.png" alt="Click an avatar to ignore, moderate or report" class="align-right">
</p>
<ol>
    <li>{!! trans('playing_habbo/help.ignoring_list_one') !!}</li>
    <li>{!! trans('playing_habbo/help.ignoring_list_two') !!}</li>
    <li>{!! trans('playing_habbo/help.ignoring_list_three', ['hotelName' => $chocolatey->hotelName]) !!}</li>
</ol>
<h4>{!! trans('playing_habbo/help.moderating_title', ['hotelName' => $chocolatey->hotelName]) !!}</h4>
<p>{!! trans('playing_habbo/help.moderating', ['hotelName' => $chocolatey->hotelName]) !!}</p>
<p>{!! trans('playing_habbo/help.moderating_two', ['hotelName' => $chocolatey->hotelName]) !!}</p>
<h4>{!! trans('playing_habbo/help.reporting_title', ['hotelName' => $chocolatey->hotelName]) !!}</h4>
<p>{!! trans('playing_habbo/help.reporting', ['hotelName' => $chocolatey->hotelName]) !!}</p>
<ol>
    <li>{!! trans('playing_habbo/help.reporting_list_one', ['hotelName' => $chocolatey->hotelName]) !!}</li>
    <li>{!! trans('playing_habbo/help.reporting_list_two') !!}</li>
    <li>{!! trans('playing_habbo/help.reporting_list_three') !!}</li>
    <li>{!! trans('playing_habbo/help.reporting_list_four') !!}</li>
    <li>{!! trans('playing_habbo/help.reporting_list_five') !!}</li>
    <li>{!! trans('playing_habbo/help.reporting_list_six') !!}</li>
</ol>
<p>
    <img src="{{$chocolatey->hotelUrl}}habbo-web/assets/web-images/help_button.png" alt="Help button" class="align-right">
</p>
<p>{!! trans('playing_habbo/help.reporting_two') !!}</p>
<ol>
    <li>{!! trans('playing_habbo/help.reporting_two_list_one') !!}</li>
    <li>{!! trans('playing_habbo/help.reporting_two_list_two') !!}</li>
    <li>{!! trans('playing_habbo/help.reporting_two_list_three') !!}</li>
    <li>{!! trans('playing_habbo/help.reporting_two_list_four') !!}</li>
    <li>{!! trans('playing_habbo/help.reporting_two_list_five') !!}</li>
    <li>{!! trans('playing_habbo/help.reporting_two_list_six') !!}</li>
    <li>{!! trans('playing_habbo/help.reporting_two_list_seven') !!}</li>
</ol>
<hr>
<h2>{!! trans('playing_habbo/help.reporting_three') !!}</h2>
<p>{!! trans('playing_habbo/help.reporting_four') !!}</p>
<ol>
    <li>{!! trans('playing_habbo/help.reporting_four_list_one', ['hotelName' => $chocolatey->hotelName]) !!}</li>
    <li>{!! trans('playing_habbo/help.reporting_four_list_two') !!}</li>
    <li>{!! trans('playing_habbo/help.reporting_four_list_three') !!}</li>
</ol>
<p>
    <img src="{{$chocolatey->hotelUrl}}habbo-web/assets/web-images/report_im.png" alt="Reporting a  {{$chocolatey->hotelName}} in personal messaging">
</p>
<h2>{!! trans('playing_habbo/help.reporting_five') !!}</h2>
<p>
    <img src="{{$chocolatey->hotelUrl}}habbo-web/assets/web-images/flag_3.png" alt="Orange flag for reporting forum threads and posts" class="align-right">
</p>
<p>{!! trans('playing_habbo/help.reporting_six') !!}</p>
<ol>
    <li>{!! trans('playing_habbo/help.reporting_six_list_one') !!}</li>
    <li>{!! trans('playing_habbo/help.reporting_six_list_two') !!}</li>
    <li>{!! trans('playing_habbo/help.reporting_six_list_three') !!}</li>
</ol>
<h2>{!! trans('playing_habbo/help.web_title') !!}</h2>
<p>
    <img src="{{$chocolatey->hotelUrl}}habbo-web/assets/web-images/reportroom.png" alt="White flag for reporting room home pages or camera pics" class="align-right">
</p>
<p>{!! trans('playing_habbo/help.web') !!}</p>
<ol>
    <li>{!! trans('playing_habbo/help.web_list_one') !!}</li>
    <li>{!! trans('playing_habbo/help.web_list_two') !!}</li>
    <li>{!! trans('playing_habbo/help.web_list_three') !!}</li>
    <li>{!! trans('playing_habbo/help.web_list_four') !!}</li>
</ol>
<hr>
<h2>Safety Tips</h2>
<p>On our <a href="/playing-habbo/safety">Safety Tips</a> page you&apos;ll find <strong>suggestions on how to have fun without putting yourself at risk</strong>. Check it out, there&apos;s lots of helpful information!</p>
<h2>{{$chocolatey->hotelName}} Way</h2>
<p>Haven&apos;t read <a href="/playing-habbo/habbo-way">The {{$chocolatey->hotelName}} Way</a> yet? Please do! This stuff is really important. It&apos;s <strong>a set of simple rules</strong> to follow so that the hotel remains a fun place to hang out.</p>
<h2>How to play</h2>
<p>Looking for <strong>ideas on what to do in {{$chocolatey->hotelName}} </strong>? Read our <a href="/playing-habbo/how-to-play">guide on how to play</a>!</p>
<p>If you need <strong>instructions on how to use furni, effects, or any other tool</strong> in the Hotel, click the <em>Help</em> button in the top right corner, then click <em>Ask for instructions</em> and a Helper will be on their way.</p>
<h2> {{$chocolatey->hotelName}} Help Desk</h2>
<p>If you have a <strong>problem with your {{$chocolatey->hotelName}} account, there was an error with the credits you bought or you have questions about a banned account</strong>, find your answer in our Customer Support &amp; Helpdesk</a> pages.</p>