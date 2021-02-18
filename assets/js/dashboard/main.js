$(document).ready(function () {

    $(document).on('click', '#btn_microempreendedor', () => window.location.href = REQUESTER.gerarUrl('microempreendedor') );
    $(document).on('click', '#btn_logotipo', () => window.location.href = REQUESTER.gerarUrl('logotipo') );
    $(document).on('click', '#btn_certificado', () => window.location.href = REQUESTER.gerarUrl('microempreendedor') );
    $(document).on('click', '#btn_material', () => window.location.href = REQUESTER.gerarUrl('microempreendedor') );
    $(document).on('click', '#btn_usuarios', () => window.location.href = REQUESTER.gerarUrl('usuario') );
    $(document).on('click', '#btn_cursos', () => window.location.href = REQUESTER.gerarUrl('cursos') );

    REQUESTER.enviar(REQUESTER.gerarUrl('dashboard/dadosIniciais'), {}, {
        success: function (data) {

            if ($('#nome_usuario').length) {
                $('#nome_usuario').text(data.nome);
            }

            if ($('#contato_usuario').length) {
                $('#contato_usuario').text(data.telefone);
            }

            if ($('#inscricao_usuario').length) {
                $('#inscricao_usuario').text(data.inscricao);
            }

        }
    });
});