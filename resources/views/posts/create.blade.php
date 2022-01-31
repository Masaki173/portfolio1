@extends('layouts.creations')
@section('content')
<div class="create-form">
<form action="store" method ="post" autocomplete="off" class="create-content">
  @csrf
  <table class="create-post">
  <tr><th><input type="text"  name="title" style="height:35px; width:500px; font-size: 60%;"></input></th>
    <tr><td>
   @error('title')
 <tr><th>Error</th>
 <td>{{$message}}</td></tr>
 @enderror
 </td></tr>
  <tr><td><textarea name="content" style="height:250px; width:500px;"></textarea></td></tr>
      <tr><td>
   @error('content')
 <tr><th>Error</th>
 <td>{{$message}}</td></tr>
 @enderror
 </td></tr>
  <tr><td><select name="category">
    <option value="1">生活</option>
    <option value="2">社会</option>
    <option value="3">カルチャー</option>
    <option value="4">テクノロジー</option>
    <option value="5">エンタメ</option>
  </select>
  </td></tr>
  <tr><td>
  <label>
  <input type="radio" class="radioFee"  name="is_fee" value="0"  onclick="priceSwitch()">
無料
</label>
<label>
  <input type="radio" class="radioFee"  name="is_fee" value="1" onclick="priceSwitch()">
有料
</label>

<span id="pricing-form">
<label>￥<input type="tel" minlength="3" name="price" style="height:30px; font-size: 60%;"></input> JPY</label>
</td></tr>
 <tr><td>
 @error('is_fee')
 <tr><th>Error</th>
 <td>{{$message}}</td></tr>
 @enderror
</td></tr>
<tr><td>
</span>
  <button type=submit>追加</button>
 </td></tr>
 </form>
 </div>
 @endsection
