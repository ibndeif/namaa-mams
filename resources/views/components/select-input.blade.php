@props(['disabled' => false , 'options'=>[], 'value'=>''])

<select {{ $disabled ? 'disabled' : '' }}{!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>
    @foreach($options as $key=>$text)

    <option value="{{$key}}" {{ $key == $value?'selected':'' }}>{{$text}}</option>
    @endforeach
</select>
