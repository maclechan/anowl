<div class="text-right">
    <div class="mail-body text-right row">
        <ul class="pagination">
            <li class="footable-page-arrow"><a data-page="first" href="{!! $pages->url(1) !!} #first">首页</a></li>
            <li class="footable-page-arrow"><a data-page="prev" href="{!! $pages->previousPageUrl() !!} #prev">上一页</a></li>

            <li class="footable-page active"><a data-page="0" href="#">第{!! $pages->currentPage() !!}页</a></li>

            <li class="footable-page-arrow"><a data-page="next" href="{!! $pages->nextPageUrl() !!}">下一页</a></li>
            <li class="footable-page-arrow"><a data-page="last" href="{!! $pages->url($pages->lastPage()) !!} #last">末页</a></li>
        </ul>


        <div class="pagination pull-right col-md-1 m-l-xs ">
            <!-- Small button group -->
                <div class="input-group has-success">
                    <input type="text" id="page" value="{!! $pages->currentPage() !!}" class="input-sm form-control">
                    <span class="input-group-btn">
                        <button id="goto" class="btn btn-sm btn-primary btn-outline" type="button">跳转</button>
                    </span>
                </div>
            <!-- Small button group -->
        </div>

    </div>
</div>

{{--<script>
    $('#goto').click(function () {
        var num = $("#page").val();
        window.location.href = "{{ $breadcrumb[0]['url'] }}?page="+num
    })
</script>--}}

