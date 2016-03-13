@extends('master')

@include('component.loading')

@section('title','书籍类别')

@section('content')
    <div class="weui_cells_title">选择书籍的类别</div>
    <div class="weui_cells weui_cell_split">
        <div class="weui_cell weui_cell_select">
            <div class="weui_cell_primary">
                <select class="weui_select" name="category">
                    @foreach($categorys as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="weui_cells weui_cells_access category_list">


    </div>

@endsection

@section('my-js')
    <script type="text/javascript">
        getCategory();
        $('.weui_select').change(function(event) {
            getCategory();
        });


        function getCategory() {
            var parent_id = $('.weui_select option:selected').val();
            $.ajax({
                type:"GET",
                url:"/service/category/parent_id/"+parent_id,
                dataType: 'json',
                cache: false,
                success: function(data){
                    if(data == null) {
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html('服务端错误');
                        setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                        return;
                    }

                    if(data.status !=0) {
                        $('.bk_toptips').show();
                        $('.bk_toptips span').html(data.message);
                        setTimeout(function() {$('.bk_toptips').hide();}, 2000);
                        return;
                    }

                    $('.category_list').html('');
                    for(var i=0;i<data.categorys.length;i++) {
                        var url_product = 'cate'  ;
                        var cate = '<a class="weui_cell" href="'+url_product+'">'+
                                '<div class="weui_cell_bd weui_cell_primary">'+
                                '<p>'+data.categorys[i].name+'</p>'+
                                '</div>'+
                                '<div class="weui_cell_ft"></div>'+
                                '</a>';
                        $('.category_list').append(cate);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
        }
    </script>

@endsection