<?php
use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

function fn_rees46_generate_info()
{
  if (Registry::get('addons.rees46.shop_id') == '') {
    return '
    <p>
      <h3>Для того, чтобы включить систему рекомендаций:</h3>
      <ol>
        <li>Перейдите на <a href="REES46.com" target="_blank">http://rees46.com/</a>;</li>
        <li>Зарегистрируйтесь;</li>
        <li>Создайте магазин;</li>
        <li>Введите код вашего магазина в поле ниже;</li>
        <li>Нажмите "Сохранить".</li>
        <li>Ознакомьтесь с <a href="http://memo.mkechinov.ru/display/R46D/CS-Cart" target="_blank">подробной инструкцией</a> по настройке модуля.</li>
      </ol>
    </p>
    ';
  } else {
    return '
    <p>Перейти к <a href="http://rees46.com/shops" target="_blank">статистике эффективности</a> работы системы персонализации.</p>
    <p>Прочитать <a href="http://memo.mkechinov.ru/display/R46D/CS-Cart" target="_blank">подробную инструкцию</a> по настройке модуля.</p>
    ';
  }
}
