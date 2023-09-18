@props(['href' => '#', 'method'=>'', 'confirm'=>'Are you sure?'])

@if(!empty($method))
<form method="POST" action="{{$href}}">
    @csrf()
    @method($method)
    <button type="submit" class="text-blue-500 hover:text-blue-700" onclick="return confirm('{{$confirm}}')">{{ $slot }}</button>
</form>
@else
<a class="text-blue-500 hover:text-blue-700" href="{{$href}}">{{ $slot }}</a>
@endif
