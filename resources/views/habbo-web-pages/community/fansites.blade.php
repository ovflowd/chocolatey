<h1>{!! trans('community/fansites.title') !!}</h1>
<p>
    <img src="{{$chocolatey->hotelUrl}}/habbo-web/assets/web-images/habbo_friends.png" alt="Fansites" class="align-right">
</p>
<p>{!! trans('community/fansites.heading',['hotelName' => $chocolatey->hotelName]) !!}</p>
<ul>
    <li>
        <a href="http://ragezone.com/" target="_blank">RaGEZONE</a>
    </li>
</ul>
<p>{!! trans('community/fansites.policy',['hotelName' => $chocolatey->hotelName]) !!}</p>
<p>{!! trans('community/fansites.remember', ['hotelName' => $chocolatey->hotelName]) !!}</p>