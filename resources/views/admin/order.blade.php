@extends('layouts.base')

@section('content')

<div class="card shadow border-0 mb-7">
    <div class="card-header">
        <h5 class="mb-0">Orders</h5>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-nowrap">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Code Order</th>
                    <th scope="col">Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order as $item)
                    <tr>
                        <td>
                            <a class="text-heading font-semibold" href="{{ route('items.index') }}?id={{$item->id}}">
                                {{ $item->order_code }}
                            </a>
                        </td>
                        <td>
                            {{ $item->order_date }}
                        </td>

                        <td class="text-end">
                            <button type="button"
                                data-url="{{ route('orders.update', ['id' => $item->id]) }}"
                                data-order_code="{{ $item->order_code }}"
                                data-bs-toggle="modal" data-bs-target="#updateModal"
                                class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                U
                            </button>
                            <form action="{{ route('orders.delete', ['id' => $item->id]) }}"
                                method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer border-0 py-5">
        <span class="text-muted text-sm">Showing 10 items out of 250 results found</span>
    </div>
</div>
@endsection




