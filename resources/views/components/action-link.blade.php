@props(['href' => '#', 'method'=>'', 'confirm'=>'Are you sure?', 'show'=>true])

@if($show)

@if(!empty($method))
<form method="POST" action="{{$href}}">
    @csrf()
    @method($method)
    <button type="submit" {{ $attributes->merge(['class' => 'text-blue-500 hover:text-blue-700 m-1']) }} onclick="return confirm('{{$confirm}}')">{{ $slot }}</button>
</form>
@else
<a {{ $attributes->merge(['class' => 'text-blue-500 hover:text-blue-700 m-1']) }} href="{{$href}}">{{ $slot }}</a>
@endif

@endif
