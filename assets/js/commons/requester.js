var REQUESTER = {
    gerarUrl: function (url) {
       var baseUrl = $('body').attr('data-baseurl');
       return baseUrl + url;
    },
    enviar: function (url, data, config) {
       let configPadrao = {
          url: url,
          type: "POST",
          data: data,
          processData: true,
          contentType: "application/x-www-form-urlencoded",
          dataType: 'json',
          error: xhr => {
            if (typeof config.fnerror == 'function') {
                config.fnerror(xhr);
            }
            else {
                REQUESTER.izitoast({
                    type: 'error',
                    title: 'Erro',
                    message: xhr.hasOwnProperty('responseJSON') && xhr.responseJSON.hasOwnProperty('message') && xhr.responseJSON.message ? xhr.responseJSON.message : 'Erro ao executar a ação, atualize a página e tente novamente!'
                });
                Ladda.stopAll();
            }
        }
      };
 
      $.extend(configPadrao, config);
      $.ajax(configPadrao);
    },
    izitoast: function (config) {
       let configIzitoast = $.extend({
          class: 'iziToastPadrao',
          position: 'topCenter',
          close: true,
          timeout: 1500,
          buttons: [],
       }, config);
 
       if ($.type(configIzitoast.class) == "string") {
          if ($("." + configIzitoast.class).length > 0) {
              iziToast.hide({
                  transitionOut: 'fadeOut'
              }, $("." + configIzitoast.class)[0]);
          }
       }
 
       iziToast[configIzitoast.type](configIzitoast);
      
    }
 }