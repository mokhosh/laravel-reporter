{{-- todo config or something for even/odd classes? --}}
<tr class="{{ $isEven ? 'bg-gray-100' : '' }}">
    @foreach($formattedRow as $column)
        <td class="{{ $column->class }}">{{ $column->title }}</td>
    @endforeach
</tr>
