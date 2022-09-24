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
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">QTY</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>
                                <a class="text-heading font-semibold"
                                    href="{{ route('items.index') }}?id={{ $item->id }}">
                                    {{ $item->name }}
                                </a>
                            </td>
                            <td>
                                {{ $item->price }}
                            </td>
                            <td>
                                {{ $item->qty }}
                            </td>


                            <td class="text-end">
                                <button type="button" data-url="{{ route('items.update', ['id' => $item->id]) }}"
                                    data-name="{{ $item->name }}" data-price="{{ $item->price }}" data-qty="{{ $item->qty }}" data-bs-toggle="modal"
                                    data-bs-target="#updateModal"
                                    class="btn btn-sm btn-square btn-neutral text-danger-hover">
                                    U
                                </button>
                                <form action="{{ route('items.delete', ['id' => $item->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-square btn-neutral text-danger-hover">
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









    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Orders</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ isset($_GET['id']) ? route('items.store') . '?id=' . $_GET['id'] : route('items.store') }}"
                    method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="exampleFormControlInput1"
                                placeholder="Example : Soap">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Price</label>
                            <input type="number" name="price" class="form-control" id="exampleFormControlInput1"
                                placeholder="Example : 12000">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">QTY</label>
                            <input type="number" name="qty" class="form-control" id="exampleFormControlInput1"
                                placeholder="Example : 1">
                        </div>

                        @if (!isset($_GET['id']))
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">ORDER ID</label>
                                <select name="order_id" id="" class="form-select">
                                    <option value=""></option>
                                    @foreach (DB::table('orders')->get() as $order)
                                        <option value="{{ $order->id }}">{{ $order->order_code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
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
                <h5 class="modal-title" id="exampleModalLabel">Update Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="${$(e.relatedTarget).data('url')}" method="post">
                @method('PATCH')
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="exampleFormControlInput1"
                            placeholder="Example : Soap" value="${$(e.relatedTarget).data('name')}">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Price</label>
                        <input type="number" name="price" class="form-control" id="exampleFormControlInput1"
                            placeholder="Example : 12000" value="${$(e.relatedTarget).data('price')}">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">QTY</label>
                        <input type="number" name="qty" class="form-control" id="exampleFormControlInput1"
                            placeholder="Example : 1" value="${$(e.relatedTarget).data('qty')}">
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
