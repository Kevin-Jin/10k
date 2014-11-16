/*
 * jQuery Dialog Dinâmico
 * Versão: 2.0
 */
function dAlerta(titulo, mensagem, tipo, dWidth, dHeight) {

/*
   dAlerta: Mensagens sem interação com ususário, usada somenta para passar uma mensagem;
      - titulo: Título que irá apararecer no topo da janela;
      - mensagem: Mensagem que será apresentanda para o usuário;
      - tipo: Tipo da mesagem que será apresentanda para o usuário, com opções;
         * alerta: Simbolo de alerta;
         * erro: Simbolo de alerta e a janela virá com borda vermelha contendo erro do sistema;
         * info: Mensagem meramente informativa (PADRÃO)
         ---
         Usados pelo sistema
         * confirm: Mensagem de confirmação da função dConfirma;
         * cancel: Mensagem de cacelamento da função dConfirma;
*/

    var wExiste = $("#djanela").length;
   
   if( dWidth == null ){
      vWidth = 500;
   }else{
      vWidth = dWidth;   
   }
   
   if( dHeight == null ){
      vHeight = 180;
   }else{
      vHeight = dHeight;   
   }
	
   switch( tipo ){
      case 'alerta':
         classTipo = tipo;
         preTitulo = 'Alerta - ';
      break;
      case 'erro':
         classTipo = tipo;
         preTitulo = 'Erro - ';
      break;
      case 'info':
         classTipo = tipo;
         preTitulo = 'Informação - ';
      break;
      case 'ok':
         classTipo = 'ok';
         preTitulo = 'Confirmado - ';
      break;
      case 'cancelar':
         classTipo = 'cancelar';
         preTitulo = 'Cancelado - ';
      break;
      default:
         classTipo = 'info';
         preTitulo = 'Informação - ';
   }
	
   if( wExiste == 0 ){
      $("body").prepend('<div id="djanela"><p></p></div>');
      $("#djanela p").append(mensagem);
   }
	
   $("#djanela").dialog({
      modal: true,
      resizable: false,
//      width: vWidth,
//      minHeight: vHeight,
      title: preTitulo + titulo,
      dialogClass: classTipo + " djanela-pai",
      buttons: {
      "Ok":{
            text: "Ok",
            id: "btdalerta_ok",
            class: "btn",
            click: function() {
               $(this).dialog("close");
            }
         }
      },
      close:
         function() {
            $("#djanela").remove();
         }
   });

}