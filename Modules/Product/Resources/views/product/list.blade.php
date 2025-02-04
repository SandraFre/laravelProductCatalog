@extends('administration::layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Products
                        <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary">Add new</a>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Price</th>
                                <th>Categories</th>
                                <th>Active</th>
                                <th>Actions</th>
                            </tr>

                            @foreach($list as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        @if ($item->images->isNotEmpty())
                                            <img src="{{Storage::url($item->images->first()->file)}}" width="100px">
                                        @endif
                                    </td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->slug }}</td>
                                    <td>{{ PriceFormatter::formatWithCurrencyCode($item->price)  }}</td>
                                    <td>
                                        @foreach($item->categories as $category)
                                            {{$category->title}}<br>
                                        @endforeach
                                    </td>
                                    <td class="@if ($item->active) text-success @else text-danger @endif">
                                        {{ $item->active ? 'Yes' : 'No'   }}
                                    </td>
                                    <td>
                                        <a href="{{ route('products.edit', ['product' => $item->id]) }}"
                                           class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('products.destroy', ['product' => $item->id]) }}"
                                              method="post">
                                            @csrf
                                            @method('delete')
                                            <input type="submit"
                                                   onclick="return confirm('Do you really want to delete a record?');"
                                                   class="btn btn-sm btn-danger" value="Delete">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                    </div>

                    <div class="card-footer">
                        {{ $list->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
