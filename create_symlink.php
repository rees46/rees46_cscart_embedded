<?php
/**
 * Создает симлинки в CMS из текущей директории
 * Date: 04.02.15
 * Time: 12:47
 * @author  Sergey Odintsov <sergey.odintsov@mkechinov.ru>
 */

//Если не указали директорию
if( empty($argv[1]) ) {
	echo 'Вы не указали директорию назначения, используйте: php create_symlink.php <target>' . PHP_EOL;
	exit(127);
}

//Получаем текущую директорию
$dir = realpath(__DIR__);
$dir_target = realpath($argv[1]);
echo $dir . ' ' . $dir_target . PHP_EOL;

//Пути создания симлинков
$paths = [
	'/app/addons/rees46' => 'app/addons/rees46',
	'/design/themes/basic/templates/addons/rees46' => 'design/themes/basic/templates/addons/rees46',
	'/design/themes/responsive/templates/addons/rees46' => 'design/themes/basic/templates/addons/rees46',
];

//Проходим по путям
foreach( $paths as $target => $source ) {

	//Если файл существует, удаляем его
	if( file_exists($dir_target . $target) ) {
		unlink($dir_target . $target);
	}

	//Создаем симлинк
	system("ln -s {$dir}/{$source} {$dir_target}/{$target}");
}