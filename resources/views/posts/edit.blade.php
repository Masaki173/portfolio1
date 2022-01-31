@extends('layouts.creations')
@section('content')

<form action="/posts/update/{{$post->id}}" method ="post" autocomplete="off">
  @method('put')
  @csrf
  <table class="edit-post">
   <input type="text"  name="title" value="{{$post->title}}" style="height:35px; width:500px; font-size: 60%;"></input>
  <textarea name="content" style="height:250px; width:500px; ">{{$post->content}}</textarea>
  <select name="category">
    <option value="1">生活</option>
    <option value="2">社会</option>
    <option value="3">カルチャー</option>
    <option value="4">テクノロジー</option>
    <option value="5">エンタメ</option>
  </select>
    <label>
  <button type=submit>追加</button>
   </table>
 </form>
@endsection
