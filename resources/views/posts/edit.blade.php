@extends('layouts.creations')
@section('content')
<form action="update/{id}" method ="post" autocomplete="off">
  @method('put')
  @csrf
   <input type="text"  name="title" value="{{$post->title}}"></input>
  <textarea name="content">{{$post->content}}</textarea>
  <select name="category">
    <option value="1">生活</option>
    <option value="2">社会</option>
    <option value="3">カルチャー</option>
    <option value="4">テクノロジー</option>
    <option value="5">エンタメ</option>
  </select>
  <button type=submit>追加</button>
 </form>
@endsection
