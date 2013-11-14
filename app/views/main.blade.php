<?php/*
$nick = 'hamsteris';
$pass = Hash::make('123');
DB::insert('insert into users (username, password, email) values (?,?,?)', array($nick, $pass, 'email@gmail.com'));*/
?>
    <div class="image-navigation">All resent photos:</div>

    @for ($i = 0; $i < sizeOf($photos_url); $i++)
        <a href="{{ $photos_url[$i] }}" class="photo-link">
            <img src="{{ $photos_url[$i] }}" alt="First">
        </a>
    @endfor
    <div class="clear"></div>

    <div style="" class="image-navigation">
      <span>
        Previos | Next</br>
      </span>
    </div>