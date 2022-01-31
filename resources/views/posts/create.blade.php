@extends('layouts.creations')
@section('content')
<form action="store" method ="post" autocomplete="off">
  @csrf
  <table class="create-post">
  <tr><th><input type="text"  name="title" style="height:35px; font-size: 60%;"></input></th>
   @error('title')
 <tr><th>Error</th>
 <td>{{$message}}</td></tr>
 @enderror
  <tr><td><textarea name="content" style="height:250px; width:250px;"></textarea></td></tr>
   @error('content')
 <tr><th>Error</th>
 <td>{{$message}}</td></tr>
 @enderror
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
 @error('is_fee')
 <tr><th>Error</th>
 <td>{{$message}}</td></tr>
 @enderror
<tr><td>
</span>
  <button type=submit>追加</button>
 </td></tr>
 </form>
 @endsection
