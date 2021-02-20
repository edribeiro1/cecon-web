$(function () {
    $(document).ready(function () {
        $('#cpf').mask('000.000.000-00');
        $('#rg').mask('00.000.000-0');
        $('#telefone').mask('(00) 00000-0000');
        $('#data_nascimento').mask('00/00/0000');

        $("#repetir_senha, #senha").keyup(function() {
            if ($("#repetir_senha").val() != $("#senha").val() && $("#repetir_senha").val().length >= 3 && $("#senha").val().length >= 3) {
                $('#repetir_senha').addClass('input-erro');
                $('.span-repetir-senha').fadeIn('fast');
            } else {
                $('#repetir_senha').removeClass('input-erro');
                $('.span-repetir-senha').fadeOut('fast');
            }
          });

        // $('#data_nascimento').bootstrapMaterialDatePicker({
        //     format: 'DD/MM/YYYY',
        //     lang: 'pt-br',
        //     cancelText: 'Cancelar',
        //     clearButton: true,
        //     clearText: 'Limpar',
        //     time: false
        // });

        $(document).on('focus', 'input', function() {
            $(this).removeClass('input-erro');
        });

        $(document).on('change', '#termos_de_uso', (e) => {
            if($(e.target).is(':checked')) {
                $("#btn-salvar-formulario").prop('disabled', false);
            } else {
                $("#btn-salvar-formulario").prop('disabled', true);
            }
        });

        $("#btn-salvar-formulario").on('click', function () {
            startLaddaButtons();
            $('.input-erro').removeClass('input-erro');
            
            if (validarFormulario()) {
                let dados = pegarDadosFormulario();

                REQUESTER.enviar(REQUESTER.gerarUrl('login/salvar'), dados, {
                    type: 'POST',
                    success: function (data) {
                        REQUESTER.izitoast({
                            type: 'success',
                            title: 'Sucesso',
                            message: 'Sucesso!',
                            onClosing: () => {
                                window.location.href = baseUrl;
                            }
                        });
                       
                    },
                    fnerror: function (xhr) {
                        errors = xhr.hasOwnProperty('responseJSON') && xhr.responseJSON.hasOwnProperty('fields') ? xhr.responseJSON.fields : [];

                        for (i in errors) {
                            if (errors[i].hasOwnProperty('field')) {
                                $('#' + errors[i].field).addClass('input-erro');
                            }

                            if (errors[i].hasOwnProperty('message')) {
                                REQUESTER.izitoast({
                                    type: 'error',
                                    title: 'Erro',
                                    message: errors[i].message,
                                });
                            }
                        }
    
                        stopLaddaButtons();
                    }
                });
            } else {
                stopLaddaButtons();
            }
           
        });


        function validarFormulario() {
            let valido = true;
            $("[data-bind]", "#base-formulario").each(function () {
                if ($(this).attr('required')) {
                    let value = $(this).val().trim();
                    if (!value || value.length == 0) {
                        valido = false;
                        $(this).addClass('input-erro');
                    }
                }
            });

            if (!valido) {
                REQUESTER.izitoast({
                    type: 'error',
                    title: '',
                    message: 'Preencha os campos obrigatórios!',
                });
                return false;
            }

            if ($("#senha").val().length < 6) {
                REQUESTER.izitoast({
                    type: 'error',
                    title: '',
                    message: 'Senha deve conter no mínimo 6 caracteres!',
                });

                $("#senha").addClass('input-erro');

                return false;
            }

            if ($("#repetir_senha").val() != $("#senha").val()) {
                REQUESTER.izitoast({
                    type: 'error',
                    title: '',
                    message: 'Senhas devem ser iguais!',
                });
                $("#senha").addClass('input-erro');
                $("#repetir_senha").addClass('input-erro');
                $('.span-repetir-senha').fadeIn('fast');
                return false;
            }

            return valido;
        }

        function pegarDadosFormulario() {
            let dados = {};
            $("[data-bind]", "#base-formulario").each(function () {
                if ($(this).hasClass('datetimepicker')) {
                    let value = $(this).val();
                    if (value.length) {
                        value = value.replace(/(\d{2})\/(\d{2})\/(\d{4})/, "$3-$2-$1");
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