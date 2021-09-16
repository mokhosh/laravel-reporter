{{-- todo config or something for even/odd classes? --}}
<tr class="{{ $isEven ? 'bg-gray-100' : '' }}">
    @foreach($formattedRow as $column)
        <td data-format="{{ $column->format }}" class="px-2 py-1 bg-opacity-50 {{ $column->class }}">{{ $column->title }}</td>
    @endforeach
</tr>
