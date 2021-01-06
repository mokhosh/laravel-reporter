<tr class="{{ $formattedRow->class }}">
    @foreach($formattedRow->columns as $column)
        <td>{{ $column }}</td>
    @endforeach
</tr>
