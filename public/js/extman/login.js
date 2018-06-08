/**
 * 管理后台登陆
 * @author maclechan@qq.com
 * @date    2018/5/11
 */
var Login = function() {

    var handleLogin = function() {
        var form1    = $('.login-form');
        var error1   = $('.alert-danger', form1);
        //var success1 = $('.alert-success', form1);

        $('.login-form').validate({

            submitHandler: function (form) {
                error1.hide();
                var param = $(".login-form").serialize();
                var url   = $('.login-form').attr('action');
                success1.show();
                error1.hide();
                $.ajax({
                    url: url,
                    type: "post",
                    dataType: "json",
                    data:param,

                    success : function(result) {
                        if(result.code == 200){
                            error1.hide();
                            $('.submit_success').html('验证成功 等待进入！');
                            success1.show();
                            setTimeout(function(){
                                    location.href = "/home";},
                                1000);

                        }else{
                            $('.submit_error').html(result.msg);
                            error1.show();
                            success1.hide();
                        }

                        return false;

                    }
                });
                return false;
            }
        });

        $('.login-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.login-form').validate().form()) {
                    $('.login-form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });

    }

    return {
        //main function to initiate the module
        init: function() {
            handleLogin();
        }
    };

}();
