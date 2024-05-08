<?php
declare(strict_types=1);

const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_PRINT = 3;

$operations = [
    OPERATION_EXIT => OPERATION_EXIT . '. Завершить программу.',
    OPERATION_ADD => OPERATION_ADD . '. Добавить товар в список покупок.',
    OPERATION_DELETE => OPERATION_DELETE . '. Удалить товар из списка покупок.',
    OPERATION_PRINT => OPERATION_PRINT . '. Отобразить список покупок.',
];

$items = [];
function showList (array $items): void 
{
    if (count($items)) {
        echo 'Ваш список покупок: ' . PHP_EOL;
        echo implode("\n", $items) . "\n";
    } else {
        echo 'Ваш список покупок пуст.' . PHP_EOL;
    }
};

function selectAction(array $operations): int
{
    global $items;

    showList($items);

    echo 'Выберите операцию для выполнения: ' . PHP_EOL;
    echo implode(PHP_EOL, $operations) . PHP_EOL . '> ';
    $operationNumber = (int)trim(fgets(STDIN));

    if (!array_key_exists($operationNumber, $operations)) {
        system('cls');
        echo 'Неизвестный номер операции, повторите попытку.' . PHP_EOL;
        return selectAction($operations);
    }    
    return $operationNumber;
}

function addItemToList (array &$items): void 
{
    echo "Введение название товара для добавления в список: \n> ";
    $itemName = trim(fgets(STDIN));
    $items[] = $itemName;
};
function delItemFromList (array &$items): void 
{
    if (count($items)) {
        echo 'Текущий список покупок:' . PHP_EOL;
        echo implode("\n", $items) . "\n";

        echo 'Введение название товара для удаления из списка:' . PHP_EOL . '> ';
        $itemName = trim(fgets(STDIN));

        if (in_array($itemName, $items, true) !== false) {
            while (($key = array_search($itemName, $items, true)) !== false) {
                unset($items[$key]);
            }
        }
    } else {
        echo 'Ваш список покупок пуст. Введите другую операцию.' . PHP_EOL;
    }
};
function viewList (array $items): void
{
    echo 'Ваш список покупок: ' . PHP_EOL;
    echo implode(PHP_EOL, $items) . PHP_EOL;
    echo 'Всего ' . count($items) . ' позиций. '. PHP_EOL;
    echo 'Нажмите enter для продолжения';
    fgets(STDIN);
};

do {
    system('cls');

    // do {
    //     showList($items);  

    //     echo 'Выберите операцию для выполнения: ' . PHP_EOL;
    //     // Проверить, есть ли товары в списке? Если нет, то не отображать пункт про удаление товаров
    //     echo implode(PHP_EOL, $operations) . PHP_EOL . '> ';
    //     $operationNumber = trim(fgets(STDIN));

    //     if (!array_key_exists($operationNumber, $operations)) {
    //         system('cls');

    //         echo '!!! Неизвестный номер операции, повторите попытку.' . PHP_EOL;
    //     }

    // } while (!array_key_exists($operationNumber, $operations));
    
    $operationNumber = selectAction($operations);

    echo 'Выбрана операция: '  . $operations[$operationNumber] . PHP_EOL;

    switch ($operationNumber) {
        case OPERATION_ADD:
            addItemToList($items);
            break;

        case OPERATION_DELETE:
            delItemFromList($items);
            break;

        case OPERATION_PRINT:
            viewList($items);
            break;
    }

    echo "\n ----- \n";
} while ($operationNumber > 0);

echo 'Программа завершена' . PHP_EOL;