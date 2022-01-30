@extends('layouts.creations')
@section('content')
<form action="update/{id}" method ="post">
  @method('put')
  @csrf
  <input type="text"  name="title" value="{{$post->title}}"></input>
  <textarea name="content">{{$post->content}}</textarea>
  <button type=submit>追加</button>
 </form>
@endsection
