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






<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Orders</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('orders.store') }}" method="post">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Order Code</label>
                    <input type="text" name="order_code" class="form-control"
                        id="exampleFormControlInput1" placeholder="Example : KXPX2345">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>
</div>





<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-content">

        </div>
    </div>
</div>
@endsection



@section('js')
<script>
    $('#updateModal').on('shown.bs.modal', function(e) {
        var html = `
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Orders</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="${$(e.relatedTarget).data('url')}" method="post">
                @method('PATCH')
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Order Code</label>
                    <input type="text" name="order_code" class="form-control"
                        id="exampleFormControlInput1" placeholder="Example : KXPX2345" value="${$(e.relatedTarget).data('order_code')}">
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>`;
        $('#modal-content').html(html);
    });
</script>
@endsection
