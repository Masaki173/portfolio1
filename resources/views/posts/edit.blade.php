@extends('layouts.creations')
@section('content')
<div class="edit-form">
<form action="/posts/update/{{$post->id}}" method ="post" autocomplete="off" class="edit-content">
  @method('put')
  @csrf
 <div class="input-title"><input type="text"  name="title" value="{{$post->title}}" style="height:35px; width:500px;"></input></div>
 <div class="input-content"><textarea name="content" style="height:250px; width:500px; ">{{$post->content}}</textarea></div>
     <div class="select-category">
  <select name="category">
    <option value="1">生活</option>
    <option value="2">社会</option>
    <option value="3">カルチャー</option>
    <option value="4">テクノロジー</option>
    <option value="5">エンタメ</option>
  </select>
  </div>
      <div class="price-content">
 @if($post->is_fee === 0)
  <label>
  <input type="radio" class="radioFee"  name="is_fee" value="0"  onclick="priceSwitch()" checked="checked">
無料
</label>
<label>
  <input type="radio" class="radioFee"  name="is_fee" value="1" onclick="priceSwitch()">
有料
</label>
<span id="pricing-form">
<label>￥<input type="tel" id="priceForm" minlength="3" name="price" value="100" style="height:30px; font-size: 70%;" required></input> JPY</label>
@else
  <label>
  <input type="radio" class="radioFee"  name="is_fee" value="0"  onclick="priceSwitch()">
無料
</label>
<label>
  <input type="radio" class="radioFee"  name="is_fee" value="1" onclick="priceSwitch()" checked="checked">
有料
</label>
<span id="pricing-form">
<label>￥<input type="tel" id="priceForm" minlength="3" name="price" value="{{$post->price}}" style="height:30px; font-size: 70%;" required></input> JPY</label>
@endif
</div>
    <div class="add-content">
  <button type=submit>追加</button>
   </div>
 </form>
 </div>
@endsection
