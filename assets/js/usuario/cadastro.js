$(function () {
    $(document).ready(function () {

        $("#repetir_senha, #senha").keyup(function() {
            if ($("#repetir_senha").val() != $("#senha").val() && $("#repetir_senha").val().length >= 6 && $("#senha").val().length >= 6) {
                $('#repetir_senha').addClass('input-erro');
                $('.span-repetir-senha').fadeIn('slow');
            } else {
                $('#repetir_senha').removeClass('input-erro');
                $('.span-repetir-senha').fadeOut('slow');
            }
          });

        $('#data_nascimento').bootstrapMaterialDatePicker({
            format: 'DD/MM/YYYY',
            lang: 'pt-br',
            cancelText: 'Cancelar',
            clearButton: true,
            clearText: 'Limpar',
            time: false
        });

        $("#btn-salvar-formulario").on('click', function () {
            startLaddaButtons();
            $('.input-erro').removeClass('input-erro');

            if ($("#repetir_senha").val() != $("#senha").val()) {
                
            }
            let dados = pegarDadosFormulario();
            console.log(dados);
            return;

            REQUESTER.enviar(REQUESTER.gerarUrl(urlForm + '/salvar'), dados, {
                type: 'POST',
                success: function (data) {
                    REQUESTER.izitoast({
                        type: 'success',
                        title: 'Sucesso',
                        message: 'Sucesso!',
                    });
                    window.location.href = baseUrl;
                },
                fnerror: function (xhr) {
                    error = xhr.hasOwnProperty('responseJSON') && xhr.responseJSON.hasOwnProperty('campos') ? xhr.responseJSON.campos : [];

                    for (i in error) {
                        $('#' + error[i]).addClass('input-erro');
                    }
                    REQUESTER.izitoast({
                        type: 'error',
                        title: 'Erro',
                        message: 'Preencha os campos obrigatórios!',
                    });

                    stopLaddaButtons();
                }
            });
        });


        function pegarDadosFormulario() {
            let dados = {};
            $("[data-bind]", "#base-formulario").each(function () {
                if ($(this).hasClass('datetimepicker')) {
                    let value = $(this).val();
                    if (value.length) {
                        value = (value + ':00').replace(/(\d{2})\/(\d{2})\/(\d{4})/, "$3-$2-$1");
                        dados[$(this).attr('data-bind')] = value;
                    } else {
                        dados[$(this).attr('data-bind')] = null;
                    }
                } else {
                    dados[$(this).attr('data-bind')] = $(this).val();
                }
            });

            return dados;
        };

        $("#btn-cancelar-formulario").on('click', function () {

            startLaddaButtons();
    
            REQUESTER.izitoast({
                type: 'warning',
                class: 'cancel',
                message: 'Deseja cancelar o cadastro?',
                timeout: 0,
                onClosing: function () {
                    stopLaddaButtons();
                },
                buttons: [
                    ['<button>Sim</button>', function (instance, toast) {
                        window.location.href = baseUrl;
                    }],
                    ['<button>Não</button>', function (instance, toast) {
                        iziToast.hide({
                            transitionOut: 'fadeOutUp',
                        }, toast);
                        stopLaddaButtons();
                    }]
                ]
            });
        });


        function startLaddaButtons() {
            arrayLadda = [];
            $(".btn-acoes-formulario, .btn-lista-formulario").each(function () {
                let ladda = Ladda.create(this);
                ladda.start();
                arrayLadda.push(ladda);
            });
        }

        function stopLaddaButtons() {
            for (i in arrayLadda) {
                arrayLadda[i].stop();
            }
            arrayLadda = [];
        }

    });



});