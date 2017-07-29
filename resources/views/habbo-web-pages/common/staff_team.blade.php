<h1>{!! trans('common/staff_team.title') !!}</h1>
@foreach(\App\Models\Permissions::where('id', '>=', config('chocolatey.minRank'))->orderBy('id', 'desc')->get() as $rank)
    @if(\App\Models\User::where('rank', $rank->id)->count() > 0)
        <h3>{{$rank->rank_name}}</h3>
        <hr>
        <blockquote>
            @foreach(\App\Models\User::where('rank', $rank->id)->get() as $user)
                <div class="profile-header__avatar" style="display:inline-block">
                    <div class="profile-header__link">
                        <habbo-imager figure="{{$user->look}}" action="stand"
                                      class="profile-header__image"></habbo-imager>
                    </div>
                </div>
                <div class="profile-header__details" style="display:inline-block">
                    <div>
                        <h1>{{$user->username}}</h1>
                        <div class="profile__motto">{{$user->motto}}</div>
                    </div>
                </div>
                <br>
            @endforeach
        </blockquote>
    @endif
@endforeach
