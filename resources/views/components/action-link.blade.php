@props(['href' => '#', 'type'=>'', 'confirm'=>'Are you sure?'])

@if($type === 'form')
<form method="POST" action="{{$href}}">
    @csrf()
    @method('DELETE')
    <button type="submit" class="text-blue-500 hover:text-blue-700" onclick="return confirm('{{$confirm}}')">{{ $slot }}</button>
</form>
@else
<a class="text-blue-500 hover:text-blue-700" href="{{$href}}">{{ $slot }}</a>
@endif
