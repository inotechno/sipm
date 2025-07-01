<tr>
    <td>{{ $inventory->id }}</td>
    <td>{{ $inventory->serial_number }}</td>
    <td>{{ $inventory->name }}</td>
    <td>{{ $inventory->category->name }}</td>
    <td>{{ $inventory->warehouse->name }}</td>
    <td>{{ $inventory->condition }}</td>
    <td>{{ number_format($inventory->price) }}</td>
    <td>{{ $inventory->stock }} {{ $inventory->unit }}</td>
    <td>{{ $inventory->type }}</td>
    <td>{{ $inventory->purchase_date->format('d M Y') }}</td>
    <td>
        <button class="btn btn-info btn-sm" wire:click="editItem({{ $inventory->id }})"><i class="mdi mdi-pencil"></i></button>
        <button class="btn btn-danger btn-sm" wire:click="removeItem({{ $inventory->id }})"><i class="mdi mdi-delete"></i></button>
    </td>
</tr>
