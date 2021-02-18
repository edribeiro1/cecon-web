
$(document).ready(function () {

    const enterKey = 13;

    $(document).on('keypress', function (e) {
        if (e.keyCode == enterKey) {
            if (!$('#btn_entrar').is(":focus")) {
                $('#btn_entrar').click();
            }
        }
    });

    $('.recuperar-senha').on('click', function () {
        REQUESTER.izitoast({
            type: 'error',
            title: 'Entre em contato',
        });
    });
    $('#btn_criar_conta').on('click', function () {
        window.location.href = REQUESTER.gerarUrl('login/criar');
    });

    $('#btn_entrar').on('click', function () {
        var ladda = Ladda.create(this);
        ladda.start();

        let usuario = $.trim($('#usuario').val());
        let senha = $.trim($('#senha').val());
        let valido = true;
        let msg = "";

        $('.input-erro, .label-erro').removeClass('input-erro label-erro');

        if (usuario.length == 0) {
            $('#usuario').addClass('input-erro');
            $('label[for=usuario]').addClass('label-erro');
            valido = false;
            msg = "Preencha os campos corretamente";
        }

        if (senha.length == 0) {
            $('#senha').addClass('input-erro');
            $('label[for=senha]').addClass('label-erro');
            valido = false;
            msg = "Preencha os campos corretamente";
        }

        if (valido) {

            REQUESTER.enviar(REQUESTER.gerarUrl('login/validar'), { usuario: usuario, senha: senha }, {
                processData: true,
                contentType: "application/x-www-form-urlencoded",
                dataType: 'json',
                success: function (data) {
                    window.location.href = REQUESTER.gerarUrl('dashboard');
                }
            });
        } else {
            ladda.stop();
            REQUESTER.izitoast({
                type: 'error',
                title: 'Erro',
                message: msg
            });
        }

        // REQUESTER.enviar(REQUESTER.gerarUrl('login/validar'),)
    });
});