@extends('layouts.creations')
@section('content')
<div class="edit-form">
<form action="/posts/update/{{$post->id}}" method ="post" autocomplete="off" class="edit-content">
  @method('put')
  @csrf
  <table class="edit-post">
   <tr><th><input type="text"  name="title" value="{{$post->title}}" style="height:35px; width:500px; font-size: 60%;"></input></th></tr>
  <tr><td><textarea name="content" style="height:250px; width:500px; ">{{$post->content}}</textarea></td></tr>
    <tr><td>
  <select name="category">
    <option value="1">生活</option>
    <option value="2">社会</option>
    <option value="3">カルチャー</option>
    <option value="4">テクノロジー</option>
    <option value="5">エンタメ</option>
  </select>
    </td></tr>
     <tr><td>
  <button type=submit>追加</button>
   </td></tr>
   </table>
 </form>
 </div>
@endsection
