<h1>Profile</h1>

<div class="profile-edit">
    <div class="row">
        <div class="col-sm-3">
            <div class="profile-img">
                <div class="profile-img-wrapper">
                    <img src="{{ URL::to('assets/img/user-blank.jpg') }}" alt="username"> {{--URL::asset('uploads/'.$user->id.'.jpg')--}}
                    <!-- <img src="{{URL::to('http://www.gravatar.com/avatar/' . md5( strtolower( trim( $user->email ) ) ) . '?d=' . urlencode( '../public/assets/img/user-blank.jpg' ) . '&s=' . 140)}}" alt="username"> -->
                </div>
                <!-- this will open popup-->
                <button type="button" class="btn btn-default btn-xs" data-toggle = "modal" data-target = "#showPhotoModal">Change image<i class="icon-plus-sign icon-plus"></i></button>

                <!-- Modal -->
                <div class="modal fade" id="showPhotoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h1>Upload your new profile picture!</h1>
                            </div>
                            <div class="modal-body">
                                {{Form::open(array('route' => 'user.upload.pic', 'files'=> true))}}
                                {{Form::file('photo')}}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary"> Upload pic</button>
                                {{ Form::token() }}
                                {{ Form::close() }}
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

            </div>

        </div>
        <div class="col-sm-9">
            {{ Form::model($user, array('route' => array('user.update.name', $user->id), 'class' => 'form-horizontal')) }}
            <fieldset>
                <legend>Personal information</legend>
                <div class="form-group">
                    <label class="control-label col-lg-4" for="edit-first-name">First name<span class="required">*</span></label>
                    <div class="col-lg-8">
                        {{ Form::text('name', null, array('class'=>'form-control', 'id' => 'edit-first-name')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-4" for="edit-last-name">Last name<span class="required">*</span></label>
                    <div class="col-lg-8">
                        {{ Form::text('last_name', null, array('class'=>'form-control', 'id' => 'edit-last-name')) }}
                        @if (Session::has('profile_info'))
                        <p class="help-block">{{Session::get('profile_info') }}</p>
                        @endif
                    </div>
                </div>

                <div class="form-submit">
                    <button type="submit" class="btn btn-sm btn-success">Update information</button>
                </div>
            </fieldset>
            {{ Form::token() }}
            {{ Form::close() }}
            {{Form::model($user, array('route' => array('user.update.email', $user->id), 'class' => 'form-horizontal')) }}
            <fieldset>
                <legend>Change email:</legend>
                <div class="form-group">
                    <label class="control-label col-lg-4" for="edit-email">Your email address<span class="required">*</span></label>
                    <div class="col-lg-8">
                        {{ Form::text('email', null, array('class'=>'form-control', 'id' => 'edit-email')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-4" for="edit-email-current-password">Current password<span class="required">*</span></label>
                    <div class="col-lg-8">
                        {{ Form::password('password', array('placeholder' => 'Password','class'=>'form-control', 'id' => 'edit-email-current-password')) }}
                        @if (Session::has('email_update'))
                        <p class="help-block">{{Session::get('email_update') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-submit">
                    <button type="submit" class="btn btn-sm btn-success">Change</button>
                </div>
            </fieldset>
            {{ Form::token() }}
            {{ Form::close() }}
            {{Form::model($user, array('route' => array('user.update.password', $user->id), 'class' => 'form-horizontal')) }}
            <fieldset>
                <legend>Change password</legend>
                <div class="form-group">
                    <label class="control-label col-lg-4" for="edit-password-current-password">Current password<span class="required">*</span></label>
                    <div class="col-lg-8">
                        <!-- <input type="password" class="form-control" id="edit-password-current-password" value="sgaahf" required> -->
                        {{ Form::password('old_password', array('placeholder' => 'Password','class'=>'form-control', 'id' => 'edit-password-current-password')) }}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-4" for="edit-password-new-password">New password<span class="required">*</span></label>
                    <div class="col-lg-8">
                        <!--<input type="password" class="form-control" id="edit-password-new-password" value="sgasdgasdghahf" required> -->
                        {{ Form::password('password', array('placeholder' => 'Password','class'=>'form-control', 'id' => 'edit-password-new-password'))}}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-4" for="edit-password-repeat-password">Repeat password<span class="required">*</span></label>
                    <div class="col-lg-8">
                        <!-- <input type="password" class="form-control" id="edit-password-repeat-password" value="sgasghahf" required> -->
                        {{ Form::password('password_confirmation', array('placeholder' => 'Password','class'=>'form-control', 'id' => 'edit-password-repeat-password'))}}
                        @if (Session::has('password_changed'))
                        <p class="help-block">{{Session::get('password_changed') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-submit">
                    <button type="submit" class="btn btn-sm btn-success">Change</button>
                </div>
            </fieldset>
            {{ Form::token() }}
            {{ Form::close() }}
        </div>
    </div>
</div>

<hr>
<h3>Your albums:</h3>
@if(sizeOf($userAlbums) < 1)
<p>It seems, what you do not have albums created. You can create it {{ HTML::link('albums','here') }}.</p>
@endif
<div class="row">
    @for ($i = 0; $i < sizeOf($userAlbums); $i++)
    <div class="col-sm-6 col-md-4">
        <div class="thumbnail">
            <h3>{{ $userAlbums[$i]->album_name }}</h3>

            <a href="{{ URL::to('albums/'.$userAlbums[$i]->album_id) }}">
                @if($userAlbums[$i]->album_title_photo_thumb_url && is_file($userAlbums[$i]->album_title_photo_thumb_url))
                {{ HTML::image($userAlbums[$i]->album_title_photo_thumb_url, $userAlbums[$i]->album_short_description) }}
                @else
                {{ HTML::image('assets/img/NoAlbumArt.jpg', $userAlbums[$i]->album_short_description, array('width' => '200', 'height' => '200')) }}
                @endif
            </a>
            <div class="caption photo-link" data-id="{{ $userAlbums[$i]->album_id }}">
                <p>{{ $userAlbums[$i]->album_short_description }} </p>
                <p id="delete-album-data" data-albumid="{{ $userAlbums[$i]->album_id }}">
                    {{ HTML::link(URL::to('albums/'.$userAlbums[$i]->album_id), 'Edit', array('class' => 'btn btn-primary', 'role' => 'button')) }}
                    {{ Form::submit('Delete album', array('id' => 'delete-album-in-user-page', 'class' => 'btn btn-danger')) }}
                </p>
            </div>
        </div>
    </div>
    @endfor
</div>

    <!--<p>{{ Form::select('title_photo', array(
        'Cats' => array('leopard' => 'Leopard'),
        'Dogs' => array('spaniel' => 'Spaniel'),
        )) }}</p>-->