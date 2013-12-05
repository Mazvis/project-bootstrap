<h1>{{ $photoData->photo_name }}</h1>

<!--<div class="profile-view">
    <div class="row">
        <div class="col-sm-3">
            <div class="profile-img">
                <div class="profile-img-wrapper">
                    <a href="{{ URL::to($photoData->photo_destination_url) }}" class="photo-link" style="float:left">
                        <img src="{{ URL::to($photoData->photo_destination_url) }}" alt="First">
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="profile-info-row row">
                <div class="info-label col-md-5">
                    Name
                </div>
                <div class="info-value col-md-7">
                    kkkk
                </div>
            </div>
            <div class="profile-info-row row">
                <div class="info-label col-md-5">
                    username
                </div>
                <div class="info-value col-md-7">
                    kkkk
                </div>
            </div>
            <div class="profile-info-row row">
                <div class="info-label col-md-5">
                    E-mail
                </div>
                <div class="info-value col-md-7">
                    kkk
                </div>
            </div>
        </div>
    </div>
</div>-->

<div class="image-navigation" style="padding-left: 0; padding-top: 0;">

    <a href="{{ URL::to($photoData->photo_destination_url) }}" class="photo-link" style="float:left">
        <img src="{{ URL::to($photoData->photo_destination_url) }}" alt="First">
    </a>
    <div style="float:left; width:30%">
        <p>Photo Name: {{ $photoData->photo_name }}</p>
        <p>Album: {{ HTML::link('albums/'.$photoData->album_id ,$photoData->album_name) }}</p>
        <p>Place taken: {{ $photoData->photo_taken_at }}</p>
        <p>Created at: {{ $photoData->photo_created_at }}</p>
        <p>Photo description {{ $photoData->photo_short_description }}</p>
        <p>Author: {{ HTML::link('user/'.$photoData->username, $photoData->username) }}</p>
        <p>Tags: @for ($i = 0; $i < sizeOf($tags); $i++) {{ HTML::link('tag/'.$tags[$i], $tags[$i]) }}@if($i < sizeOf($tags)-1), @endif @endfor</p>

        <p>Views: {{ $photoData->views }}</p>

        <!--<li data-photoid="{{ $photoData->photo_id }}"><input id="delete-single-photo" type="submit" value="DELETE THIS PHOTO FROM ALBUM"\></li>
-->
        <div data-photoid="{{ $photoData->photo_id }}">
            {{--Form::submit('Delete', array('id' => 'delete-single-photo', 'class' => 'btn btn-danger'))--}}
            <button id="delete-single-photo" class="btn btn-danger">
                <i class="glyphicon glyphicon-trash"></i>
                <span class="text">Delete photo</span>
            </button>
        </div>

    </div>

    <div class="clear"></div>
    <div style="clear:both"></div>
    <hr>
</div>

<div class="panel-group" id="accordion2">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                {{ Form::hidden('photoId', $photoId) }}
                @if(Auth::check())
                @if($isLikeAlreadyExists == 1)
                {{--Form::submit('Unlike', array('class' => 'btn btn-warning photo-like-button'))--}}
                <button class="btn btn-warning photo-like-button">
                    <i class="glyphicon glyphicon-thumbs-down"></i>
                    <span class="text">Unlike</span>
                </button>
                @else
                <button class="btn btn-success photo-like-button">
                    <i class="glyphicon glyphicon-thumbs-up"></i>
                    <span class="text">Like</span>
                </button>
                {{--Form::submit('Like', array('class' => 'btn btn-success photo-like-button'))--}}
                @endif
                @else
                <div>
                    {{ Form::submit('Like', array(
                    'class' => 'btn btn-success',
                    'disabled' => 'true',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'right',
                    'data-original-title' => 'Only register users can like'
                    )) }}
                </div>
                @endif

                <a data-toggle="collapse" data-parent="#accordion2" href="#likers">
                    <p>
                        Likes: {{ sizeOf($likes) }}
                    </p>
                </a>
            </h4>
        </div>
        <div id="likers" class="panel-collapse collapse">
            <div class="panel-body">
                {{--Form::hidden('photoId', $photoId)--}}
                @for ($i = 0; $i < sizeOf($likes); $i++)
                {{ HTML::link('user/'.$likes[$i]->username, $likes[$i]->username) }}@if($i < sizeOf($likes)-1),
                @endif
                @endfor
            </div>
        </div>
    </div>
</div>

<div class="tabs">
    <ul id="myTab" class="nav nav-tabs">
        <li class="active"><a href="#comment-in-album-tab" data-toggle="tab">Comment</a></li>
        <li class=""><a href="#edit-album-tab" data-toggle="tab">Edit</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">

        <div class="tab-pane fade active in" id="comment-in-album-tab">

            <div class="panel-group" id="accordion">
                @for ($i = 0; $i < sizeOf($comments); $i++)

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <a data-toggle="collapse" data-parent="#accordion" href="#comment{{ $comments[$i]->comment_id }}">
                                <p>
                                    @if($comments[$i]->username)
                                    {{ $comments[$i]->username }}
                                    @else
                                    {{ $comments[$i]->commenter_ip }}
                                    @endif
                                    {{ $comments[$i]->created_at }}
                                </p>
                            </a>
                        </h4>
                    </div>
                    <div id="comment{{ $comments[$i]->comment_id }}" class="panel-collapse collapse">
                        {{ Form::hidden('albumId', $albumId)}}
                        <div class="panel-body">
                            {{ $comments[$i]->comment }}
                        </div>
                    </div>
                </div>

                @endfor
            </div>
            <div class="panel panel-default">

                <div id="likers" class="panel-heading panel-collapse collapse in">
                    <div class="panel-body">
                        {{ Form::textarea('comment', '', array('class' => 'form-control', 'rows' => '3', 'placeholder' => 'write here')) }}
                        {{ Form::submit('Comment', array('class' => 'btn btn-primary btn-lg btn-block photo-comment-button')) }}
                    </div>
                </div>
            </div>

        </div>

        <div class="tab-pane fade" id="edit-album-tab">
            {{ Form::open(array('files'=> true, 'method' => 'post', 'id' => 'edit-photo-data-form', 'class' => 'form-hidden')) }}

            {{ Form::hidden('albumId', $albumId)}}
            {{ Form::hidden('photoId', $photoId)}}

            <p>{{ Form::label('photoName', 'Photo name') }}</p>
            <p>{{ Form::text('photoName', $photoData->photo_name) }}</p>

            <p>{{ Form::label('shDescription', 'Photo short description') }}</p>
            <p>{{ Form::text('shDescription', $photoData->photo_short_description) }}</p>

            <p>{{ Form::label('placeTaken', 'Fotographed at') }}</p>
            <p>{{ Form::text('placeTaken', $photoData->photo_taken_at) }}</p>

            <p>{{ Form::label('tags', 'edit tags') }}</p>
            <p>{{ Form::select('tags[]', $allExistingTags, null, array('multiple'=>true, 'id' => 'tags')) }}</p>

            <p>{{ Form::label('albumTitlePhoto', 'Make this title album photo?') }}</p>
            <p>{{ Form::checkbox('albumTitlePhoto', true, array('class' => 'check', 'checked' => '')) }}</p>

            <p>{{ Form::submit('Edit') }}</p>

            {{ Form::token() }}
            {{ Form::close() }}
        </div>
    </div>
</div>

<hr>