@extends('master')

@include('component.loading')

@section('title','书籍列表')

@section('content')
    <div class="weui_cells_title">书籍列表</div>
    <div class="weui_cells weui_cells_access">
        @foreach($products as $product)
            <a class="weui_cell" href="javascript:;">
                <div class="weui_cell_hd"><img src="{{$product->preview}}" alt=""></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <p>{{$product->name}}</p>
                    <p>{{$product->summary}}</p>
                </div>
                <div class="weui_cell_ft">说明文字</div>
            </a>
        @endforeach

    </div>

@endsection

@section('my-js')
    <script type="text/javascript">

    </script>

@endsection