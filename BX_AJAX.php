<?
//подключаем пролог ядра bitrix
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//устанавливаем заголовок страницы
$APPLICATION->SetTitle("AJAX");
//подключение ядра и расширения ajax 
   CJSCore::Init(array('ajax'));
//определение переменной $sidAjax 
   $sidAjax = 'testAjax';
// ответ страницы в случае ajax запроса ajax_form=testAjax
if(isset($_REQUEST['ajax_form']) && $_REQUEST['ajax_form'] == $sidAjax){
// очистка буфера 
   $GLOBALS['APPLICATION']->RestartBuffer();
// вывести JSON 
   echo CUtil::PhpToJSObject(array(
            'RESULT' => 'HELLO',
            'ERROR' => ''
   ));
   die();
}

?>
<div class="group">
   <div id="block"></div >
   <div id="process">wait ... </div >
</div>
<script>
   window.BXDEBUG = true;
function DEMOLoad(){
   // скрытие блока с id=block
   BX.hide(BX("block"));
   // показать блок с id=process
   BX.show(BX("process"));
   // загрузка JSON со страницы и передача в функцию DEMOResponse
   BX.ajax.loadJSON(
      '<?=$APPLICATION->GetCurPage()?>?ajax_form=<?=$sidAjax?>',
      DEMOResponse
   );
}
function DEMOResponse (data){
   // сообщить в console данные переданные в функцию
   BX.debug('AJAX-DEMOResponse ', data);
   // вывести в елемен с id=block значение data.RESULT
   BX("block").innerHTML = data.RESULT;
   // показать блок с id=block
   BX.show(BX("block"));
   // скрытие блока с id=process
   BX.hide(BX("process"));
// Вызов пользовательского события DEMOUpdate. Не отработает т.к. часть кода где объявляется реакция на события DEMOUpdate закомментирована
   BX.onCustomEvent(
      BX(BX("block")),
      'DEMOUpdate'
   );
}
// После полной загрузки начать выполнение функции
BX.ready(function(){
   /*
   BX.addCustomEvent(BX("block"), 'DEMOUpdate', function(){
      window.location.href = window.location.href;
   });
   */
//   скрытие елемента с id=block и id=progress
   BX.hide(BX("block"));
   BX.hide(BX("process"));
   // объявление обработчика click на элементы с классом css_ajax'
    BX.bindDelegate(
      document.body, 'click', {className: 'css_ajax' },
      function(e){
         if(!e)
            e = window.event;
         
         DEMOLoad();
         return BX.PreventDefault(e);
      }
   );
   
});

</script>
<div class="css_ajax">click Me</div>
<?
//подключаем эпилог ядра bitrix
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
