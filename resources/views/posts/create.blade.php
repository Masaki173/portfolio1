@extends('layouts.creations')
@section('content')
<form action="store" method ="post" autocomplete="off">
  @csrf
  <input type="text"  name="title"></input>
  <textarea name="content"></textarea>
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
 @error('title')
 <tr><th>Error</th>
 <td>{{$message}}</td></tr>
 @enderror
 @error('content')
 <tr><th>Error</th>
 <td>{{$message}}</td></tr>
 @enderror
 @error('is_fee')
 <tr><th>Error</th>
 <td>{{$message}}</td></tr>
 @enderror
 @endsection
