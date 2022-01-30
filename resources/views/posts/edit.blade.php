@extends('layouts.creations')
@section('content')
<form action="update/{{$post->id}}" method ="post" autocomplete="off">
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
    <label>
  <input type="radio" class="radioFee"  name="is_fee" value="0"  onclick="priceSwitch()">
無料
</label>
<label>
  <input type="radio" class="radioFee"  name="is_fee" value="1" onclick="priceSwitch()">
有料
</label>
<span id="pricing-form">
<label>￥<input type="tel" minlength="3" name="price"></input> JPY</label>
</span>
  <button type=submit>追加</button>
 </form>
@endsection
