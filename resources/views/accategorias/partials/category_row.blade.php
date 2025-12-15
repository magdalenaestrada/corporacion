<tr class="category-row" data-id="{{ $categoria->id }}" data-parent-id="{{ $categoria->categoria_padre_id }}" style="padding-left: {{ $level * 20 }}px;">

    <th scope="row" class="hidden">{{ $categoria->id }}</th>
    <td>{{ $categoria->codigo }}</td>
    <td class="category-name">{{ $categoria->nombre }}</td>
    @if ($categoria->categoria_padre)
        <td>{{ $categoria->categoria_padre->nombre }}</td>
    @else
        <td>N/A</td>
    @endif
    <td>{{ $categoria->created_at }}</td>
</tr>
@if ($categoria->categorias_hijas)
    @foreach ($categoria->categorias_hijas as $child)
        <tr class="subcategory-row" data-id="{{ $child->id }}" data-parent-id="{{ $categoria->id }}" style="display: none; padding-left: {{ ($level + 1) * 20 }}px;">
            @include('accategorias.partials.category_row', ['categoria' => $child, 'level' => $level + 1])
        </tr>
    @endforeach
@endif
