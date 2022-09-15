@component('mail::message')
<div style="text-align: center">
    <img width="150px" height="auto"
         src="https://user-images.githubusercontent.com/60192948/153716283-edd5df1b-ce00-461d-8554-c486a41768a7.png"/>
</div>
<br>

<h1 style="font-weight: bold; text-align: center">
    Your application has been updated to the following status:
</h1>

<p style="text-align: center">
    @if($status == 'submitted')
    <strong>Status</strong>: <strong style="color: #00a388">{{ucfirst($status)}}</strong>
    @elseif($status=='reviewing')
        <strong>Status</strong>: <strong style="color: #00a388">{{ucfirst($status)}}</strong>
    @elseif($status=='approved')
        <strong>Status</strong>: <strong style="color: #00a388">{{ucfirst($status)}}</strong>
    @elseif($status=='declined')
        <strong>Status</strong>: <strong style="color: red">{{ucfirst($status)}}</strong>
    @elseif($status=='resubmit')
        <strong>Status</strong>: <strong style="color: orange">{{ucfirst($status)}}</strong>
    @endif
</p>

@if($comments)
<p>
    <strong>Comment</strong>: {{$comments}}
</p>
@endif

@component('mail::button', ['url' => 'https://mothbahamas.com/application-status'])
    View Application Status
@endcomponent
Thanks,<br>
{{ config('app.name') }} <br>
Charlotte House, Charlotte Street,<br>
P.O.Box N275 Nassau, N.P.,The Bahamas<br>
<a href="https://www.mothbahamas.com">Visit Website</a>
@endcomponent
