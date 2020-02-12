<?php

if (!function_exists('getLoc')) {

    function getLoc($item) {

        switch ($item) {
            case 1:
                $data = 'Первый зал';
                break;
            case 2:
                $data = 'Второй зал';
                break;
            case 3:
                $data = 'Замок';
                break;
            case 4:
                $data = 'Третий зал';
                break;
            case 5:
                $data = 'Четвертый зал';
                break;
            case 6:
                $data = 'Центральня площадь';
                break;
            case 7:
                $data = 'Магазин';
                break;
        }

        return $data;
    }

}