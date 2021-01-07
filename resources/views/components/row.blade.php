{{-- todo config or something for even/odd classes? --}}
<tr class="{{ $isEven ? 'even-classes' : 'odd-classes' }}">
    @foreach($formattedRow as $column)
        <td class="{{ $column->class }}">{{ $column->title }}</td>
    @endforeach
</tr>
