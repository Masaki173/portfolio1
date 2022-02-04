@extends('layouts.creations')
@section('content')
<div class="create-form">
<form action="store" method ="post" autocomplete="off" class="create-content">
<table class="create-post" >
  @csrf
  <tr><td>
   @error('title')
 <tr><td>Error:{{$message}}</td></tr>
 @enderror
 </td></tr>
<div class="input-title"><input type="text"  name="title" placeholder="記事のタイトルを書きましょう" class="title-form"></input></div>
   <div class="post-type">
  <div class="select-category">
  <label>
  カテゴリ
  <select name="category">
    <option value="1">生活</option>
    <option value="2">社会</option>
    <option value="3">カルチャー</option>
    <option value="4">テクノロジー</option>
    <option value="5">エンタメ</option>
  </select>
  </label>
   </div>
   <div class="fee-paragraph">販売設定</div>
   <div class="price-content">
  <label>
  <input type="radio" class="radioFee"  name="is_fee" value="0"  onclick="priceSwitch()" checked="checked">
無料
</label>
<label>
  <input type="radio" class="radioFee"  name="is_fee" value="1" onclick="priceSwitch()">
有料
</label>
<span id="pricing-form" class="price-span">
<label>￥<input type="tel" id="priceForm" minlength="3" name="price" value="100" style="height:30px; font-size: 70%;" required></input> JPY</label>
</span>
</div>
 <div>
 @error('is_fee')
 <p>Error:{{$message}}</p>
 @enderror
</div>
 </div>
 <tr><td>
   @error('content')
 <tr><td>Error:{{$message}}</td></tr>
 @enderror
 </td></tr>
<div class="input-content"><textarea name="content" placeholder="記事の内容を書きましょう" class="content-form"></textarea></div>
<div class="add-content">
  <button type=submit class="article-btn btn btn-primary">追加</button>
 </div>
 </form>
 </div>
 @endsection
