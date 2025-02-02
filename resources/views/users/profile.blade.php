<div>
    <h1>User Profile</h1>
    @if($name=='')
       <p>Your name is: Unknown{{-- {{$name??'Unknown'}} --}}</p>
    @else
       {{-- <p>Your name is: {{$name}}</p> --}}
       <p>{{ __('messages.greeting', ['name'=>$name]) }}</p>
       <p> {{$name2}}</p>
    @endif
</div>