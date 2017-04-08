<h1>{!! trans('playing_habbo/how_to_play.title') !!}</h1>
<p>{!! trans('playing_habbo/how_to_play.have') !!}</p>
<p>{!! trans('playing_habbo/how_to_play.ideas') !!}</p>
<p>
    <img src="{{$chocolatey->hotelUrl}}habbo-web/assets/web-images/navigator.png" alt="Navigator" class="align-right">
</p>
<h3>{!! trans('playing_habbo/how_to_play.explore_title') !!}</h3>
<p>{!! trans('playing_habbo/how_to_play.explore', ['hotelName' => $chocolatey->hotelName, 'shortName' => $chocolatey->shortName]) !!}</p>
<hr>
<p>
    <img src="{{$chocolatey->hotelUrl}}habbo-web/assets/web-images/askfriend.png" alt="Ask to be friend" class="align-right">
</p>
<h3>{!! trans('playing_habbo/how_to_play.friends_title') !!}</h3>
<p>{!! trans('playing_habbo/how_to_play.friends', ['hotelName' => $chocolatey->hotelName]) !!}</p>
<hr>
<p>
    <img src="{{$chocolatey->hotelUrl}}habbo-web/assets/web-images/citizenship.png" alt=" {{$chocolatey->hotelName}} citizenship" class="align-right">
</p>
<h3>{!! trans('playing_habbo/how_to_play.citizenship_title', ['hotelName' => $chocolatey->hotelName, 'shortName' => $chocolatey->shortName]) !!}</h3>
<p>{!! trans('playing_habbo/how_to_play.citizenship') !!}</p>
<hr>
<p>
    <img src="{{$chocolatey->hotelUrl}}habbo-web/assets/web-images/gamehub.png" alt="Game Hub" class="align-right">
</p>
<h3>{!! trans('playing_habbo/how_to_play.rooms_title') !!}</h3>
<p>{!! trans('playing_habbo/how_to_play.rooms') !!}</p>
<hr>
<p>
    <img src="{{$chocolatey->hotelUrl}}habbo-web/assets/web-images/shop.png" alt="Shop" class="align-right"/>
</p>
<h3>{!! trans('playing_habbo/how_to_play.shop_title') !!}</h3>
<p>{!! trans('playing_habbo/how_to_play.shop') !!}</p>
<hr>
<h3>{!! trans('playing_habbo/how_to_play.activities_title') !!}</h3>
<p>{!! trans('playing_habbo/how_to_play.activities', ['hotelName' => $chocolatey->hotelName]) !!}</p>
<p>{!! trans('playing_habbo/how_to_play.activities_two', ['hotelName' => $chocolatey->hotelName, 'shortName' => $chocolatey->shortName]) !!}</p>
<blockquote>
    <h3>{!! trans('playing_habbo/how_to_play.join_title', ['hotelName' => $chocolatey->hotelName]) !!}</h3>
    <p>{!! trans('playing_habbo/how_to_play.join', ['hotelName' => $chocolatey->hotelName, 'shortName' => $chocolatey->shortName]) !!}</p>
</blockquote>