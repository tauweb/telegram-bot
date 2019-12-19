<?php
namespace TelegramBot;

 /**
  * Класс библиотеки логирования системных ошибок
  *
  */
class Logger
{
    /**
     * Метод записи логов в файл и формирования строки логирования
     *
     * @param   $message    mixed   Сообщение для записи в лог
     * @param   $log_level  int     Уровень отображения бектрейса (-1 отобразить весь)
     * @param   $fileName   string  Имя файла в который будут записаны логи
     * @param   $dirname    string  Папка куда запишется лог
     */
    public static function write(
        $message,
        int $log_level = 2,
        string $fileName = 'Logs',
        string $dirName  =  'Logs'
    ) {
        if (is_array($message)) {
            $message = var_export($message, true);
        }
        
        $backtrace = debug_backtrace();
        $log_msg = '';

        if (!is_dir($dirName)) {
            mkdir($dirName, 0777, true);
        }

        if ($log_level == -1) {
            $log_level = count($backtrace)-1;
        }

        for ($i = 0; $i < $log_level; $i++)
            if ($i != $log_level-1) {
                $log_msg .= $backtrace[$log_level-$i]['file'] . ": " . $backtrace[$log_level-$i]['line'] . "\n>\t";
            } else {
                $log_msg .= $backtrace[0]['file'] . ": " . $backtrace[0]['line'] . "\n";
            }
        
        $message = "$log_msg msg:\t$message";

        if ( @!$file = fopen($dirName . DIRECTORY_SEPARATOR . "$fileName.log", 'a') ) {
            throw new \Exception('<b>Ошибка логирования: </b>Не могу открыть или создать файл для записи логов. Проверте права доступа на запись'); // TODO: Написать обработчик исключений
        }
        // Формирует сообщение в логоподобный вид
        $message = date('jS \of F Y h:i:s A')."\n\t" .strip_tags($message) . "\n\n";

        fwrite($file, $message);
        fclose($file);
    }
}