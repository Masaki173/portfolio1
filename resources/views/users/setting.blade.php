@extends('layouts.posts')
@section('title', 'myapp')
@section('content')
<form action="update" method ="post" enctype="multipart/form-data" class="user-detail">
  @method('put')
  @csrf
  <label>アイコン選択:  <input type="file"  name="icon" accept="icon/png, icon/jpeg, icon/jpg"></input></label>
  <textarea name="name" placeholder="名前を変更しましょう"></textarea>
  <textarea name="profile" placeholder="自己紹介を書きましょう"></textarea>
  <button type=submit>追加</button>
 </form>
 @endsection
