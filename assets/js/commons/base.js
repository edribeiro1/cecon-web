var baseUrl = $('body').attr('data-baseurl');
$(document).ready(function () {
   
    $('#logout').click(function (e) {
        e.stopPropagation()
    });


    $(document).on('click', '#editar_tela', () => {

        if ( $('.edicao-tela').is(':visible') ) {
            $('.edicao-tela').slideUp('slow', () => {
                $('.corpo-tela').slideDown('slow')
            });
        } else {
            $('.corpo-tela').slideUp('slow', () => {
                $('.edicao-tela').slideDown('slow')
            });
        }
    
    });

    $(document).on('click', '#salvar_corpo_tela', function() {
        let textoCorpo = $('#corpo_tela').val();
        let titutoTela = $('#titulo_tela').val();
        let idTela = parseInt($('#id_tela').val());

        if (idTela > 0 && textoCorpo.length && titutoTela.length) {
            REQUESTER.enviar(REQUESTER.gerarUrl('TextosTelas/salvar/' + idTela), {
                'titulo': titutoTela,
                'corpo': textoCorpo
            }, {
                type: 'POST',
                success: function (data) {
                    REQUESTER.izitoast({
                        type: 'success',
                        title: 'Sucesso',
                        message: 'Alterado com sucesso',
                    });
                    location.reload();
                },
                fnerror: function (xhr) {
                    REQUESTER.izitoast({
                        type: 'error',
                        title: 'Erro',
                        message: 'Erro ao editar tela',
                    });
                }
            });
        } else {

            REQUESTER.izitoast({
                type: 'error',
                title: 'Erro',
                message: 'É necessário um texto para salvar',
            });
    
        }

    
    });
});

function dataHoraBR(dataEN) {
    return dataEN.replace(/(\d{4})-(\d{2})-(\d{2})/, "$3/$2/$1");
}
