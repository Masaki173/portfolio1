@extends('layouts.posts')
@section('title', 'myapp')
@section('content')
<form action="update" method ="post" enctype="multipart/form-data" class="user-detail">
  @method('put')
  @csrf
  <div class="select-icon"><label>アイコン選択:  <input type="file"  name="icon" accept="icon/png, icon/jpeg, icon/jpg"></input></label></div>
  <div class="change-name"><input type="text" name="name" class="name-setting" placeholder="名前を変更しましょう"></textarea></div>
  <div class="write-profile"><textarea name="profile" class="profile-setting" placeholder="自己紹介を書きましょう"></textarea></div>
  <button type=submit class="btn btn-primary">追加</button>
 </form>
 @endsection
