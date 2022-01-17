@extends('layouts.app')
@section('content')
@foreach ($follows as $follow_user)
<table>
<tr><th><a href="users/{{$follow_user->id}}"><img src="/storage/{{$follow_user->icon}}" width="35px" height="35px">{{$follow_user->name}}</a></th></tr>
<tr><td><p>{{Str::limit($follow_user->profile, 60,'...')}}</p></td></tr>
</table>
@endforeach
@endsection