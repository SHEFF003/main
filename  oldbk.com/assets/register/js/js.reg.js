var Register = function () {

    //return;
    var handleCufon = function () {
        Cufon.replace("#reg-title");
        Cufon.replace("#areg");
        Cufon.replace(".hh2");
        Cufon.replace(".reg-title");
    };

    var handleValidator = function () {

        $('#register-form').validator({
            disable: true,
            feedback: {
                success: 'text-success',
                error: 'text-danger'
            },
            rules: {
                password: {
                    required: true
                }
            },
            custom: {
                'check-login': function ($el) {

                    var login = $el.val().trim();

                    if (!login.length || login.length > 20 || login.length < 4) {
                        return '��� ����� ��������� �� 4 �� 20 ��������';
                    }

                    var reg = /^[a-zA-Z�-��-�0-9-][a-zA-Z�-��-�0-9_ -]+[a-zA-Z�-��-�0-9-]$/;
                    if (reg.test(login) == false) {
                        return "��� ������ �������� ������ �� ���� �������� ���� ����������� ��������, ����, �������� '_', '-' � �������. ��� �� ����� ���������� ��� ������������� �������� ��� �������� '_'.";
                    }

                    reg = /__/;
                    if (reg.test(login) != false) {
                        return "�� ������ �������������� ������ ����� 1 ������� '_'";
                    }

                    reg = /  /;
                    if (reg.test(login) != false) {
                        return "�� ������ �������������� ������ ����� 1 ������� �������";
                    }

                    reg = /--/;
                    if (reg.test(login) != false) {
                        return "�� ������ �������������� ������ ����� 1 ������� '-'";
                    }

                    var lastch = 0;
                    var ccount = 0;
                    var bfound = false;

                    for (var i = 0; i < login.length; i++) {
                        if (lastch != login[i]) {
                            lastch = login[i];
                            ccount = 0;
                        } else {
                            ccount++;
                            if (ccount >= 2) {
                                bfound = true;
                                break;
                            }
                        }
                    }

                    if (bfound) {
                        return '�� ������ �������������� ����� 3 ������ ���������� �������� ��� ����� 4-� ����.';
                    }


                    //???
                    /*var reg1 = /[a-zA-Z]/, reg2 = /[�-��-�]/;
                     if(reg1.test(login) != false && reg2.test(login) != false) {
                     return 'ya zdes';
                     }*/

                    return false;
                },
                'check-email': function ($el) {
                    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                    var address = $el.val();
                    if (reg.test(address) == false) {
                        return '������������ e-mail';
                    }
                    return false;
                }
            }
        });

    };

    var handleBtnEvents = function () {

        $('.form-group').on('click', '#checklogin', function (el) {

            el.preventDefault();

            var login = $('#fnlogin').val();

            if (!login || login.length < 4 || login.length > 20) {
                $(el.delegateTarget).find('input').focus();
                return false;
            }

            $.ajax({
                type: "POST",
                dataType: 'json',
                url: '/f/reg/checklogin',
                data: {'login': login},
                success: function (data) {
                    if (data.status) {
                        if (data.exist) {
                            $(el.currentTarget)
                                .removeClass('badge-success')
                                .addClass('badge-danger')
                                .text('������. �������� ������ ����� � ������� ��� ������');

                            $(el.delegateTarget)
                                .find('input')
                                .removeClass('is-valid')
                                .addClass('is-invalid');
                        } else {
                            $(el.currentTarget)
                                .removeClass('badge-danger')
                                .addClass('badge-success')
                                .text('��������. ����� ���������� �����������.');

                            $(el.delegateTarget)
                                .find('input')
                                .removeClass('is-invalid')
                                .addClass('is-valid');
                        }
                    }
                }
            });
        });
    };

    var handlePreloader = function () {
        var $preloader = $('#page-preloader'), $spinner = $preloader.find('.spinner');
        $spinner.fadeOut();
        $preloader.delay(750).fadeOut('slow');
    };

    var handleEventSubmit = function () {
        window.addEventListener('load', function () {
            var form = document.getElementById('register-form');
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        }, false);
    };


    return {
        init: function () {
            handleCufon();
            // handleEventSubmit();
            handleValidator();
            handleBtnEvents();
            handlePreloader();
        }
    };
}();

Register.init();

